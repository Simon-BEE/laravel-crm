<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        return auth()->user()->isAdmin ? redirect()->route('admin.home') : redirect()->route('customer.home');
    }
}
