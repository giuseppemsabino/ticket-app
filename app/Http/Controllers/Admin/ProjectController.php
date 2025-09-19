<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::all();
        
        return inertia('Projects/ProjectIndex', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $areas = Area::all();

        return inertia('Projects/ProjectCreate', compact('areas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        // Creazione progetto
        $newProject = new Project();
        $newProject->name = $data['name'];
        $newProject->description = $data['description'];

        $newProject->save();

        // Attach aree 
        if ($request->has('areas')) {
            $newProject->areas()->attach($data['areas']);
        }

        return redirect()->route('projects.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $areas = Area::all();

        return inertia('Projects/ProjectEdit', compact('project', 'areas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $data = $request->all();

        $project->name = $data['name'];
        $project->description = $data['description'];
        $project->save();

        
        if (isset($data['areas'])) {
            $project->areas()->sync($data['areas']);
        }

        return redirect()->route('projects.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->areas()->detach();
        $project->delete();


        return redirect()->route('projects.index');
    }
}
