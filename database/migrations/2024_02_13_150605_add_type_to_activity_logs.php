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
        if (Schema::hasColumn('activity_logs', 'id')) {
            Schema::table('activity_logs', function (Blueprint $table) {
                $table->dropColumn('id');
            });
        }

        Schema::table('activity_logs', function (Blueprint $table) {
            $table->bigInteger('id', true, true);
            $table->string('type');
            $table->text('log')->change();
            $table->string('modifier')->nullable();
            $table->text('changes')->nullable();
            $table->string('ref_one')->nullable();
            $table->string('ref_two')->nullable();
            $table->string('ref_three')->nullable();
            $table->string('ref_four')->nullable();
            $table->string('ref_six')->nullable();
            $table->string('ref_seven')->nullable();
            $table->string('ref_eight')->nullable();
            $table->string('ref_nine')->nullable();
            $table->text('ref_ten')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activity_logs', function (Blueprint $table) {
            $table->dropColumn('id');
            $table->dropColumn('type');
            $table->dropColumn('modifier');
            $table->dropColumn('changes');

            $table->dropColumn('ref_one');
            $table->dropColumn('ref_two');
            $table->dropColumn('ref_three');
            $table->dropColumn('ref_four');
            $table->dropColumn('ref_six');
            $table->dropColumn('ref_seven');
            $table->dropColumn('ref_eight');
            $table->dropColumn('ref_nine');
            $table->dropColumn('ref_ten');
        });
    }
};
