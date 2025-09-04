<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Project;
use App\Models\Status;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = Ticket::all();
        $areas = Area::all();
        $statuses = Status::all();
        $projects = Project::all();
        $userLog = [
            'id' => Auth::user()->id,
            'name' => Auth::user()->name
            
        ];
        $technicians = User::whereHas('roles', function($query) {
            $query->where('role_id', 2);
        })->get();



        //  dd($technicians);

        return inertia('Tickets/Index', compact('tickets', 'areas', 'statuses', 'projects', 'userLog', 'technicians'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Tickets/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
         $tickets = Ticket::all();
        $areas = Area::all();
        $statuses = Status::all();
        $projects = Project::all();
        $userLog = [
            'id' => Auth::user()->id,
            'name' => Auth::user()->name
            
        ];
        $technicians = User::whereHas('roles', function($query) {
            $query->where('role_id', 2);
        })->get();

        return inertia('Tickets/Show', compact('ticket', 'areas', 'statuses', 'projects', 'userLog', 'technicians'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
