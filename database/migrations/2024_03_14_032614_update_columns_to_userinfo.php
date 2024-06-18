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
            $table->string("address",1000)->nullable()->change(); 
            $table->string("birthplace")->nullable()->change();
            $table->enum("civil_status",[
                "single","married","divorced","widowed"
            ])->nullable()->change();
            $table->string("nationality")->nullable()->change(); 
            $table->string("educational_attainment")->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_info', function (Blueprint $table) {
            //
        });
    }
};