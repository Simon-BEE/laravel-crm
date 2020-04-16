<?php

namespace App\Http\Controllers\Customer\Project;

use App\Models\Status;
use App\Models\Project;
use App\Http\Controllers\Controller;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::mine();
        if (request()->has('status')) {

            if (request()->status > 0) {
                $searchData = request()->validate(['status' => 'required|exists:statuses,id']);
                $projects->where('status_id', $searchData['status']);
            }

            \Search::searchByKeywords($projects, request()->keywords, ['name', 'news', 'body']);

            if (is_numeric(request()->rows) && request()->rows >= 10 && request()->rows <= 50) {
                $perPage = request()->rows;
            }
        }

        $projects = $projects->paginate($perPage ?? config('app.pagination'));
        $statuses = Status::all();

        return view('customer.projects.index', compact('projects', 'statuses'));
    }

    /**
     * Display the specified resource.
     *
     * @param  App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        $this->authorize('show', $project);

        return view('customer.projects.show', compact('project'));
    }
}
