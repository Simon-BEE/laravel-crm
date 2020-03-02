<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use App\Models\StatusProject;
use App\Models\User;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::paginate(20);
        
        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $status = StatusProject::all();
        $customers = User::customers()->get();

        return view('projects.create', compact('status', 'customers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ProjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request)
    {
        $data = $request->all();

        Project::create($data);

        return redirect()->route('projects.index')->with([
            'alertType' => 'success',
            'alertMessage' => 'Le projet a bien été défini.',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        $project->load('user');

        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $status = StatusProject::all();
        $customers = User::customers()->get();

        return view('projects.edit', compact('project', 'customers', 'status'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ProjectRequest  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectRequest $request, Project $project)
    {
        $project->update($request->all());

        return redirect()->route('projects.show', $project)->with([
            'alertType' => 'success',
            'alertMessage' => "Le projet : $project->name, a bien été modifié.",
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('projects.index')->with([
            'alertType' => 'success',
            'alertMessage' => "Le projet $project->name, a bien été supprimé.",
        ]);
    }
}
