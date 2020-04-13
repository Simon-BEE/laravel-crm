<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $fillable = ['name', 'color_id'];

    protected $with = ['color'];

    // RELATIONS

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }
}
