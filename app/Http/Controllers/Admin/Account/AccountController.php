<?php

namespace App\Http\Controllers\Admin\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditUserRequest;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('admin.account.index', compact('user'));
    }

    public function update(EditUserRequest $request)
    {
        $this->saveUserWithHisAddress($request->validated(), auth()->user());

        return redirect()->route('admin.home')->with([
            'alertType' => $type ?? 'success',
            'alertMessage' => $message ?? "Votre compte a bien été mis à jour.",
        ]);
    }
}
