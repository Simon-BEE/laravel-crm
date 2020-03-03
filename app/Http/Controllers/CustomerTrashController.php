<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class CustomerTrashController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::onlyTrashed()->paginate(20);

        return view('archives.customers.index', compact('users'));
    }

    /**
     * Restore the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore(int $id)
    {
        $customer = User::withTrashed()->findOrFail($id);
        $customer->restore();

        return redirect()->route('customers.show', $customer)->with([
            'alertType' => 'success',
            'alertMessage' => 'Le client a bien été restauré.',
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
        $customer = User::withTrashed()->findOrFail($id);
        $customer->forceDelete();

        return redirect()->route('archives.customers.index')->with([
            'alertType' => 'success',
            'alertMessage' => "Le client a été supprimé définitivement.",
        ]);
    }
}
