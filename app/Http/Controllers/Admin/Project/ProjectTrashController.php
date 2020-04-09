<?php

namespace App\Http\Controllers\Admin\Project;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProjectTrashController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::onlyTrashed()->paginate(config('app.pagination'));
        // dd($projects->first()->user->delete);

        return view('admin.archives.projects.index', compact('projects'));
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

        return redirect()->route('admin.projects.show', $project)->with([
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

        return redirect()->route('admin.archives.projects.index')->with([
            'alertType' => 'success',
            'alertMessage' => "Le projet a été supprimé définitivement.",
        ]);
    }
}
