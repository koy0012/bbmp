<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        $provincial_role = Role::create(['name' => 'provincial']);
        $barangay_role = Role::create(['name' => 'barangay']); 
    
        $provincial_role->givePermissionTo('dashboard.view');
        $barangay_role->givePermissionTo('dashboard.view');

        Permission::create(['name' => 'barangay.assign_head']);
        Permission::create(['name' => 'barangay.*']);

        Permission::create(['name' => 'provincial.assign_head']);
        Permission::create(['name' => 'provincial.*']);

        Role::findByName('national')->givePermissionTo([
            'provincial.*',
            'barangay.*'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
