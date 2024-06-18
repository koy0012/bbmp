<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $super_admin = Role::create(['name' => 'super_admin']);
        $national_role = Role::create(['name' => 'national']);
        $regional_role = Role::create(['name' => 'regional']);
        $regional_head_role = Role::create(['name' => 'regional_head']);

        $municipal_role = Role::create(['name' => 'municipal']);
        $municipal_head_role = Role::create(['name' => 'municipal_head']);

        $member_role = Role::create(['name' => 'member']);

        Permission::create(['name' => 'dashboard.view']);
        Permission::create(['name' => 'dashboard.*']);

        Permission::create(['name' => 'users.create']);
        Permission::create(['name' => 'users.update']);
        Permission::create(['name' => 'users.read']);
        Permission::create(['name' => 'users.delete']);
        Permission::create(['name' => 'users.*']);

        Permission::create(['name' => 'municipals.assign_head']);
        Permission::create(['name' => 'municipals.members']);
        Permission::create(['name' => 'municipals.create']);
        Permission::create(['name' => 'municipals.update']);
        Permission::create(['name' => 'municipals.read']);
        Permission::create(['name' => 'municipals.delete']);
        Permission::create(['name' => 'municipals.*']);

        Permission::create(['name' => 'regional.assign_head']);
        Permission::create(['name' => 'regional.create']);
        Permission::create(['name' => 'regional.update']);
        Permission::create(['name' => 'regional.read']);
        Permission::create(['name' => 'regional.delete']);
        Permission::create(['name' => 'regional.*']);

        $national_role->givePermissionTo('dashboard.*');
        $national_role->givePermissionTo('users.*');
        $national_role->givePermissionTo('regional.*');
        $national_role->givePermissionTo('municipals.*');

        $national_role->givePermissionTo('dashboard.*');

        $regional_role->givePermissionTo([
            'regional.create',
            'regional.update',
            'regional.read',
            'regional.delete'
        ]);

        $regional_role->givePermissionTo([
            'municipals.create',
            'municipals.update',
            'municipals.read'
        ]);


        $regional_head_role->syncPermissions($regional_role);
        $regional_head_role->givePermissionTo('regional.assign_head');

        //MUNICIPAL
        $municipal_role->givePermissionTo('municipals.*');

        $municipal_head_role->syncPermissions($municipal_role);
        $municipal_head_role->givePermissionTo('municipals.assign_head');


        foreach (User::get() as $user) {
            $user->syncRoles($user->role);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('permissions')->truncate();
        DB::table('roles')->truncate();
        DB::table('role_has_permissions')->truncate();
        DB::table('model_has_permissions')->truncate();
        DB::table('model_has_roles')->truncate();
    }
};
