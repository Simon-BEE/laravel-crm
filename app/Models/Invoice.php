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
        switch ($this->status->name) {
            case 'Pending':
                $statement = "<span class=\"badge badge-warning\"> " . $this->status->name . "</span>";
                break;
            case 'Sent':
                $statement = "<span class=\"badge badge-info\"> " . $this->status->name . "</span>";
                break;
            case 'Paid':
                $statement = "<span class=\"badge badge-success\"> " . $this->status->name . "</span>";
                break;
            case 'Cancelled':
                $statement = "<span class=\"badge badge-danger\"> " . $this->status->name . "</span>";
                break;

            default:
                $statement = "<span class=\"badge badge-dark\">Error</span>";
                break;
        }

        return $statement;
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
        return $this->belongsTo(InvoiceStatus::class);
    }
}
