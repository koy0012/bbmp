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
        Schema::table('user_info', function (Blueprint $table) { 
            $table->index(['sub_group']);
            $table->index(['referred_by']);
            $table->index(['approved_by']);
            $table->index(['user_id']);
            $table->index(['encoded_by']);  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_info', function (Blueprint $table) {  

            $table->dropIndex(['sub_group']);
            $table->dropIndex(['referred_by']);
            $table->dropIndex(['approved_by']);
            $table->dropIndex(['user_id']);
            $table->dropIndex(['encoded_by']);  
        }); 
    }
};
