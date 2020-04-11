<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusTicket extends Model
{
    protected $fillable = ['name', 'color_id'];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }
}
