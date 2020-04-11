<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceStatus extends Model
{
    protected $fillable = ['name', 'color_id'];

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }
}
