<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customerRole = Role::create(['name' => 'customer']);
        $managerRole = Role::create(['name' => 'manager']);

        User::create([
            'firstname' => 'Simon',
            'lastname' => 'Bée',
            'email' => 'simonbee1303@gmail.com',
            'password' => Hash::make('123123'),
            'role_id' => $managerRole->id,
        ]);

        User::create([
            'firstname' => 'André',
            'lastname' => 'Testor',
            'email' => 'dédé@gmail.com',
            'password' => Hash::make('123123'),
            'role_id' => $customerRole->id,
        ]);

        factory(User::class, 30)->create();
    }
}
