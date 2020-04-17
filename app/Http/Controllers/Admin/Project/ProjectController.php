<?php

namespace App\Http\Controllers\Admin\Project;

use App\Models\User;
use App\Models\Project;
use App\Models\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::with(['customer', 'status']);
        if (request()->has('customers')) {
            \Search::searchByCustomer($projects, request()->customers);

            \Search::searchByStatus($projects, request()->status);

            \Search::searchByKeywords($projects, request()->keywords, ['name', 'news', 'body']);

            if (is_numeric(request()->rows) && request()->rows >= 10 && request()->rows <= 50) {
                $perPage = request()->rows;
            }
        }

        $projects = $projects->paginate($perPage ?? config('app.pagination'));
        $customers = User::customersWithProjects();
        $statuses = Status::all();

        return view('admin.projects.index', compact('projects', 'customers', 'statuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $status = Status::all();
        $customers = User::customers()->get();

        return view('admin.projects.create', compact('status', 'customers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ProjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request)
    {
        $data = $request->validated();
        $data['admin_id'] = auth()->id();

        Project::create($data);

        return redirect()->route('admin.projects.index')->with([
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
        // $project->load('user');
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $status = Status::all();
        $customers = User::customers()->get();

        return view('admin.projects.edit', compact('project', 'customers', 'status'));
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

        return redirect()->route('admin.projects.show', $project)->with([
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

        return redirect()->route('admin.projects.index')->with([
            'alertType' => 'success',
            'alertMessage' => "Le projet $project->name, a bien été supprimé.",
        ]);
    }
}
