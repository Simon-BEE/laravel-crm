<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = ['id'];

    public function getActualStatusAttribute()
    {
        $status = $this->status->name;

        $color = ($status === 'Terminé') ? 'info' : (($status === 'Abandonné') ? 'danger' : (($status === 'En développement') ? 'success' : 'secondary'));

        return "<span class='badge badge-$color'>$status</span>";
    }

    // RELATIONS

    public function estimates()
    {
        return $this->hasMany(Estimate::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->belongsTo(StatusProject::class);
    }
}
