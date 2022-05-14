<?php

namespace App\Http\Controllers\PaymentMethod;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\StoreCustomerRequest;
use App\Http\Requests\PaymentMethods\PaymentMethodsRequest;
use App\Models\Branch\Branch;
use App\Models\Customer\Customer;
use GuzzleHttp\Psr7\Request;

class PaymentMethodController extends Controller
{
    public function __construct()
    {
    }

    public function getPaymentMethod($id){
        $branch = Branch::findOrFail($id);
        dd($branch->payment_methods);
        return $id;
    }
    /**
     * Display the specified resource.
     *
     * @param Customer $customer
     * @return array
     */
    public function storePaymentMethods(PaymentMethodsRequest $request)
    {
        dd($request);
        return 1;
    }

}
