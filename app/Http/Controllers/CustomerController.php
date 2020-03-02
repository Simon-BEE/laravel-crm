<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Mail\SendPasswordMail;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::customers()->paginate(20);

        return view('customers.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\CustomerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerRequest $request)
    {
        $data = $request->all();
        $data['role_id'] = Role::where('name', 'customer')->first()->id;

        $user = User::create($data);

        $message = 'Le client a bien été enregistré en base de données.';

        if ($request->know) {
            $this->passwordToEmail($user);
            $message = $message . ' Un email avec un mot de passe lui a été envoyé.';
        }

        return redirect()->route('customers.index')->with([
            'alertType' => 'success',
            'alertMessage' => $message,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(User $customer)
    {
        $customer->load('projects');
        return view('customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(User $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\CustomerRequest  $request
     * @param  \App\Models\User  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerRequest $request, User $customer)
    {
        $customer->update($request->all());

        return redirect()->route('customers.show', $customer)->with([
            'alertType' => 'success',
            'alertMessage' => "Le client $customer->name a bien été modifié.",
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $customer)
    {
        $customer->delete();

        return redirect()->route('customers.index')->with([
            'alertType' => 'success',
            'alertMessage' => "Le client $customer->name a bien été supprimé.",
        ]);
    }

    /**
     * Set know to true and send a password by email
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function sendPassword(User $user)
    {
        if (!$user->know) {
            $this->passwordToEmail($user);
            $user->know = true;
            $user->save();

            $type = "success";
            $message ="Un email content un mot de passe a bien été envoyé à $user->name.";
        }

        return redirect()->route('customers.index')->with([
            'alertType' => $type ?? 'danger',
            'alertMessage' => $message ?? "Le client $user->name a déjà reçu son mot de passe.",
        ]);
    }

    /**
     * Just call mailable SendPasswordMail
     *
     * @param User $user
     * @return void
     */
    private function passwordToEmail(User $user)
    {
        Mail::to($user->email)->send(new SendPasswordMail($user));
    }
}
