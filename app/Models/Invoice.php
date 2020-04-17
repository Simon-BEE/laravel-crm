<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        "items" => "array",
    ];

    public function getItsStatusAttribute()
    {
        return "<span class=\"badge badge-" . $this->status->color->name . "\"> " . $this->status->name . "</span>";
    }

    public function getDocumentIdAttribute()
    {
        return $this->invoice_id;
    }

    // RELATIONS

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
