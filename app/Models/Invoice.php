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
        // switch ($this->status->name) {
        //     case 'Provisoire':
        //         $statement = "<span class=\"badge " . $this->status->color->name . "\"> " . $this->status->name . "</span>";
        //         break;
        //     case 'Envoyée':
        //         $statement = "<span class=\"badge " . $this->status->color->name . "\"> " . $this->status->name . "</span>";
        //         break;
        //     case 'Payée':
        //         $statement = "<span class=\"badge " . $this->status->color->name . "\"> " . $this->status->name . "</span>";
        //         break;
        //     case 'Annulée':
        //         $statement = "<span class=\"badge " . $this->status->color->name . "\"> " . $this->status->name . "</span>";
        //         break;

        //     default:
        //         $statement = "<span class=\"badge badge-dark\">Error</span>";
        //         break;
        // }

        return "<span class=\"badge badge-" . $this->status->color->name . "\"> " . $this->status->name . "</span>";
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
