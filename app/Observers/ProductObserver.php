<?php

namespace App\Observers;

use App\Models\Log\Log;
use App\Models\Products\Product;

class ProductObserver
{
    /**
     * Handle the Product "created" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function created(Product $product)
    {
        $data    = "Nombre: " . $product->name . ", Descripcion: " . $product->description;
        $data   .= " Precio de compra: " . $product->purchase_price . ", Precio de venta: " . $product->sale_price;
        $data   .= " Categoria: " . $product->category->name . ", Proveedor: " . $product->supplier_name;

        Log::create([
            'user_id' => auth()->id(),
            'company_id' => auth()->user()->company_id,
            'type' => 'Creación',
            'module' => 'Productos',
            'action' => " Se creó un producto con los siguientes datos : " . $data,
        ]);
    }

    /**
     * Handle the Product "updated" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function updated(Product $product)
    {
        $data    = "Nombre: " . $product->name . ", Descripcion: " . $product->description;
        $data   .= " Precio de compra: " . $product->purchase_price . ", Precio de venta: " . $product->sale_price;
        $data   .= " Categoria: " . $product->category->name . ", Proveedor: " . $product->supplier_name;

        Log::create([
            'user_id' => auth()->id(),
            'company_id' => auth()->user()->company_id,
            'type' => 'Actualización',
            'module' => 'Productos',
            'action' => " Se modifico un producto ahora tiene los siguientes datos : " . $data,
        ]);
    }

    /**
     * Handle the Product "deleted" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function deleted(Product $product)
    {
        $data    = "Nombre: " . $product->name . ", Descripcion: " . $product->description;
        $data   .= " Precio de compra: " . $product->purchase_price . ", Precio de venta: " . $product->sale_price;
        $data   .= " Categoria: " . $product->category->name . ", Proveedor: " . $product->supplier_name;

        Log::create([
            'user_id' => auth()->id(),
            'company_id' => auth()->user()->company_id,
            'type' => 'Eliminación',
            'module' => 'Productos',
            'action' => " Se elimino un producto que tenia los siguientes datos : " . $data,
        ]);
    }

    /**
     * Handle the Product "restored" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function restored(Product $product)
    {
        //
    }

    /**
     * Handle the Product "force deleted" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function forceDeleted(Product $product)
    {
        //
    }
}
