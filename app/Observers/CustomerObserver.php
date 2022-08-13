<?php

namespace App\Observers;

use App\Models\Customer\Customer;
use App\Models\Log\Log;

class CustomerObserver
{
    /**
     * Handle the Customer "created" event.
     *
     * @param  \App\Models\Customer  $customer
     * @return void
     */
    public function created(Customer $customer)
    {
        $data    = "Nombre: " . $customer->name . ", Direccion: " . $customer->address;
        $data   .= "Telefono: " . $customer->phone . ", RFC : " . $customer->rfc;
        $data   .= "Email: " . $customer->email . ", Razon social: " . $customer->social;

        Log::create([
            'user_id' => auth()->id(),
            'company_id' => auth()->user()->company_id,
            'type' => 'Creación',
            'module' => 'Clientes',
            'action' => " Se creó un cliente con los siguientes datos : " . $data,
        ]);
    }

    /**
     * Handle the Customer "updated" event.
     *
     * @param  \App\Models\Customer  $customer
     * @return void
     */
    public function updated(Customer $customer)
    {
        $data    = "Nombre: " . $customer->name . ", Direccion: " . $customer->address;
        $data   .= "Telefono: " . $customer->phone . ", RFC : " . $customer->rfc;
        $data   .= "Email: " . $customer->email . ", Razon social: " . $customer->social;

        Log::create([
            'user_id' => auth()->id(),
            'company_id' => auth()->user()->company_id,
            'type' => 'Actualización',
            'module' => 'Clientes',
            'action' => " Se modifico un cliente ahora tiene los siguientes datos : " . $data,
        ]);
    }

    /**
     * Handle the Customer "deleted" event.
     *
     * @param  \App\Models\Customer  $customer
     * @return void
     */
    public function deleted(Customer $customer)
    {
        $data    = "Nombre: " . $customer->name . ", Direccion: " . $customer->address;
        $data   .= "Telefono: " . $customer->phone . ", RFC : " . $customer->rfc;
        $data   .= "Email: " . $customer->email . ", Razon social: " . $customer->social . ", ID: " . $customer->id;

        Log::create([
            'user_id' => auth()->id(),
            'company_id' => auth()->user()->company_id,
            'type' => 'Eliminación',
            'module' => 'Clientes',
            'action' => " Se elimino un cliente que tenia los siguientes datos : " . $data,
        ]);
    }

    /**
     * Handle the Customer "restored" event.
     *
     * @param  \App\Models\Customer  $customer
     * @return void
     */
    public function restored(Customer $customer)
    {
        //
    }

    /**
     * Handle the Customer "force deleted" event.
     *
     * @param  \App\Models\Customer  $customer
     * @return void
     */
    public function forceDeleted(Customer $customer)
    {
        //
    }
}
