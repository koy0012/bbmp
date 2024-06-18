<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->bigInteger('order'); 
        });

        Schema::table('users', function (Blueprint $table) { 

            $count = 0;
            foreach (User::get() as $row) {
                $row->update([
                    'order' => $count
                ]);
            }
            $count++; 
            $table->bigInteger('order')->autoIncrement()->change();
            DB::statement("ALTER TABLE users AUTO_INCREMENT = $count;");
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('order');
        });
    }
};
