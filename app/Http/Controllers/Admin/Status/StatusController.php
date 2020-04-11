<?php

namespace App\Http\Controllers\Admin\Status;

use App\Models\Color;
use App\Models\Status;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statuses = Status::all();
        return view('admin.status.index', compact('statuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $colors = Color::all();
        return view('admin.status.create', compact('colors'));
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
            'name' => 'required|string|max:255|unique:statuses,name',
            'color_id' => 'required|integer|exists:colors,id',
        ]);

        Status::create($data);

        return redirect()->route('admin.status.index')->with([
            'alertType' => 'success',
            'alertMessage' => 'Le statut a bien été ajouté.',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function edit(Status $status)
    {
        $colors = Color::all();
        return view('admin.status.edit', compact('status', 'colors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Status $status)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:statuses,name,' . $status->id,
            'color_id' => 'required|integer|exists:colors,id',
        ]);

        $status->update($data);

        return redirect()->route('admin.status.index')->with([
            'alertType' => 'success',
            'alertMessage' => 'Le statut a bien été modifié.',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function destroy(Status $status)
    {
        $status->delete();

        return redirect()->route('admin.status.index')->with([
            'alertType' => 'success',
            'alertMessage' => 'Le statut a bien été supprimé.',
        ]);
    }
}
