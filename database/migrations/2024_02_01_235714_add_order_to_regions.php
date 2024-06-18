<?php

use App\Models\Region;
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
        Schema::table('regions', function (Blueprint $table) { 
            $table->integer('order'); 
        });

        Schema::table('regions', function (Blueprint $table) {  
            $count = 0;
            foreach(Region::get() as $row){
                $row->update([
                    'order' => $count 
                ]);
            }
            $count++;

            $table->integer('order')->autoIncrement()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('regions', function (Blueprint $table) {
            $table->dropColumn('order');
        });
    }
};
