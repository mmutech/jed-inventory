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

        // create ledger permissions
        Permission::create(['name' => 'view-ledger']);
        Permission::create(['name' => 'index-ledger']);

        // create bin-card permissions
        Permission::create(['name' => 'view-bin-card']);
        Permission::create(['name' => 'index-bin-card']);

        // Report Permission
        Permission::create(['name' => 'general-report']);

        // create store permissions
        Permission::create(['name' => 'create-store']);
        Permission::create(['name' => 'modify-store']);
        Permission::create(['name' => 'view-store']);
        Permission::create(['name' => 'index-store']);

        // create codes permissions
        Permission::create(['name' => 'create-codes']);
        Permission::create(['name' => 'modify-codes']);
        Permission::create(['name' => 'view-codes']);
        Permission::create(['name' => 'index-codes']);

        // create category permissions
        Permission::create(['name' => 'create-category']);
        Permission::create(['name' => 'modify-category']);
        Permission::create(['name' => 'view-category']);
        Permission::create(['name' => 'index-category']);

        // create class permissions
        Permission::create(['name' => 'create-class']);
        Permission::create(['name' => 'modify-class']);
        Permission::create(['name' => 'view-class']);
        Permission::create(['name' => 'index-class']);

        // Other Permission
        Permission::create(['name' => 'hod-approval']);
        Permission::create(['name' => 'mds-approval']);
        Permission::create(['name' => 'fa-approval']);
        Permission::create(['name' => 'quality-check']);
        Permission::create(['name' => 'haop-approval']);
        Permission::create(['name' => 'recommend']);
        Permission::create(['name' => 'index-stock']);
        Permission::create(['name' => 'issue']);
        Permission::create(['name' => 'receive']);

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

        $role1->givePermissionTo('general-report');

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

        
        $role2->givePermissionTo('view-ledger');
        $role2->givePermissionTo('view-bin-card');
        $role2->givePermissionTo('issue');
        $role2->givePermissionTo('receive');

        $role3 = Role::create(['name' => 'Manager']);
        $role3->givePermissionTo('create-store');
        $role3->givePermissionTo('modify-store');
        $role3->givePermissionTo('view-store');
        $role3->givePermissionTo('index-store');

        $role3->givePermissionTo('create-class');
        $role3->givePermissionTo('modify-class');
        $role3->givePermissionTo('view-class');
        $role3->givePermissionTo('index-class');

        $role3->givePermissionTo('create-codes');
        $role3->givePermissionTo('modify-codes');
        $role3->givePermissionTo('view-codes');
        $role3->givePermissionTo('index-codes');

        $role3->givePermissionTo('create-category');
        $role3->givePermissionTo('modify-category');
        $role3->givePermissionTo('view-category');
        $role3->givePermissionTo('index-category');

        $role3->givePermissionTo('index-stock');
        $role3->givePermissionTo('issue');
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
        ]);
        $user->assignRole($role1);
        $user->assignRole($role2);
        $user->assignRole($role3);
        $user->assignRole($role4);
        
        $user = \App\Models\User::factory()->create([
            'name' => 'Store Officer',
            'email' => 'store.officer@jedplc.com',
        ]);
        $user->assignRole($role2);

        $user = \App\Models\User::factory()->create([
            'name' => 'Manager',
            'email' => 'manager@jedplc.com',
        ]);
        $user->assignRole($role3);

        $user = \App\Models\User::factory()->create([
            'name' => 'PO Manager',
            'email' => 'po.manager@jedplc.com',
        ]);
        $user->assignRole($role4);

    }
}