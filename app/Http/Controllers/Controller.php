<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function saveUserWithHisAddress(array $data, User $user = null)
    {
        if (!$user) {
            $user = User::create($data['user']);
        }else{
            $user->update($data['user']);
        }

        $user->address()->update($data['address']);

        return $user;
    }

}
