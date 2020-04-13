<?php

namespace App\Http\Middleware;

use Closure;

class AuthHasAnAddress
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!auth()->user()->hasAddress) {
            return redirect()->route('admin.account.edit')->with([
                'alertType' => 'danger',
                'alertMessage' => 'Vous devez mettre à jour votre adresse avant de procéder à une facturation.',
            ]);
        }

        return $next($request);
    }
}
