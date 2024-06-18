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
        $municipal = Role::findByName("municipal"); 

        Permission::create(["name" => "municipals.review"]);

        $municipal->syncPermissions([
            'municipals.members',
            'municipals.create',
            'municipals.update',
            'municipals.read',
            'municipals.delete',
            'municipals.review'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
    }
};
