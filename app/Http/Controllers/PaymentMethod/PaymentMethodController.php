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

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = request()->get("page", false);
        $limit = request()->get("limit", false);
        $orderBy = request()->get("orderBy", 'id');
        $ascending = request()->get("ascending", "1");
        $filters = json_decode(request()->get("filters", "{}"), true);
        $columns = json_decode(request()->get("columns", "[]"), true);

        array_push($columns, 'id');

        $query = PaymentMethod::query();

        foreach ($filters as $filter => $value) {
            if ($value != "" && $filter != "reload") {
                switch ($filter) {
                    case 'formatted_created_at':
                    case 'formatted_updated_at':
                        $filter = $filter == 'formatted_created_at' ? 'created_at' : 'updated_at';
                        $dates = explode(" a ", $value);
                        if (count($dates) > 1) {
                            $payment_method = $query->whereBetween($filter, [$dates[0], $dates[1]]);
                        } else {
                            $payment_method = $query->whereDate($filter, $dates[0]);
                        }
                        break;
                    default:
                        $payment_method = $query->where($filter, 'LIKE', '%' . $value . '%');
                        break;
                }
            }
        }

        $order = $ascending == "1" ? 'DESC' : 'ASC';
        switch ($orderBy) {
            case 'formatted_created_at':
            case 'formatted_updated_at':
                $orderBy = $orderBy === 'formatted_created_at' ? 'created_at' : 'updated_at';
                $query->orderBy($orderBy, $order);
                break;
            default:
                $query->orderBy($orderBy, $order);
                break;
        }

        $data = $query->get();
        $count = $data->count();

        if ($limit && $page) {
            $data = $data->skip($page - 1)->take($limit)->values();
        }

        $data = $data->map(function ($_data) use ($columns) {
            $_data = $_data->only($columns);
            return $_data;
        });

        return compact("data", "count");
    }

    public function getPaymentMethod($id){
        $branch = Branch::findOrFail($id);
        $data = [];
        foreach($branch->payment_methods as $payment_method){
            array_push($data,
                [
                    'id' => $payment_method->id,
                    'name' => $payment_method->name,
                    'deleted' => false,
                ]
            );
        }
        return $data;
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
           if($payment_method['id'] == 'null' && $payment_method['deleted'] == 'false'){
                $payment_method_instance = new PaymentMethod();
                $payment_method_instance->name = $payment_method['name']; 
                $payment_method_instance->branch_id = $request->branch_id;
                $payment_method_instance->save();
            }
            if($payment_method['id'] != 'null' && $payment_method['deleted'] == 'true'){
                $current_payment_method = PaymentMethod::findOrFail($payment_method['id']);
                $current_payment_method->delete();
            }
        }
        return $request->payment_methods;
    }

}
