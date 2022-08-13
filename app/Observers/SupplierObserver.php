<?php

namespace App\Observers;

use App\Models\Log\Log;
use App\Models\Supplier\Supplier;

class SupplierObserver
{
    /**
     * Handle the Supplier "created" event.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return void
     */
    public function created(Supplier $supplier)
    {
        $data    = "Nombre proveedor: " . $supplier->company_name . ", Direccion: " . $supplier->address;
        $data   .= "Telefono: " . $supplier->phone;

        Log::create([
            'user_id' => auth()->id(),
            'company_id' => auth()->user()->company_id,
            'type' => 'Creación',
            'module' => 'Proveedores',
            'action' => " Se creó un proveedor con los siguientes datos : " . $data,
        ]);
    }

    /**
     * Handle the Supplier "updated" event.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return void
     */
    public function updated(Supplier $supplier)
    {
        $data    = "Nombre proveedor: " . $supplier->company_name . ", Direccion: " . $supplier->address;
        $data   .= "Telefono: " . $supplier->phone;

        Log::create([
            'user_id' => auth()->id(),
            'company_id' => auth()->user()->company_id,
            'type' => 'Actualización',
            'module' => 'Proveedores',
            'action' => " Se modifico un proveedor ahora tiene los siguientes datos : " . $data,
        ]);
    }

    /**
     * Handle the Supplier "deleted" event.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return void
     */
    public function deleted(Supplier $supplier)
    {
        $data    = "Nombre proveedor: " . $supplier->company_name . ", Direccion: " . $supplier->address;
        $data   .= "Telefono: " . $supplier->phone;

        Log::create([
            'user_id' => auth()->id(),
            'company_id' => auth()->user()->company_id,
            'type' => 'Eliminación',
            'module' => 'Proveedores',
            'action' => " Se elimino un proveedor que tenia los siguientes datos : " . $data,
        ]);
    }

    /**
     * Handle the Supplier "restored" event.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return void
     */
    public function restored(Supplier $supplier)
    {
        //
    }

    /**
     * Handle the Supplier "force deleted" event.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return void
     */
    public function forceDeleted(Supplier $supplier)
    {
        //
    }
}
