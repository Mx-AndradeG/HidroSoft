<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sale\StoreSaleRequest;
use App\Models\PaymentMethod\PaymentMethod;
use App\Models\Sale\Sale;
use PhpParser\Node\Stmt\Switch_;

class SalesController extends Controller
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
        $orderBy = request()->get("orderBy", 'stocks.id');
        $ascending = request()->get("ascending", "1");
        $filters = json_decode(request()->get("filters", "{}"), true);
        $columns = json_decode(request()->get("columns", "[]"), true);

        array_push($columns, 'id');

        $query = Sale::query();

        foreach ($filters as $filter => $value) {
            if ($value != "" && $filter != "reload") {
                switch ($filter) {
                    case 'formatted_created_at':
                    case 'formatted_updated_at':
                        $filter = $filter == 'formatted_created_at' ? 'created_at' : 'updated_at';
                        $dates = explode(" a ", $value);
                        if (count($dates) > 1) {
                            $sale = $query->whereBetween($filter, [$dates[0], $dates[1]]);
                        } else {
                            $sale = $query->whereDate($filter, $dates[0]);
                        }
                        break;
                    default:
                        $sale = $query->where($filter, 'LIKE', '%' . $value . '%');
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
     * @param StoreSaleRequest $request
     * @return
     */
    public function store(StoreSaleRequest $request)
    {
        $sale = new Sale();
        $sale->user_id    = auth()->user()->id;
        $sale->branch_id  = auth()->user()->branch->id;
        $sale->customer_id = $request->customer_id != 0 ? $request->customer_id : null;
        $sale->payment_method_id = $request->payment_method_id;
        $sale->total_sale = $request->total_sale;

        Switch($request->payment_method_id){
            case PaymentMethod::CASH:
                $sale->received_amount = $request->received_amount;
                break;
            case PaymentMethod::CARD:
                $sale->reference_code = $request->reference_code;
                break;
        }

        $sale->save();
        $sale->storeSaleDetails($request->current_produts);

        return $sale;
    }

    /**
     * Display the specified resource.
     *
     * @param Sale $sale
     * @return array
     */
    public function show(Sale $sale)
    {
        $appends = json_decode(request()->get("appends", "[]"), true);
        $columns = json_decode(request()->get("columns", "[]"), true);
        array_push($columns, 'id', 'formatted_created_at', 'formatted_updated_at');
        array_push($appends, 'formatted_created_at', 'formatted_updated_at');
        return $sale->append($appends)->only($columns);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreSaleRequest $request
     * @param Sale $category
     * @return Sale
     */
    public function update(StoreSaleRequest $request, Sale $sale)
    {

        $sale->fill($request->all());
        $sale->save();
        return $sale;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Sale
     */
    public function destroy(Sale $sale)
    {
        $sale->delete();
        return $sale;
    }
}
