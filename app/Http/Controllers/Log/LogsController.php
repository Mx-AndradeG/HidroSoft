<?php

namespace App\Http\Controllers\Log;

use App\Exports\LogsExport;
use App\Exports\StockExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Products\StoreProductRequest;
use App\Models\Branch\Branch;
use App\Models\Log\Log;
use App\Models\Products\Product;
use App\Models\Stock\Stock;
use App\Models\Storage\Storage;
use Maatwebsite\Excel\Facades\Excel;

class LogsController extends Controller
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

        $query = Log::query()->where('company_id', auth()->user()->company_id);
       

        foreach ($filters as $filter => $value) {
            if ($value != "" && $filter != "reload") {
                switch ($filter) {
                    case 'user_name':
                        $sale = $query->whereHas('user', function ($query) use ($value){
                            return $query->where('name', 'LIKE', '%' . $value . '%');
                        });
                    break;
                    case 'Formatted_created_at':
                        $sale = $query->where('created_at', 'like', '%' . $value . '%');
                    break;
                        
                    default:
                            $product = $query->where($filter, 'LIKE', '%' . $value . '%');
                        break;
                }
            }
        }

        $order = $ascending == "1" ? 'DESC' : 'ASC';
        switch ($orderBy) {
            case 'user_name':
                $sale = $query->whereHas('user', function ($query) use ($order){
                    return $query->orderBy('name', $order);
                });
            break;
            case 'Formatted_created_at':
                $query->orderBy('created_at', $order);
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
    public function export() 
    {
        return Excel::download(new LogsExport, 'Bitacora.xlsx');
    }
}
