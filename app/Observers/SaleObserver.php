<?php

namespace App\Observers;

use App\Models\Log\Log;
use App\Models\Sale\Sale;

class SaleObserver
{
    /**
     * Handle the Sale "created" event.
     *
     * @param  \App\Models\sale  $sale
     * @return void
     */
    public function created(Sale $sale)
    {
        $data   = "Monto: " . $sale->formatted_total_sale . ", cliente: " . $sale->customer_name . 
                  ' , fecha: ' . $sale->Formatted_created_at . ', metodo de pago: '. $sale->payment_method_name;

        Log::create([
            'user_id' => auth()->id(),
            'company_id' => auth()->user()->company_id,
            'type' => 'Creación',
            'module' => 'Punto de venta',
            'action' => " Se realizo una venta siguientes datos : " . $data,
        ]);
    }


    /**
     * Handle the Sale "deleted" event.
     *
     * @param  \App\Models\Sale  $sale
     * @return void
     */
    public function deleted(Sale $sale)
    {
        $data   = "Monto: " . $sale->formatted_total_sale . ", cliente: " . $sale->customer_name . 
                  ' , fecha: ' . $sale->Formatted_created_at . ', metodo de pago: '. $sale->payment_method_name;

        Log::create([
            'user_id' => auth()->id(),
            'company_id' => auth()->user()->company_id,
            'type' => 'Eliminación',
            'module' => 'Punto de venta',
            'action' => " Se elimino una venta que tenia los siguientes datos : " . $data,
        ]);
    }

    /**
     * Handle the Sale "restored" event.
     *
     * @param  \App\Models\Sale  $sale
     * @return void
     */
    public function restored(Sale $sale)
    {
        //
    }

    /**
     * Handle the Sale "force deleted" event.
     *
     * @param  \App\Models\Sale  $sale
     * @return void
     */
    public function forceDeleted(Sale $sale)
    {
        //
    }
}
