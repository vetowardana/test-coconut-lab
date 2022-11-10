<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropColumn('type');
        });

        Schema::table('addresses', function (Blueprint $table) {
            $table->renameColumn('default', 'old_default');
        });

        Schema::table('addresses', function (Blueprint $table) {
            $table->boolean('default')->after('addresses');
        });

        Schema::table('addresses', function (Blueprint $table) {
            $table->dropColumn('old_default');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->boolean('type');
        });
    }
};
