<?php

namespace App\Http\Controllers\Admin\Priority;

use App\Http\Controllers\Controller;
use App\Models\Priority;

class PriorityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.priorities.index', [
            'priorities' => Priority::all(),
        ]);
    }

    /**
     * Store a newly created or update the specified resource in storage.
     *
     * @param  \App\Models\Priority  $priority
     * @return \Illuminate\Http\Response
     */
    public function storeOrUpdate(Priority $priority = null)
    {
        $data = request()->validate([
            'name' => 'required|string|max:255',
        ]);

        if ($priority) {
            $priority->update($data);

            return redirect()->route('admin.priorities.index')->with([
                'alertType' => 'success',
                'alertMessage' => 'La priorité a bien été éditée.',
            ]);
        }

        Priority::create($data);

        return redirect()->route('admin.priorities.index')->with([
            'alertType' => 'success',
            'alertMessage' => 'La priorité a bien été ajoutée.',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Priority  $priority
     * @return \Illuminate\Http\Response
     */
    public function destroy(Priority $priority)
    {
        $priority->delete();

        return redirect()->route('admin.priorities.index')->with([
            'alertType' => 'success',
            'alertMessage' => 'La priorité a bien été supprimée.',
        ]);
    }
}
