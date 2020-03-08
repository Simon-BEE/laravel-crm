<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectTrashController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::onlyTrashed()->paginate(20);
        // dd($projects->first()->user->delete);

        return view('archives.projects.index', compact('projects'));
    }

    /**
     * Restore the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore(int $id)
    {
        $project = Project::withTrashed()->findOrFail($id);
        $project->restore();

        return redirect()->route('projects.show', $project)->with([
            'alertType' => 'success',
            'alertMessage' => 'Le projet a bien été restauré.',
        ]);
    }

    /**
     * Remove permanently the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $project = Project::withTrashed()->findOrFail($id);
        $project->forceDelete();

        return redirect()->route('archives.projects.index')->with([
            'alertType' => 'success',
            'alertMessage' => "Le projet a été supprimé définitivement.",
        ]);
    }
}
