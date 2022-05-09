<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\StoreCustomerRequest;
use App\Models\Customer\Customer;

class CustomerController extends Controller
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

        $query = Customer::query()->where('company_id', auth()->user()->company_id);

        foreach ($filters as $filter => $value) {
            if ($value != "" && $filter != "reload") {
                switch ($filter) {
                    case 'formatted_created_at':
                    case 'formatted_updated_at':
                        $filter = $filter == 'formatted_created_at' ? 'created_at' : 'updated_at';
                        $dates = explode(" a ", $value);
                        if (count($dates) > 1) {
                            $customer = $query->whereBetween($filter, [$dates[0], $dates[1]]);
                        } else {
                            $customer = $query->whereDate($filter, $dates[0]);
                        }
                        break;
                    default:
                        $customer = $query->where($filter, 'LIKE', '%' . $value . '%');
                        break;
                }
            }
        }

        $order = $ascending === "1" ? 'DESC' : 'ASC';
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

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCustomerRequest $request
     * @return
     */
    public function store(StoreCustomerRequest $request)
    {
        $customer = new Customer();
        $customer->fill($request->all());
        $customer->company_id = auth()->user()->company_id;     
        $customer->save();
        return $customer;
    }

    /**
     * Display the specified resource.
     *
     * @param Customer $customer
     * @return array
     */
    public function show(Customer $customer)
    {
        $appends = json_decode(request()->get("appends", "[]"), true);
        $columns = json_decode(request()->get("columns", "[]"), true);
        array_push($columns, 'id', 'formatted_created_at', 'formatted_updated_at');
        array_push($appends, 'formatted_created_at', 'formatted_updated_at');
        return $customer->append($appends)->only($columns);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreCustomerRequest $request
     * @param Customer $category
     * @return Customer
     */
    public function update(StoreCustomerRequest $request, Customer $customer)
    {
        $customer->fill($request->all());
        $customer->save();
        return $customer;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Customer
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return $customer;
    }
}
