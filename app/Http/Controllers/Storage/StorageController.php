<?php

namespace App\Http\Controllers\Storage;

use App\Http\Controllers\Controller;
use App\Http\Requests\Storage\StorageBranchRequest;
use App\Models\Storage\Storage;

class StorageController extends Controller
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

        $query = Storage::query()->whereHas('branch', function ($query){
            return $query->where('company_id', auth()->user()->company_id);
        });

        foreach ($filters as $filter => $value) {
            if ($value != "" && $filter != "reload") {
                switch ($filter) {
                    case 'formatted_created_at':
                    case 'formatted_updated_at':
                        $filter = $filter == 'formatted_created_at' ? 'created_at' : 'updated_at';
                        $dates = explode(" a ", $value);
                        if (count($dates) > 1) {
                            $wherehouse = $query->whereBetween($filter, [$dates[0], $dates[1]]);
                        } else {
                            $wherehouse = $query->whereDate($filter, $dates[0]);
                        }
                        break;
                    default:
                        $wherehouse = $query->where($filter, 'LIKE', '%' . $value . '%');
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
     * Store a newly created resource in wherehouse.
     *
     * @param StorageBranchRequest $request
     * @return
     */
    public function store(StorageBranchRequest $request)
    {
        $wherehouse = new Storage();
        $wherehouse->fill($request->all());  
        $wherehouse->main = true;
        $wherehouse->save();
        return $wherehouse;
    }

    /**
     * Display the specified resource.
     *
     * @param Storage $wherehouse
     * @return array
     */
    public function show(Storage $wherehouse)
    {
        $appends = json_decode(request()->get("appends", "[]"), true);
        $columns = json_decode(request()->get("columns", "[]"), true);
        array_push($columns, 'id', 'formatted_created_at', 'formatted_updated_at');
        array_push($appends, 'formatted_created_at', 'formatted_updated_at');
        return $wherehouse->append($appends)->only($columns);
    }

    /**
     * Update the specified resource in wherehouse.
     *
     * @param StorageBranchRequest $request
     * @param Storage $category
     * @return Storage
     */
    public function update(StorageBranchRequest $request, Storage $wherehouse)
    {
        $wherehouse->fill($request->all());
        $wherehouse->save();
        return $wherehouse;
    }

    /**
     * Remove the specified resource from wherehouse.
     *
     * @return Storage
     */
    public function destroy(Storage $wherehouse)
    {
        $wherehouse->delete();
        return $wherehouse;
    }
}
