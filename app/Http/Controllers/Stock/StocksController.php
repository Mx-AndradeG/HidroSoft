<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use App\Http\Requests\Products\StoreProductRequest;
use App\Models\Branch\Branch;
use App\Models\Products\Product;
use App\Models\Stock\Stock;
use App\Models\Storage\Storage;

class StocksController extends Controller
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

        $branches_id = Branch::where('company_id', auth()->user()->company_id)->pluck('id')->toArray();
        $storages_id = Storage::whereIn('branch_id', $branches_id)->pluck('id')->toArray();
        $query = Stock::query()->where('quantity', '>', 0)->whereIn('storage_id', $storages_id);

        foreach ($filters as $filter => $value) {
            if ($value != "" && $filter != "reload") {
                switch ($filter) {
                    case 'formatted_created_at':
                    case 'formatted_updated_at':
                        $filter = $filter == 'formatted_created_at' ? 'created_at' : 'updated_at';
                        $dates = explode(" a ", $value);
                        if (count($dates) > 1) {
                            $product = $query->whereBetween($filter, [$dates[0], $dates[1]]);
                        } else {
                            $product = $query->whereDate($filter, $dates[0]);
                        }
                        break;
                    case 'pos_product_name':
                        $branches_id = Branch::where('company_id', auth()->user()->company_id)->pluck('id')->toArray();
                        $storages_id = Storage::whereIn('branch_id', $branches_id)->pluck('id')->toArray();
                        $query = Stock::query()->where('quantity', '>', 0)->whereIn('storage_id', $storages_id)->leftjoin('products', 'products.id', '=', 'stocks.product_id');
                        $product = $query->where('products.name', 'LIKE', '%' . $value . '%')->orWhere('products.code', 'LIKE', '%' . $value . '%');
                        break;
                    default:
                        $product = $query->where($filter, 'LIKE', '%' . $value . '%');
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
}
