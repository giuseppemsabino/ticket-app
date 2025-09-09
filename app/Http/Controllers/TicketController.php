<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Project;
use App\Models\Role;
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
        // Ottieni tutti gli utenti con il ruolo di tecnico (role_id = 2)
        $technicians = User::whereHas('roles', function ($query) {
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
        $areas = Area::all();
        $statuses = Status::all();
        $projects = Project::all();
        $userLog = [
            'id' => Auth::user()->id,
            'name' => Auth::user()->name
        ];
        // dd($userLog, $areas, $statuses, $projects);  //? se vuoi vedere i dati che stai passando alla vista decommenta questa linea

        return inertia('Tickets/Create', compact('areas', 'statuses', 'projects', 'userLog'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all(); // Ottieni tutti i dati dalla richiesta

        $newTicket = new Ticket();

        $newTicket->project_id = $data['project_id'];
        $newTicket->area_id = $data['area_id'];
        $newTicket->status_id = 1; // Imposta lo status iniziale a "Aperto" (ID 1)
        $newTicket->description = $data['description'];
        $newTicket->user_id = Auth::user()->id;

        // dd($data); //? se vuoi vedere i dati che stai passando alla vista decommenta questa linea
        $newTicket->save();

        return redirect()->route('tickets.show', $newTicket);
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        $ticket->load('comments.user');

        // dd($ticket->comments);
        $comments = $ticket->comments;
        $areas = Area::all();
        $statuses = Status::all();
        $projects = Project::all();
        $userLog = [
            'id' => Auth::user()->id,
            'name' => Auth::user()->name

        ];
        $technicians = User::whereHas('roles', function ($query) {
            $query->where('role_id', 2);
        })->get();

        return inertia('Tickets/Show', compact('ticket', 'areas', 'statuses', 'projects', 'userLog', 'technicians', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        $user = User::with('roles')->find(Auth::id());

        if ($user->roles->contains('id', 1)) {
            abort(403, 'Unauthorized action.');
        }
         $ticket->load('comments.user');

        // dd($ticket->comments);
        $comments = $ticket->comments;

        $areas = Area::all();
        $statuses = Status::all();
        $projects = Project::all();
        $userLog = [
            'id' => Auth::user()->id,
            'name' => Auth::user()->name
        ];
        $technicians = User::whereHas('roles', function ($query) {
            $query->where('role_id', 2);
        })->get();

        return inertia('Tickets/Edit', compact('ticket', 'areas', 'statuses', 'projects', 'userLog', 'technicians'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        $user = User::with('roles')->find(Auth::id());

        if ($user->roles->contains('id', 1)) {
            abort(403, 'Unauthorized action.');
        }
        $data = $request->all(); // Ottieni tutti i dati dalla richiesta

        // Aggiorna i campi del ticket con i nuovi dati
        $ticket->project_id = $data['project_id'];
        $ticket->area_id = $data['area_id'];
        $ticket->status_id = $data['status_id'];
        $ticket->description = $data['description'];
        $ticket->assigned_to = $data['assigned_to'];

        // Salva le modifiche al database
        $ticket->update();

        return redirect()->route('tickets.show', $ticket);
    }

    public function archive()
    {
        $tickets = Ticket::onlyTrashed()->get();
        $areas = Area::all();
        $statuses = Status::all();
        $projects = Project::all();
        
        $technicians = User::whereHas('roles', function ($query) {
            $query->where('role_id', 2);
        })->get();

        return inertia('Tickets/Archive', compact('tickets', 'areas', 'statuses', 'projects', 'technicians'));
    }

    public function restore($id){
        $ticket = Ticket::withTrashed()->findOrFail($id);
        $ticket->restore();

        return redirect()->route('tickets.index')->with('success', 'Ticket restored successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
       
        // If the ticket is already soft-deleted, force delete it
        if ($ticket->trashed()) {
            $ticket->forceDelete();
            return redirect()->route('tickets.archive');
        }
        
        $ticket->delete();

        return redirect()->route('tickets.index');
    }

    public function forceDestroy($id)
    {
        $ticket = Ticket::withTrashed()->findOrFail($id);
        $ticket->forceDelete();

        return redirect()->route('tickets.archive')->with('success', 'Ticket permanently deleted.');
    }
}

