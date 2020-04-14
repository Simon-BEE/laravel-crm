<?php

namespace App\Http\Controllers\Admin\Issue;

use App\Http\Controllers\Controller;
use App\Models\Issue;

class IssueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.issues.index', [
            'issues' => Issue::all(),
        ]);
    }

    /**
     * Store a newly created or update the specified resource in storage.
     *
     * @param  \App\Models\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function storeOrUpdate(Issue $issue = null)
    {
        $data = request()->validate([
            'name' => 'required|string|max:255',
            ]);

        if ($issue) {
            $issue->update($data);

            return redirect()->route('admin.issues.index')->with([
                'alertType' => 'success',
                'alertMessage' => 'Le problème a bien été édité.',
            ]);
        }

        Issue::create($data);

        return redirect()->route('admin.issues.index')->with([
            'alertType' => 'success',
            'alertMessage' => 'Le nouveau problème a bien été ajouté.',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function destroy(Issue $issue)
    {
        $issue->delete();

        return redirect()->route('admin.issues.index')->with([
            'alertType' => 'success',
            'alertMessage' => 'Le problème a bien été supprimé.',
        ]);
    }
}
