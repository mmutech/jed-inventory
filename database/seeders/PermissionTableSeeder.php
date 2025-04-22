<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create User permissions
        Permission::create(['name' => 'create-user']);
        Permission::create(['name' => 'modify-user']);
        Permission::create(['name' => 'view-user']);
        Permission::create(['name' => 'index-user']);

        // Create Role permissions
        Permission::create(['name' => 'create-role']);
        Permission::create(['name' => 'modify-role']);
        Permission::create(['name' => 'view-role']);
        Permission::create(['name' => 'index-role']);

        // Create Permission permissions
        Permission::create(['name' => 'create-permission']);
        Permission::create(['name' => 'modify-permission']);
        Permission::create(['name' => 'view-permission']);
        Permission::create(['name' => 'index-permission']);

        // create PO permissions
        Permission::create(['name' => 'create-po']);
        Permission::create(['name' => 'modify-po']);
        Permission::create(['name' => 'view-po']);
        Permission::create(['name' => 'index-po']);

        // create sra permissions
        Permission::create(['name' => 'create-sra']);
        Permission::create(['name' => 'modify-sra']);
        Permission::create(['name' => 'view-sra']);
        Permission::create(['name' => 'index-sra']);

        // create scn permissions
        Permission::create(['name' => 'create-scn']);
        Permission::create(['name' => 'modify-scn']);
        Permission::create(['name' => 'view-scn']);
        Permission::create(['name' => 'index-scn']);

        // create srcn permissions
        Permission::create(['name' => 'create-srcn']);
        Permission::create(['name' => 'modify-srcn']);
        Permission::create(['name' => 'view-srcn']);
        Permission::create(['name' => 'index-srcn']);

        // create srin permissions
        Permission::create(['name' => 'create-srin']);
        Permission::create(['name' => 'modify-srin']);
        Permission::create(['name' => 'view-srin']);
        Permission::create(['name' => 'index-srin']);

        // Report Permission
        Permission::create(['name' => 'general-report']);
        Permission::create(['name' => 'journal-report']);
        Permission::create(['name' => 'bin-card']);

        // create store permissions
        Permission::create(['name' => 'create-store']);
        Permission::create(['name' => 'edit-store']);
        Permission::create(['name' => 'stores']);

        // create Unit permissions
        Permission::create(['name' => 'create-unit']);
        Permission::create(['name' => 'edit-unit']);
        Permission::create(['name' => 'units']);

        // create location permissions
        Permission::create(['name' => 'create-location']);
        Permission::create(['name' => 'edit-location']);
        Permission::create(['name' => 'locations']);

        // create codes permissions
        Permission::create(['name' => 'create-codes']);
        Permission::create(['name' => 'edit-codes']);
        Permission::create(['name' => 'codes']);

        // create category permissions
        Permission::create(['name' => 'create-category']);
        Permission::create(['name' => 'edit-category']);
        Permission::create(['name' => 'categories']);

        // create class permissions
        Permission::create(['name' => 'create-class']);
        Permission::create(['name' => 'edit-class']);
        Permission::create(['name' => 'classes']);

        // create general ledger permissions
        Permission::create(['name' => 'create-ledger']);
        Permission::create(['name' => 'edit-ledger']);
        Permission::create(['name' => 'ledgers']);

        // Other Permission
        Permission::create(['name' => 'hod-approval']);
        Permission::create(['name' => 'mds-approval']);
        Permission::create(['name' => 'fa-approval']);
        Permission::create(['name' => 'quality-check']);
        Permission::create(['name' => 'haop-approval']);
        Permission::create(['name' => 'recommend']);
        Permission::create(['name' => 'issue']);
        Permission::create(['name' => 'receive']);
        Permission::create(['name' => 'others']);
        Permission::create(['name' => 'stocks']);

        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'Admin']);
        $role1->givePermissionTo('create-user');
        $role1->givePermissionTo('modify-user');
        $role1->givePermissionTo('index-user');
        $role1->givePermissionTo('view-user');

        $role1->givePermissionTo('create-role');
        $role1->givePermissionTo('modify-role');
        $role1->givePermissionTo('index-role');
        $role1->givePermissionTo('view-role');

        $role1->givePermissionTo('create-permission');
        $role1->givePermissionTo('modify-permission');
        $role1->givePermissionTo('index-permission');
        $role1->givePermissionTo('view-permission');

        $role1->givePermissionTo('mds-approval');
        $role1->givePermissionTo('haop-approval');
        $role1->givePermissionTo('hod-approval');
        $role1->givePermissionTo('quality-check');
        $role1->givePermissionTo('recommend');
        $role1->givePermissionTo('fa-approval');
        $role1->givePermissionTo('issue');
        $role1->givePermissionTo('receive');
        $role1->givePermissionTo('others');
        $role1->givePermissionTo('stocks');

        $role1->givePermissionTo('general-report');
        $role1->givePermissionTo('journal-report');
        $role1->givePermissionTo('bin-card');

        $role1->givePermissionTo('create-sra');
        $role1->givePermissionTo('modify-sra');
        $role1->givePermissionTo('view-sra');
        $role1->givePermissionTo('index-sra');

        $role1->givePermissionTo('create-scn');
        $role1->givePermissionTo('modify-scn');
        $role1->givePermissionTo('view-scn');
        $role1->givePermissionTo('index-scn');

        $role1->givePermissionTo('create-srcn');
        $role1->givePermissionTo('modify-srcn');
        $role1->givePermissionTo('view-srcn');
        $role1->givePermissionTo('index-srcn');

        $role1->givePermissionTo('create-srin');
        $role1->givePermissionTo('modify-srin');
        $role1->givePermissionTo('view-srin');
        $role1->givePermissionTo('index-srin');

        $role2 = Role::create(['name' => 'Store-Officer']);
        $role2->givePermissionTo('create-sra');
        $role2->givePermissionTo('modify-sra');
        $role2->givePermissionTo('view-sra');
        $role2->givePermissionTo('index-sra');

        $role2->givePermissionTo('create-scn');
        $role2->givePermissionTo('modify-scn');
        $role2->givePermissionTo('view-scn');
        $role2->givePermissionTo('index-scn');

        $role2->givePermissionTo('create-srcn');
        $role2->givePermissionTo('modify-srcn');
        $role2->givePermissionTo('view-srcn');
        $role2->givePermissionTo('index-srcn');

        $role2->givePermissionTo('create-srin');
        $role2->givePermissionTo('modify-srin');
        $role2->givePermissionTo('view-srin');
        $role2->givePermissionTo('index-srin');

        $role2->givePermissionTo('bin-card');
        $role2->givePermissionTo('issue');
        $role2->givePermissionTo('receive');

        $role3 = Role::create(['name' => 'Manager']);
        $role3->givePermissionTo('create-store');
        $role3->givePermissionTo('edit-store');
        $role3->givePermissionTo('stores');

        $role3->givePermissionTo('create-unit');
        $role3->givePermissionTo('edit-unit');
        $role3->givePermissionTo('units');

        $role3->givePermissionTo('create-location');
        $role3->givePermissionTo('edit-location');
        $role3->givePermissionTo('locations');

        $role3->givePermissionTo('create-class');
        $role3->givePermissionTo('edit-class');
        $role3->givePermissionTo('classes');

        $role3->givePermissionTo('create-codes');
        $role3->givePermissionTo('edit-codes');
        $role3->givePermissionTo('codes');

        $role3->givePermissionTo('create-category');
        $role3->givePermissionTo('edit-category');
        $role3->givePermissionTo('categories');

        $role3->givePermissionTo('create-ledger');
        $role3->givePermissionTo('edit-ledger');
        $role3->givePermissionTo('ledgers');

        $role3->givePermissionTo('hod-approval');
        $role3->givePermissionTo('recommend');
        $role3->givePermissionTo('fa-approval');
        $role3->givePermissionTo('others');
        $role3->givePermissionTo('stocks');
        $role3->givePermissionTo('receive');

        $role4 = Role::create(['name' => 'PO-Manager']);
        $role4->givePermissionTo('create-po');
        $role4->givePermissionTo('modify-po');
        $role4->givePermissionTo('view-po');
        $role4->givePermissionTo('index-po');

        // gets all permissions via Gate::before rule; see AuthServiceProvider

        // create demo users
        $user = \App\Models\User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@jedplc.com',
            'staff_id' => 1234,
        ]);
        $user->assignRole($role1);
        $user->assignRole($role3);
        $user->assignRole($role4);

        $user = \App\Models\User::factory()->create([
            'name' => 'Store Officer One',
            'email' => 'store.officer1@jedplc.com',
            'staff_id' => 1235,
        ]);
        $user->assignRole($role2);

        $user = \App\Models\User::factory()->create([
            'name' => 'Store Officer Two',
            'email' => 'store.officer2@jedplc.com',
            'staff_id' => 1236,
        ]);
        $user->assignRole($role2);

        $user = \App\Models\User::factory()->create([
            'name' => 'Store Officer Three',
            'email' => 'store.officer3@jedplc.com',
            'staff_id' => 1237,
        ]);
        $user->assignRole($role2);

        $user = \App\Models\User::factory()->create([
            'name' => 'Manager',
            'email' => 'manager@jedplc.com',
            'staff_id' => 1238,
        ]);
        $user->assignRole($role3);

        $user = \App\Models\User::factory()->create([
            'name' => 'PO Manager',
            'email' => 'po.manager@jedplc.com',
            'staff_id' => 1239,
        ]);
        $user->assignRole($role4);

    }
}
