<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'edit products']);
        Permission::create(['name' => 'delete products']);
        Permission::create(['name' => 'publish products']);
        Permission::create(['name' => 'unpublish products']);

        // create roles and assign existing permissions
        $role0 = Role::create(['name' => 'user']);

        $role1 = Role::create(['name' => 'helper']);
        $role1->givePermissionTo('edit products');
        $role1->givePermissionTo('delete products');

        $role2 = Role::create(['name' => 'admin']);
        $role2->givePermissionTo('publish products');
        $role2->givePermissionTo('unpublish products');

        $role3 = Role::create(['name' => 'super-admin']);

        // create demo users
        $user = Factory(User::class)->create([
            'name' => 'Example Simple User',
            'email' => 'sample@example.com',
            // factory default password is 'secret'
        ]);
        $user->assignRole($role0);

        $user = Factory(User::class)->create([
            'name' => 'Example Helper User',
            'email' => 'test@example.com',
            // factory default password is 'secret'
        ]);
        $user->assignRole($role1);

        $user = Factory(User::class)->create([
            'name' => 'Example Admin User',
            'email' => 'admin@example.com',
            // factory default password is 'secret'
        ]);
        $user->assignRole($role2);

        $user = Factory(User::class)->create([
            'name' => 'Example Super-Admin User',
            'email' => 'superadmin@example.com',
            // factory default password is 'secret'
        ]);
        $user->assignRole($role3);
    }
}
