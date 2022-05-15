<?php

use App\Models\Company\Company;
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
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('phone', 255);
            $table->string('email', 255)->nullable();
            $table->string('latitude',255)->nullable();
            $table->string('longitude',255)->nullable();
            $table->boolean('main')->default(false);
            $table->string('address',255)->nullable();
            $table->foreignIdFor(Company::class);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('branches');
    }
};
