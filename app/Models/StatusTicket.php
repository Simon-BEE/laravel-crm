<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusTicket extends Model
{
    protected $fillable = ['name'];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
