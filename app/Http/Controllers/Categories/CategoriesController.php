<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\Categories\StoreCategoryRequest;
use App\Models\Categories\Category;

class CategoriesController extends Controller
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

        $query = Category::query()->where(auth()->user()->company_id);

        foreach ($filters as $filter => $value) {
            if ($value != "" && $filter != "reload") {
                switch ($filter) {
                    case 'formatted_created_at':
                    case 'formatted_updated_at':
                        $filter = $filter == 'formatted_created_at' ? 'created_at' : 'updated_at';
                        $dates = explode(" a ", $value);
                        if (count($dates) > 1) {
                            $category = $query->whereBetween($filter, [$dates[0], $dates[1]]);
                        } else {
                            $category = $query->whereDate($filter, $dates[0]);
                        }
                        break;
                    default:
                        $category = $query->where($filter, 'LIKE', '%' . $value . '%');
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
     * @param StoreCategoryRequest $request
     * @return
     */
    public function store(StoreCategoryRequest $request)
    {
        $category = new Category();
        $category->fill($request->all());
        $category->save();
        return $category;
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @return array
     */
    public function show(Category $category)
    {
        $appends = json_decode(request()->get("appends", "[]"), true);
        $columns = json_decode(request()->get("columns", "[]"), true);
        array_push($columns, 'id', 'formatted_created_at', 'formatted_updated_at');
        array_push($appends, 'formatted_created_at', 'formatted_updated_at');
        return $category->append($appends)->only($columns);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreCategoryRequest $request
     * @param Category $category
     * @return Category
     */
    public function update(StoreCategoryRequest $request, Category $category)
    {
        $category->fill($request->all());
        $category->save();
        return $category;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Category
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return $category;
    }
}
