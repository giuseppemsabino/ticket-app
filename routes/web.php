<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard', [
        'userLog' => [
            'id' => Auth::id(),
            'name' => Auth::user()->name,
            'role_id' => Auth::user()->roles()->first()?->id,
        ],
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('tickets/{ticket}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

Route::get('tickets/archive', [TicketController::class, 'archive'])->name('tickets.archive');
Route::get('tickets/{ticket}/restore', [TicketController::class, 'restore'])->name('tickets.restore');
Route::delete('tickets/{ticket}/force', [TicketController::class,'forceDestroy'])->name('tickets.forceDestroy');
Route::resource('tickets', TicketController::class);



require __DIR__.'/auth.php';
