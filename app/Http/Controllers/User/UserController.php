<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\PasswordRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\ValidateFirstStepRequest;
use App\Http\Requests\User\ValidateSecondStepRequest;
use App\Models\User;
use App\Notifications\CompleateUserRegister;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
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

        $query = User::query()->where('company_id', auth()->user()->company_id);

        foreach ($filters as $filter => $value) {
            if ($value != "" && $filter != "reload") {
                switch ($filter) {
                    case 'formatted_created_at':
                    case 'formatted_updated_at':
                        $filter = $filter == 'formatted_created_at' ? 'created_at' : 'updated_at';
                        $dates = explode(" a ", $value);
                        if (count($dates) > 1) {
                            $users = $query->whereBetween($filter, [$dates[0], $dates[1]]);
                        } else {
                            $users = $query->whereDate($filter, $dates[0]);
                        }
                        break;
                    default:
                        $users = $query->where($filter, 'LIKE', '%' . $value . '%');
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

    public function validation(PasswordRequest $request)
    {
        $user = User::findOrfail($request->user_id);
        $user->password = bcrypt($request->password);
        $user->email_verified_at = Carbon::now();
        $user->save();
        Auth::logout();
        Auth::loginUsingId($request->user_id);
        return  redirect('/login');
    }

        /**
     * Store a newly created resource in storage.
     *
     * @param StoreUserRequest $request
     * @return
     */
    public function store(StoreUserRequest $request)
    {
        $user = new User();
        $user->fill($request->all());
        $user->company_id = auth()->user()->company_id;
        $user->save();
        $user->notify(new CompleateUserRegister());
        return $user;
    }
       
    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return array
     */
    public function show(User $user)
    {
        $appends = json_decode(request()->get("appends", "[]"), true);
        $columns = json_decode(request()->get("columns", "[]"), true);
        array_push($columns, 'id', 'formatted_created_at', 'formatted_updated_at');
        array_push($appends, 'formatted_created_at', 'formatted_updated_at');
        return $user->append($appends)->only($columns);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreUserRequest $request
     * @param User $category
     * @return User
     */
    public function update(StoreUserRequest $request, User $user)
    {
        $user->fill($request->all());
        $user->save();
        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return User
     */
    public function destroy(User $user)
    {
        $user->delete();
        return $user;
    }


    public function validateFirstStep(ValidateFirstStepRequest $request)
    {
        return true;
    }

    public function validateSecondStep(ValidateSecondStepRequest $request)
    {
        return true;
    }

    public function getAuthUser()
    {
        $branch = auth()->user()->branch;
        return $branch;
    }
}
