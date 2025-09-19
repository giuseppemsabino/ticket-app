<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Project;
use App\Models\Role;
use App\Models\Status;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{
    use AuthorizesRequests;

    /**
     * Dashboard view
     */
    public function dashboard()
    {
        $user = Auth::user();

        if ($user->roles->contains('id', 2) || $user->roles->contains('id', 3) || $user->roles->contains('id', 4)) {
            // Tecnico, admin o superadmin: vedono tutti i ticket
            $tickets = Ticket::with('comments.user')->get();
        } else {
            // Altri utenti → solo i propri ticket
            $tickets = Ticket::where('user_id', $user->id)
            ->with('comments.user')
            ->get();
        }

        if ($user->roles->contains('id', 4)) {
            // Superadmin → tutti i progetti
            $projects = Project::all();
        } else {
            // Altri utenti → solo i progetti assegnati
            $projects = $user->projects;
        }

        $areas = Area::all();
        $statuses = Status::all();
        $userLog = [
            'id' => Auth::user()->id,
            'name' => Auth::user()->name,
            'role_id' => Auth::user()->roles->first()->id

        ];

        $userName = User::select('id', 'name')->get();

        // Ottieni tutti gli utenti con il ruolo di tecnico (role_id = 2)
        $technicians = User::whereHas('roles', function ($query) {
            $query->where('role_id', 2);
        })->get();


        $comments = $tickets->flatMap(function ($ticket) {
            return $ticket->comments;
        });

        return inertia('Dashboard', compact('tickets', 'areas', 'statuses', 'projects', 'userLog', 'technicians', 'comments', 'userName'));
    }




    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $user = Auth::user();

        if ($user->roles->contains('id', 2) || $user->roles->contains('id', 3) || $user->roles->contains('id', 4)) {

            $tickets = Ticket::with('comments.user')->get();
        } else {
            // Altri utenti → solo i propri ticket
            $tickets = Ticket::where('user_id', $user->id)
            ->with('comments.user')
            ->get();
        }
        if ($user->roles->contains('id', 4)) {
            // Superadmin → tutti i progetti
            $projects = Project::all();
        } else {
            // Altri utenti → solo i progetti assegnati
            $projects = $user->projects;
        }
        $areas = Area::all();
        $statuses = Status::all();
        $projects = Project::all();
        $userLog = [
            'id' => Auth::user()->id,
            'name' => Auth::user()->name,
            'role_id' => Auth::user()->roles->first()->id

        ];
        $userName = User::select('id', 'name')->get();

        // Ottieni tutti gli utenti con il ruolo di tecnico (role_id = 2)
        $technicians = User::whereHas('roles', function ($query) {
            $query->where('role_id', 2);
        })->get();




        return inertia('Tickets/TicketIndex', compact('tickets', 'areas', 'statuses', 'projects', 'userLog', 'technicians', 'userName'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        // Se tecnico (2), admin (3) o superadmin (4): tutti i progetti
        if ($user->roles->contains('id', 2) || $user->roles->contains('id', 3) || $user->roles->contains('id', 4)) {

            $projects = Project::all();

        } else {

            // Utente normale: solo i progetti assegnati
            $projects = $user->projects; 

        }

        $areas = Area::all();
        $statuses = Status::all();
        $userLog = [
            'id' => Auth::user()->id,
            'name' => Auth::user()->name,
            'role_id' => Auth::user()->roles->first()->id
        ];
        // dd($userLog, $areas, $statuses, $projects);  //? se vuoi vedere i dati che stai passando alla vista decommenta questa linea

        return inertia('Tickets/TicketCreate', compact('areas', 'statuses', 'projects', 'userLog'));
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


        if ($request->hasFile('u_images')) {

            $user_image_url = Storage::putFile("user_images", $data['u_images']);
            $newTicket->u_images = $user_image_url;
        }

        $newTicket->save();

        return redirect()->route('tickets.show', $newTicket);
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        $ticket->load('comments.user');

        $user = Auth::user();

        // Controllo accesso
        if (
            !$user->roles->contains('id', 2)
            && !$user->roles->contains('id', 3)
            && !$user->roles->contains('id', 4)
            && $ticket->user_id !== $user->id
        ) {
            abort(403, 'Accesso non autorizzato');
        }


        // dd($ticket->comments);
        $comments = $ticket->comments;
        $areas = Area::all();
        $statuses = Status::all();
        $projects = Project::all();
        $userLog = [
            'id' => Auth::user()->id,
            'name' => Auth::user()->name,
            'role_id' => Auth::user()->roles->first()->id
        ];

        $userName = User::select('id', 'name')->get();
        $technicians = User::whereHas('roles', function ($query) {
            $query->where('role_id', 2);
        })->get();


        return inertia('Tickets/TicketShow', compact('ticket', 'areas', 'statuses', 'projects', 'userLog', 'technicians', 'comments', 'userName'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        $this->authorize('update', $ticket);

        $user = User::with('roles')->find(Auth::id());


        $ticket->load('comments.user');

        $comments = $ticket->comments;

        $areas = Area::all();
        $statuses = Status::all();
        $projects = Project::all();
        $userLog = [
            'id' => Auth::user()->id,
            'name' => Auth::user()->name,
            'role_id' => Auth::user()->roles->first()->id
        ];
        $userName = User::select('id', 'name')->get();
        $technicians = User::whereHas('roles', function ($query) {
            $query->where('role_id', 2);
        })->get();

        return inertia('Tickets/TicketEdit', compact('ticket', 'areas', 'statuses', 'projects', 'userLog', 'technicians', 'userName'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        $user = User::with('roles')->find(Auth::id());


        $data = $request->all(); // Ottieni tutti i dati dalla richiesta

        // Aggiorna i campi del ticket con i nuovi dati
        $ticket->project_id = $data['project_id'];
        $ticket->area_id = $data['area_id'];
        $ticket->status_id = $data['status_id'];
        $ticket->description = $data['description'];
        $ticket->assigned_to = $data['assigned_to'];
        $ticket->user_visibility = isset($data['user_visibility']) ? (bool)$data['user_visibility'] : false;


        if (array_key_exists('t_images', $data)) {
            if ($ticket->t_images) {
                Storage::delete($ticket->t_images);
            }
            $ticket->t_images = Storage::putFile("tech_images", $data['t_images']);
        }

        dd($data);

        //dd($request->all()); //? se vuoi vedere i dati che stai passando alla vista decommenta questa linea

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

        return inertia('Tickets/TicketArchive', compact('tickets', 'areas', 'statuses', 'projects', 'technicians'));
    }

    public function restore($id)
    {
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
