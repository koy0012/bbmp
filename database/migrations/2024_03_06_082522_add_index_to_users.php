<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->index(['municipal_id']);
            $table->index(['regional_id']);
            $table->index(['barangay_id']);
            $table->index(['state']);
            $table->index(['name']);
            $table->index(['username']);
            $table->index(['email']); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) { 

            $table->dropIndex(['municipal_id']);
            $table->dropIndex(['regional_id']);
            $table->dropIndex(['barangay_id']);
            $table->dropIndex(['state']);
            $table->dropIndex(['name']);
            $table->dropIndex(['username']);
            $table->dropIndex(['email']); 
        });
    }
};
