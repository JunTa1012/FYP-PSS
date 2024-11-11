<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('recycle_activities', function (Blueprint $table) {
            $table->decimal('recycle_price', 8, 2)->after('recycle_rate');
            $table->integer('reward_point_earned')->after('recycle_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recycle_activities', function (Blueprint $table) {
            $table->dropColumn('recycle_price');
            $table->dropColumn('reward_point_earned');
        });
    }
};