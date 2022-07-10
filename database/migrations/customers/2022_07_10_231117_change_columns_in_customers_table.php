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
        Schema::table('customers', function (Blueprint $table) {
            $table->string('rfc', 255)->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->string('social', 255)->nullable()->change();
            $table->string('address', 255)->nullable()->change();
            $table->string('latitude',255)->nullable()->change();
            $table->string('longitude',255)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            //
        });
    }
};
