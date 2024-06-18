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
        Schema::create('user_info', function (Blueprint $table) {
            $table->id();
            $table->string('user_id'); 
            $table->string("position")->nullable();
            $table->string("address",1000);
            $table->dateTime("birthday");
            $table->string("birthplace");
            $table->enum("civil_status",[
                "single","married","divorced","widowed"
            ]);
            $table->string("nationality");
            $table->string("contact_number")->nullable();
            $table->string("voters_id")->nullable();
            $table->string("company_name")->nullable();
            $table->string("company_position")->nullable();
            $table->string("affiliations")->nullable();
            $table->string("educational_attainment");
            $table->string("special_skills")->nullable();
            $table->string("remarks",1000)->nullable();
            $table->string("referred_by")->nullable();
            $table->string("encoded_by")->nullable();
            $table->string("approved_by")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_info');
    }
};
