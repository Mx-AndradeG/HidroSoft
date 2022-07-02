<?php

use App\Models\InventoryMovement\InventoryMovement;
use App\Models\Products\Product;
use App\Models\Storage\Storage;
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
        Schema::create('inventory_movement_product', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(InventoryMovement::class);
            $table->foreignIdFor(Product::class);
            $table->foreignIdFor(Storage::class);
            $table->integer('quantity');
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
        Schema::dropIfExists('inventory_movement_product');
    }
};
