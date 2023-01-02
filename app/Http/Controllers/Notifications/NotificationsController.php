<?php

namespace App\Http\Controllers\Notifications;

use App\Http\Controllers\Controller;
use App\Models\Notifications\Notification;

class NotificationsController extends Controller
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

        $query = Notification::query()->where('user_id', auth()->user()->id)->where('viewed', false);
       

        foreach ($filters as $filter => $value) {
            if ($value != "" && $filter != "reload") {
                switch ($filter) {
                    case 'Formatted_created_at':
                        $query = $query->where('created_at', 'like', '%' . $value . '%');
                    break;
                    default:
                        $query = $query->where($filter, 'LIKE', '%' . $value . '%');
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

    public function successNotification($id){
        $notification = Notification::findOrFail($id);
        $notification->viewed = true;
        $notification->save();
        return $notification;
    }
}
