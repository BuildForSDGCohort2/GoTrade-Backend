<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsersTableV1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('display_name')->nullable()->change();
            $table->string('mobile_number')->nullable()->change();
            $table->text('address')->nullable()->change();
            $table->boolean('is_active')->default(1)->change();
            $table->boolean('is_online')->default(1)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('display_name');
            $table->dropColumn('mobile_number');
            $table->dropColumn('address');
            $table->dropColumn('is_active');
            $table->dropColumn('is_online');
        });
    }
}
