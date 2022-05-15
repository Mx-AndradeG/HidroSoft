<?php

namespace App\Http\Controllers\PaymentMethod;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\StoreCustomerRequest;
use App\Http\Requests\PaymentMethods\PaymentMethodsRequest;
use App\Models\Branch\Branch;
use App\Models\Customer\Customer;
use App\Models\PaymentMethod\PaymentMethod;
use GuzzleHttp\Psr7\Request;

class PaymentMethodController extends Controller
{
    public function __construct()
    {
    }

    public function getPaymentMethod($id){
        $branch = Branch::findOrFail($id);
        dd($branch->payment_methods);
        return 1;
    }
    /**
     * Display the specified resource.
     *
     * @param Customer $customer
     * @return array
     */
    public function storePaymentMethods(PaymentMethodsRequest $request)
    {

        foreach($request->payment_methods as $payment_method){
           if($payment_method['id'] != 'null' && !$payment_method['deleted']){
                $payment_method_instance = new PaymentMethod();
                $payment_method_instance->name = $payment_method['name']; 
                $payment_method_instance->nambranch_ide = $request->branch_id;
                $payment_method_instance->save();
            }
            if($payment_method['id'] != 'null' && $payment_method['deleted']){
                $current_payment_method = PaymentMethod::findOfFail($payment_method['id']);
                $current_payment_method->deleted();
            }
        }
        return $request->payment_methods;
    }

}
