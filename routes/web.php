<?php

use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\TicketController as AdminTicketController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\ProfileController;
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

Route::get('/dashboard', [AdminTicketController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth', 'verified'])->group(function () {

    // !Rotte protette da autenticazione e verifica email

    // *Rotte resource per la gestione dei progetti
    Route::resource('projects', AdminProjectController::class);
    
    // *Rotte resource per la gestione degli utenti (solo per superadmin)
    Route::resource('users', AdminUserController::class);

    // *Rotte per la gestione dei commenti
    Route::post('tickets/{ticket}/comments', [AdminCommentController::class, 'store'])->name('comments.store');
    Route::delete('comments/{comment}', [AdminCommentController::class, 'destroy'])->name('comments.destroy');

    // *Rotte per la gestione dei ticket soft-deleted
    Route::get('tickets/archive', [AdminTicketController::class, 'archive'])->name('tickets.archive');
    Route::get('tickets/{ticket}/restore', [AdminTicketController::class, 'restore'])->name('tickets.restore');
    Route::delete('tickets/{ticket}/force', [AdminTicketController::class,'forceDestroy'])->name('tickets.forceDestroy');

    // *Rotte resource per i ticket
    Route::resource('tickets', AdminTicketController::class);
});



require __DIR__.'/auth.php';
