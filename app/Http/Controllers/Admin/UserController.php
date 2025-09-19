<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
class UserController extends Controller
{
    use AuthorizesRequests;
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);
        $users = User::with(['roles', 'projects'])->get();

        return inertia('Users/Index', compact('users'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', User::class);
        $roles = Role::all();
        $projects = Project::all();
        // dd($roles);

        return inertia('Users/Create', compact('roles', 'projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', User::class);
        $data = $request->all();

        // Creazione utente
        $newUser = new User();
        $newUser->name = $data['name'];
        $newUser->email = $data['email'];
        $newUser->password = bcrypt($data['password']);

        // dd($data);
        $newUser->save();

        // Attach ruoli (N:N)
        if ($request->has('roles')) {
            $newUser->roles()->attach($data['roles']);
        }

        // Attach progetti (N:N)
        if ($request->has('projects')) {
            $newUser->projects()->attach($data['projects']);
        }

        return redirect()->route('users.show', $newUser);
    }


    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);
        // dd($user->projects);
        return inertia('Users/Show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        $roles = Role::all();
        $projects = Project::all();

        $user->load('roles', 'projects');

        return inertia('Users/Edit', compact('user', 'roles', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {   
        $this->authorize('update', $user);
        $data = $request->all();

        $user->name = $data['name'];
        $user->email = $data['email'];

        if (!empty($data['password'])) {
            $user->password = bcrypt($data['password']);
        }

        $user->save();

        // Sync relazioni N:N
        if (isset($data['roles'])) {
            $user->roles()->sync($data['roles']);
        }

        if (isset($data['projects'])) {
            $user->projects()->sync($data['projects']);
        }

        return redirect()->route('users.show', $user);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        // Rimuovi relazioni N:N
        $user->roles()->detach();
        $user->projects()->detach();
        $user->delete();


        return redirect()->route('users.index');
    }
}
