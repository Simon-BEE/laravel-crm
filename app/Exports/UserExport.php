<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class UserExport implements FromQuery
{
    use Exportable;

    protected $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function query()
    {
        return User::query()->where('id', $this->id);
    }
}
