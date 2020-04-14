<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    protected $guarded = ['id'];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
