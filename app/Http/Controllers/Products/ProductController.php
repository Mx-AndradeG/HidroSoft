<?php

namespace App\Http\Controllers\Products;

use App\Exports\ProductExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Products\StoreProductRequest;
use App\Models\Products\Product;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
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

        $query = Product::query()->whereHas('category', function ($query){
            return $query->where('company_id', auth()->user()->company_id);
        });

        foreach ($filters as $filter => $value) {
            if ($value != "" && $filter != "reload") {
                switch ($filter) {
                    case "supplier_name":
                        $query->whereHas('supplier', function ($query) use ($value) {
                            $query->where('company_name', 'like', '%' . $value . '%');
                        });
                        break;
                    case "category_name":
                        $query->whereHas('category', function ($query) use ($value) {
                            $query->where('name', 'like', '%' . $value . '%');
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

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreProductRequest $request
     * @return
     */
    public function store(StoreProductRequest $request)
    {
        $product = new Product();
        $product->fill($request->all());
        $product->save();
        return $product;
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return array
     */
    public function show(Product $product)
    {
        $appends = json_decode(request()->get("appends", "[]"), true);
        $columns = json_decode(request()->get("columns", "[]"), true);
        array_push($columns, 'id', 'formatted_created_at', 'formatted_updated_at');
        array_push($appends, 'formatted_created_at', 'formatted_updated_at');
        return $product->append($appends)->only($columns);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreProductRequest $request
     * @param Product $category
     * @return Product
     */
    public function update(StoreProductRequest $request, Product $product)
    {
        $product->fill($request->all());
        $product->save();
        return $product;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Product
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return $product;
    }

    public function indexCurrentProductsInBranch()
    {
        $page = request()->get("page", false);
        $limit = request()->get("limit", false);
        $orderBy = request()->get("orderBy", 'id');
        $ascending = request()->get("ascending", "1");
        $filters = json_decode(request()->get("filters", "{}"), true);
        $columns = json_decode(request()->get("columns", "[]"), true);

        array_push($columns, 'id');

        $query = Product::query()->whereHas('category', function ($query){
             $query->where('company_id', auth()->user()->company_id)->whereHas('');
        });

        foreach ($filters as $filter => $value) {
            if ($value != "" && $filter != "reload") {
                switch ($filter) {
                    case "supplier_name":
                        $query->whereHas('supplier', function ($query) use ($value) {
                            $query->where('company_name', 'like', '%' . $value . '%');
                        });
                        break;
                    case "category_name":
                        $query->whereHas('category', function ($query) use ($value) {
                            $query->where('name', 'like', '%' . $value . '%');
                        });
                        break;
                    case 'Formatted_created_at':
                        $sale = $query->where('created_at', 'like', '%' . $value . '%');
                        break;
                    break;
                        $product = $query->where($filter, 'LIKE', '%' . $value . '%');
                        break;
                }
            }
        }

        $order = $ascending == "1" ? 'DESC' : 'ASC';
        switch ($orderBy) {
            case "supplier_name":
                $query->whereHas('supplier', function ($query) use ($order) {
                    $query->orderBy('company_name', $order);
                });
            break;
            case "category_name":
                $query->whereHas('category', function ($query) use ($order) {
                    $query->orderBy('name' , $order);
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
        return Excel::download(new ProductExport, 'Productos.xlsx');
    }
}
