<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusProject extends Model
{
    protected $fillable = ['name', 'color_id'];

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }
}
