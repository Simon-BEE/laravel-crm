<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\EditUserRequest;
use App\Http\Requests\PasswordUserRequest;

class AccountController extends Controller
{
    public function edit()
    {
        return view('account.edit', ['user' => auth()->user()]);
    }

    public function update(EditUserRequest $request)
    {
        $user = auth()->user();

        $this->saveUserWithHisAddress($request->validated(), $user);

        return redirect()->route($user->isAdmin ? 'admin.home' : 'customer.home')->with([
            'alertType' => $type ?? 'success',
            'alertMessage' => $message ?? "Votre compte a bien été mis à jour.",
        ]);
    }

    public function password()
    {
        return view('account.password');
    }

    public function passwordUpdate(PasswordUserRequest $request)
    {
        $data = $request->validated();
        $user = auth()->user();

        if ($user->changed) {
            if (!Hash::check($data['password'], $user->password)) {
                return redirect()->back()->with([
                    'alertType' => 'danger',
                    'alertMessage' => "Votre ancien mot de passe ne correspond pas.",
                ]);
            }
        }

        $user->password = Hash::make($data['new_password']);
        !$user->changed ? $user->changed = true : null;
        $user->save();

        return redirect()->route($user->isAdmin ? 'admin.home' : 'customer.home')->with([
            'alertType' => 'success',
            'alertMessage' => "Mot de passe mis à jour.",
        ]);
    }
}
