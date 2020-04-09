<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $guarded = ['id'];

    public function getCompleteAddress()
    {
        if (!$this->address_1) {
            return 'Cette adresse n\'a pas était renseignée.';
        }

        return $this->address_1 . ' ' . $this->address_2 . ' ' . $this->city . ' ' . $this->zipcode . ', ' . $this->country;
    }

    public function getPartialAddress()
    {
        if (!$this->city) {
            return 'Cette adresse n\'a pas était renseignée.';
        }

        return $this->city . ', ' . $this->country;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
