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
        Schema::create('municipals', function (Blueprint $table) {
            $table->uuid('id');
            $table->string("name");
            $table->string("head_user_id")->nullable(); 
            $table->string("province_id"); 
            $table->string("region_id"); 
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('municipals');
    }
};
