<?php

namespace App\Observers;

use Carbon\Carbon;
use App\Models\Logs\Log;
use App\Models\finances\Loans\Loan;
use App\Models\Payments\PaymentDates\PaymentDate;
use App\Models\Payments\Payments\Payment;
use App\Models\Sale\Sale;

class PaymentObserver
{
    /**
     * Handle the Payment "created" event.
     *
     * @param  \App\Models\finances\Payments\Payment  $payment
     * @return void
     */
    public function created(Payment $payment)
    {
        $payment_date = $payment->paymentDate;
        $payment_date->total_paid+=$payment->amount;
        $payment_date->save();
        $payment_dates = PaymentDate::where('sale_id',$payment_date->sale_id)->get();
        $total_payments_paid = 0;
        $sale = Sale::findOrFail($payment_date->sale_id);
        
        foreach($payment_dates as $payment_date){
            $total_debt_payment_date = $payment_date->amount - $payment_date->total_paid;
            if($total_debt_payment_date <= 0.1)
            {
                $total_payments_paid++;
            }
        }
        $total_payment_dates = PaymentDate::where('sale_id',$payment_date->sale_id)->count();
        
        if($total_payments_paid == $total_payment_dates){
            $sale->status = Sale::STATUS_PAID;
            $sale->save();
        }else{
            $sale->status = Sale::STATUS_PARTIALLY_PAID;
            $sale->save();
        }

    }

    /**
     * Handle the PaymentDate "updated" event.
     *
     * @param  \App\Models\Payment  $Payment
     * @return void
     */
    public function updated(Payment $payment)
    {

    }

    /**
     * Handle the PaymentDate "deleted" event.
     *
     * @param  \App\Models\payment  $paymentDate
     * @return void
     */
    public function deleted(Payment $payment)
    {

    }

}
