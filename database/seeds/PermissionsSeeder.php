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
        $adminRole = Role::create(['name' => 'admin']);

        $admin = User::create([
            'firstname' => 'Simon',
            'lastname' => 'Bée',
            'email' => 'simonbee1303@gmail.com',
            'password' => Hash::make('123123'),
            'role_id' => $adminRole->id,
            'knew' => true,
            'changed' => true,
        ]);

        User::create([
            'firstname' => 'André',
            'lastname' => 'Testor',
            'email' => 'dédé@gmail.com',
            'password' => Hash::make('123123'),
            'role_id' => $customerRole->id,
        ]);

        $admin->address()->update([
            'address_1' => '3 route de la bergerette',
            'city' => 'Terjat',
            'zipcode' => '03420',
            'country' => 'France',
            'phone_1' => '0617841434',
        ]);

        factory(User::class, 30)->create();
    }
}
