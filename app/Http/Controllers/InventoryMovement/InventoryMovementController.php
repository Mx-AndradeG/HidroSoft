<?php

namespace App\Http\Controllers\InventoryMovement;

use App\Http\Controllers\Controller;
use App\Http\Requests\InventoryMovement\StoreInventoryMovementRequest;
use App\Models\InventoryMovement\InventoryMovement;
use App\Models\InventoryMovementProduct\InventoryMovementProduct;
use App\Models\InventoryMovementType\InventoryMovementType;

class InventoryMovementController extends Controller
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

        $query = InventoryMovement::query()->where('company_id', auth()->user()->company_id);

        foreach ($filters as $filter => $value) {
            if ($value != "" && $filter != "reload") {
                switch ($filter) {
                    case 'formatted_created_at':
                    case 'formatted_updated_at':
                        $filter = $filter == 'formatted_created_at' ? 'created_at' : 'updated_at';
                        $dates = explode(" a ", $value);
                        if (count($dates) > 1) {
                            $inventory_movement = $query->whereBetween($filter, [$dates[0], $dates[1]]);
                        } else {
                            $inventory_movement = $query->whereDate($filter, $dates[0]);
                        }
                        break;
                    default:
                        $inventory_movement = $query->where($filter, 'LIKE', '%' . $value . '%');
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

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreInventoryMovementRequest $request
     * @return
     */
    public function store(StoreInventoryMovementRequest $request)
    {
        switch($request->inventory_movement_type_id){
            case InventoryMovementType::ENTRY:
                $inventory_movement = new InventoryMovement();
                $inventory_movement->inventory_movement_type_id = InventoryMovementType::ENTRY;
                $inventory_movement->user_id = auth()->user()->id;
                $inventory_movement->company_id = auth()->user()->company_id;
                $inventory_movement->save();
                foreach($request->entry_movements as $product){
                    $inventory_movement_product = new InventoryMovementProduct();
                    $inventory_movement_product->inventory_movement_id = $inventory_movement->id;
                    $inventory_movement_product->product_id =  $product['product_id'];
                    $inventory_movement_product->storage_id =  $product['storage_id'];
                    $inventory_movement_product->quantity   =  $product['quantity'];
                    $inventory_movement_product->save();
                    $inventory_movement_product->addStock();
                }
            break;
        };
        
        return $inventory_movement;
    }

    /**
     * Display the specified resource.
     *
     * @param InventoryMovement $inventory_movement
     * @return array
     */
    public function show(InventoryMovement $inventory_movement)
    {
        $appends = json_decode(request()->get("appends", "[]"), true);
        $columns = json_decode(request()->get("columns", "[]"), true);
        array_push($columns, 'id', 'formatted_created_at', 'formatted_updated_at');
        array_push($appends, 'formatted_created_at', 'formatted_updated_at');
        return $inventory_movement->append($appends)->only($columns);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreInventoryMovementRequest $request
     * @param InventoryMovement $category
     * @return InventoryMovement
     */
    public function update(StoreInventoryMovementRequest $request, InventoryMovement $inventory_movement)
    {
        $inventory_movement->fill($request->all());
        $inventory_movement->save();
        return $inventory_movement;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return InventoryMovement
     */
    public function destroy(InventoryMovement $inventory_movement)
    {
        $inventory_movement->delete();
        return $inventory_movement;
    }
}
