<?php

namespace App\Http\Controllers;

use App\Models\StatusProject;
use Illuminate\Http\Request;

class StatusProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statuts = StatusProject::all();
        return view('status.projects.index', compact('statuts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('status.projects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:status_projects,name',
        ]);

        StatusProject::create($data);

        return redirect()->route('status.projects.index')->with([
            'alertType' => 'success',
            'alertMessage' => 'Le status a bien été ajouté.',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StatusProject  $statusProject
     * @return \Illuminate\Http\Response
     */
    public function destroy(StatusProject $project)
    {
        $project->delete();

        return redirect()->route('status.projects.index')->with([
            'alertType' => 'success',
            'alertMessage' => 'Le status a bien été supprimé.',
        ]);
    }
}
