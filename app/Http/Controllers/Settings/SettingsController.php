<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\SettingsUserRequest;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        return view('settings.index', ['user' => auth()->user()]);
    }

    public function update(SettingsUserRequest $request)
    {
        $data = $request->validated();

        auth()->user()->update([
            'settings' => json_encode(
                ['pagination' => (int)$data['pagination']]
                )
        ]);

        return redirect()->back()->with([
            'alertType' => 'success',
            'alertMessage' => "Vos paramètres ont été enregistrés.",
        ]);
    }
}
