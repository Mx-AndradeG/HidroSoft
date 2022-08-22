<?php

namespace App\Http\Controllers\Sale;

use App\Exports\SalesExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\payments\PaymentRequest;
use App\Http\Requests\Sale\StoreSaleRequest;
use App\Models\Branch\Branch;
use App\Models\Categories\Category;
use App\Models\PaymentMethod\PaymentMethod;
use App\Models\Payments\PaymentDates\PaymentDate;
use App\Models\Payments\Payments\Payment;
use App\Models\Products\Product;
use App\Models\Sale\Sale;
use PhpParser\Node\Stmt\Switch_;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

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
        $orderBy = request()->get("orderBy", 'id');
        $ascending = request()->get("ascending", "1");
        $filters = json_decode(request()->get("filters", "{}"), true);
        $columns = json_decode(request()->get("columns", "[]"), true);
        array_push($columns, 'id');

        $branches_id = Branch::where('company_id', auth()->user()->company_id)->pluck('id')->toArray();

        $query = Sale::whereIn('branch_id', $branches_id);

        foreach ($filters as $filter => $value) {
            if ($value != "" && $filter != "reload") {
                switch ($filter) {
                    case "user_name":
                        $query->whereHas('user', function ($query) use ($value) {
                            $query->where('name', 'like', '%' . $value . '%');
                        });
                        break;
                    case "customer_name":
                        $query->whereHas('customer', function ($query) use ($value) {
                            $query->where('name', 'like', '%' . $value . '%');
                        });
                        break;
                    case "branch_name":
                        $query->whereHas('branch', function ($query) use ($value) {
                            $query->where('name', 'like', '%' . $value . '%');
                        });
                        break;
                    case "payment_method_name":
                        $query->whereHas('payment_method', function ($query) use ($value) {
                            $query->where('name', 'like', '%' . $value . '%');
                        });
                        break;
                    case "sale_type_name":
                        $query->whereHas('sale_type', function ($query) use ($value) {
                            $query->where('name', 'like', '%' . $value . '%');
                        });
                        break;
                    case "formatted_total_sale":
                        $query->where('total_sale', 'like', '%' . $value . '%');
                        break;
                    case 'Formatted_created_at':
                        $sale = $query->where('created_at', 'like', '%' . $value . '%');
                        break;
                    default:
                        $sale = $query->where($filter, 'LIKE', '%' . $value . '%');
                        break;
                }
            }
        }

        $order = $ascending == "1" ? 'DESC' : 'ASC';
        switch ($orderBy) {
            case "user_name":
                $query->whereHas('user', function ($query) use ($order) {
                    $query->orderBy('name', $order);
                });
                break;
            case "customer_name":
                $query->whereHas('customer', function ($query) use ($order) {
                    $query->orderBy('name', $order);
                });
                break;
            case "branch_name":
                $query->whereHas('branch', function ($query) use ($order) {
                    $query->orderBy('name', $order);
                });
                break;
            case "payment_method_name":
                $query->whereHas('payment_method', function ($query) use ($order) {
                    $query->orderBy('name', $order);
                });
                break;
            case "sale_type_name":
                $query->whereHas('sale_type', function ($query) use ($order) {
                    $query->orderBy('name', $order);
                });
                break;
            case "formatted_total_sale":
                $query->orderBy('total_sale', $order);
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
        $sale->sale_type_id  = $request->sale_type_id;        
        $sale->customer_id = $request->customer_id != 0 ? $request->customer_id : null;
        $sale->payment_method_id = $request->payment_method_id;
        $sale->total_sale = $request->total_sale;

        switch ($request->payment_method_id) {
            case PaymentMethod::CASH:
                $sale->received_amount = $request->received_amount;
                $sale->save();
                break;
            case PaymentMethod::CARD:
                $sale->reference_code = $request->reference_code;
                $sale->save();
                break;
            case PaymentMethod::CREDIT:
                $sale->status = Sale::STATUS_WITHOUT_PAYMENT;
                $sale->save();
                $sale->createPaymentDates($request->payment_plan_id, $sale->total_sale, $request->deadline_id);
                break;
        }

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

    public function getHeaderInfoDashboard()
    {
        $range_id = request()->get("range_id", 1);
        $branches_id = Branch::where('company_id', auth()->user()->company_id)->pluck('id')->toArray();
        switch ($range_id) {
            case 1:
                $sales_today = Sale::whereIn('branch_id', $branches_id)->whereDate('created_at',  Carbon::now()->toDateString());
                if ($sales_today->count() > 0) {
                    $total_amount_sale_today = $sales_today->sum('total_sale');
                    $total_count_sale_today  = $sales_today->count();
                    $total_inventory_amount_today = 0;
                    $total_products_sale_today = 0;
                    $sales_data = $sales_today->get();
                    foreach ($sales_data as $sale) {
                        foreach ($sale->sale_detail as $saleDetail) {
                            $total_products_sale_today +=  $saleDetail->quantity;
                            $total_inventory_amount_today +=  ($saleDetail->purchase_price * $saleDetail->quantity);
                        }
                    }
                    return [
                        'total_amount_sale_today' => $total_amount_sale_today,
                        'total_count_sale_today' => $total_count_sale_today,
                        'total_earnings_today' => ($total_amount_sale_today - $total_inventory_amount_today),
                        'total_products_sale_today' => $total_products_sale_today
                    ];
                } else {
                    return [
                        'total_amount_sale_today' => 0,
                        'total_count_sale_today' => 0,
                        'total_earnings_today' => 0,
                        'total_products_sale_today' => 0
                    ];
                }
                break;
            case 2:
                $sales_this_week = Sale::whereIn('branch_id', $branches_id)->whereBetween('created_at', [Carbon::now()->startOfWeek()->toDateString(), Carbon::now()->endOfWeek()->toDateString()]);
                if ($sales_this_week->count() > 0) {
                    $total_amount_sale_this_week = $sales_this_week->sum('total_sale');
                    $total_count_sale_this_week  = $sales_this_week->count();
                    $total_inventory_amount_this_week = 0;
                    $total_products_sale_this_week = 0;
                    $sales_data = $sales_this_week->get();
                    foreach ($sales_data as $sale) {
                        foreach ($sale->sale_detail as $saleDetail) {
                            $total_products_sale_this_week +=  $saleDetail->quantity;
                            $total_inventory_amount_this_week +=  ($saleDetail->purchase_price * $saleDetail->quantity);
                        }
                    }
                    return [
                        'total_amount_sale_today' => $total_amount_sale_this_week,
                        'total_count_sale_today' => $total_count_sale_this_week,
                        'total_earnings_today' => ($total_amount_sale_this_week - $total_inventory_amount_this_week),
                        'total_products_sale_today' => $total_products_sale_this_week
                    ];
                } else {
                    return [
                        'total_amount_sale_today' => 0,
                        'total_count_sale_today' => 0,
                        'total_earnings_today' => 0,
                        'total_products_sale_today' => 0
                    ];
                }
                break;
            case 3:
                $sales_this_month = Sale::whereIn('branch_id', $branches_id)->whereMonth('created_at', Carbon::now()->month);
                if ($sales_this_month->count() > 0) {
                    $total_amount_sale_this_month = $sales_this_month->sum('total_sale');
                    $total_count_sale_this_month  = $sales_this_month->count();
                    $total_inventory_amount_this_month = 0;
                    $total_products_sale_this_month = 0;
                    $sales_data = $sales_this_month->get();
                    foreach ($sales_data as $sale) {
                        foreach ($sale->sale_detail as $saleDetail) {
                            $total_products_sale_this_month +=  $saleDetail->quantity;
                            $total_inventory_amount_this_month +=  ($saleDetail->purchase_price * $saleDetail->quantity);
                        }
                    }
                    return [
                        'total_amount_sale_today' => $total_amount_sale_this_month,
                        'total_count_sale_today' => $total_count_sale_this_month,
                        'total_earnings_today' => ($total_amount_sale_this_month - $total_inventory_amount_this_month),
                        'total_products_sale_today' => $total_products_sale_this_month
                    ];
                } else {
                    return [
                        'total_amount_sale_today' => 0,
                        'total_count_sale_today' => 0,
                        'total_earnings_today' => 0,
                        'total_products_sale_today' => 0
                    ];
                }
                break;
            case 4:
                $sales_this_year = Sale::whereIn('branch_id', $branches_id)->whereYear('created_at', Carbon::now()->year);
                if ($sales_this_year->count() > 0) {
                    $total_amount_sale_this_year = $sales_this_year->sum('total_sale');
                    $total_count_sale_this_year  = $sales_this_year->count();
                    $total_inventory_amount_this_year = 0;
                    $total_products_sale_this_year = 0;
                    $sales_data = $sales_this_year->get();
                    foreach ($sales_data as $sale) {
                        foreach ($sale->sale_detail as $saleDetail) {
                            $total_products_sale_this_year +=  $saleDetail->quantity;
                            $total_inventory_amount_this_year +=  ($saleDetail->purchase_price * $saleDetail->quantity);
                        }
                    }
                    return [
                        'total_amount_sale_today' => $total_amount_sale_this_year,
                        'total_count_sale_today' => $total_count_sale_this_year,
                        'total_earnings_today' => ($total_amount_sale_this_year - $total_inventory_amount_this_year),
                        'total_products_sale_today' => $total_products_sale_this_year
                    ];
                } else {
                    return [
                        'total_amount_sale_today' => 0,
                        'total_count_sale_today' => 0,
                        'total_earnings_today' => 0,
                        'total_products_sale_today' => 0
                    ];
                }
                break;
        }
    }

    public function chartPieDataDashboard()
    {
        $range_id = request()->get("range_id", 1);
        $branches_id = Branch::where('company_id', auth()->user()->company_id)->pluck('id')->toArray();

        switch ($range_id) {
            case 1:
                $sales_today_cash = Sale::whereIn('branch_id', $branches_id)
                    ->whereDate('created_at',  Carbon::now()->toDateString())
                    ->where('payment_method_id', PaymentMethod::CASH)->sum('total_sale');

                $sales_today_card = Sale::whereIn('branch_id', $branches_id)
                    ->whereDate('created_at',  Carbon::now()->toDateString())
                    ->where('payment_method_id', PaymentMethod::CARD)->sum('total_sale');

                $sales_today_credit = Sale::whereIn('branch_id', $branches_id)
                    ->whereDate('created_at',  Carbon::now()->toDateString())
                    ->where('payment_method_id', PaymentMethod::CREDIT)->sum('total_sale');

                return [
                    'cash' => $sales_today_cash,
                    'card' => $sales_today_card,
                    'credit' => $sales_today_credit
                ];
                break;
            case 2:
                $sales_this_week_cash = Sale::whereIn('branch_id', $branches_id)
                    ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                    ->where('payment_method_id', PaymentMethod::CASH)->sum('total_sale');

                $sales_this_week_card = Sale::whereIn('branch_id', $branches_id)
                    ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                    ->where('payment_method_id', PaymentMethod::CARD)->sum('total_sale');

                $sales_today_credit = Sale::whereIn('branch_id', $branches_id)
                    ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                    ->where('payment_method_id', PaymentMethod::CREDIT)->sum('total_sale');

                return [
                    'cash' => $sales_this_week_cash,
                    'card' => $sales_this_week_card,
                    'credit' => $sales_today_credit

                ];
                break;
            case 3:
                $sales_this_month_cash = Sale::whereIn('branch_id', $branches_id)
                    ->whereMonth('created_at', Carbon::now()->month)
                    ->where('payment_method_id', PaymentMethod::CASH)->sum('total_sale');

                $sales_this_month_card = Sale::whereIn('branch_id', $branches_id)
                    ->whereMonth('created_at', Carbon::now()->month)
                    ->where('payment_method_id', PaymentMethod::CARD)->sum('total_sale');
                
                $sales_today_credit = Sale::whereIn('branch_id', $branches_id)
                    ->whereMonth('created_at', Carbon::now()->month)
                    ->where('payment_method_id', PaymentMethod::CREDIT)->sum('total_sale');

                return [
                    'cash' => $sales_this_month_cash,
                    'card' => $sales_this_month_card,
                    'credit' => $sales_today_credit
                ];
                break;
            case 4:
                $sales_this_year_cash = Sale::whereIn('branch_id', $branches_id)
                    ->whereYear('created_at', Carbon::now()->year)
                    ->where('payment_method_id', PaymentMethod::CASH)->sum('total_sale');

                $sales_this_year_card = Sale::whereIn('branch_id', $branches_id)
                    ->whereYear('created_at', Carbon::now()->year)
                    ->where('payment_method_id', PaymentMethod::CARD)->sum('total_sale');

                $sales_today_credit = Sale::whereIn('branch_id', $branches_id)
                    ->whereYear('created_at', Carbon::now()->year)
                    ->where('payment_method_id', PaymentMethod::CREDIT)->sum('total_sale');

                return [
                    'cash' => $sales_this_year_cash,
                    'card' => $sales_this_year_card,
                    'credit' => $sales_today_credit
                ];
        }
    }

    public function barDataChartDashboard()
    {
        $range_id = request()->get("range_id", 1);
        $branches_id = Branch::where('company_id', auth()->user()->company_id)->pluck('id')->toArray();
        switch ($range_id) {
            case 1:
                $sales_today = Sale::whereIn('branch_id', $branches_id)->whereDate('created_at',  Carbon::now()
                    ->toDateString())->orderBy('created_at', 'desc')->limit(10)->get();
                $labels     = [];
                $total_sales_data = [];
                $total_purchase_data = [];
                $total_earning_data = [];

                if ($sales_today->count() > 0) {
                    foreach ($sales_today as $sale) {
                        array_push($labels, 'Venta #' . $sale->id);
                        array_push($total_sales_data, $sale->total_sale);
                        $total_purchase = 0;
                        foreach ($sale->sale_detail as $saleDetail) {
                            $total_purchase +=  ($saleDetail->purchase_price * $saleDetail->quantity);
                        }
                        array_push($total_purchase_data, $total_purchase);
                        array_push($total_earning_data, ($sale->total_sale - $total_purchase));
                    }
                }
                return [
                    'labels' => $labels,
                    'total_sales_data' => $total_sales_data,
                    'total_purchase_data' => $total_purchase_data,
                    'total_earning_data' => $total_earning_data,
                    'title' => 'Ventas del día (10 últimas)'
                ];
                break;
            case 2:
                $current_date = Carbon::now()->startOfWeek();
                $labels = ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'];
                $total_sales_data = [];
                $total_purchase_data = [];
                $total_earning_data = [];

                while ($current_date->toDateString() <= Carbon::now()->endOfWeek()->toDateString()) {
                    $sales_today = Sale::whereIn('branch_id', $branches_id)->whereDate('created_at',  $current_date)->get();
                    $total_sales = 0;
                    $total_purchase = 0;
                    if ($sales_today->count() > 0) {
                        array_push($total_sales_data, $sales_today->sum('total_sale'));
                        foreach ($sales_today as $sale) {
                            foreach ($sale->sale_detail as $saleDetail) {
                                $total_purchase +=  ($saleDetail->purchase_price * $saleDetail->quantity);
                            }
                        }
                    } else {
                        array_push($total_sales_data, 0);
                    }
                    array_push($total_purchase_data, $total_purchase);
                    array_push($total_earning_data, ($sales_today->sum('total_sale') - $total_purchase));
                    $current_date = $current_date->addDay(1);
                }

                return [
                    'labels' => $labels,
                    'total_sales_data' => $total_sales_data,
                    'total_purchase_data' => $total_purchase_data,
                    'total_earning_data' => $total_earning_data,
                    'title' => 'Ventas de la semana (' . Carbon::now()->week . ') del: ' . Carbon::now()->startOfWeek()->format('d-m-Y') . ' al ' . Carbon::now()->endOfWeek()->format('d-m-Y')
                ];
                break;
            case 3:
                $startOfMonth = now()->startOfMonth();
                $endOfWeek = $startOfMonth->copy()->endOfWeek();
                $ranges = [[$startOfMonth->toDateString(), $endOfWeek->toDateString()]];
                while ($endOfWeek->copy()->addDay()->month == $startOfMonth->month) {
                    $start = $endOfWeek->copy()->addDay();
                    $end = $endOfWeek->copy()->addDay()->endOfWeek();
                    array_push($ranges, [$start->toDateString(), ($end->month == $start->month ? $end :
                        $start->copy()->endOfMonth())->toDateString()]);
                    $endOfWeek = $endOfWeek->copy()->addDay()->endOfWeek();
                }
                $labels = [];
                $total_sales_data = [];
                $total_purchase_data = [];
                $total_earning_data = [];

                foreach ($ranges as $range) {
                    $sales_today = Sale::whereIn('branch_id', $branches_id)->whereBetween('created_at', $range)->get();
                    $total_purchase = 0;
                    if ($sales_today->count() > 0) {
                        foreach ($sales_today as $sale) {
                            foreach ($sale->sale_detail as $saleDetail) {
                                $total_purchase +=  ($saleDetail->purchase_price * $saleDetail->quantity);
                            }
                        }
                        array_push($total_sales_data, $sales_today->sum('total_sale'));
                    } else {
                        array_push($total_sales_data, 0);
                    }
                    array_push($total_purchase_data, $total_purchase);
                    array_push($total_earning_data, ($sales_today->sum('total_sale') - $total_purchase));
                    array_push($labels, 'Semana ' . Carbon::parse($range[0])->week);
                }


                return [
                    'labels' => $labels,
                    'total_sales_data' => $total_sales_data,
                    'total_purchase_data' => $total_purchase_data,
                    'total_earning_data' => $total_earning_data,
                    'title' => 'Ventas de mes (' . Carbon::now()->month . ') del: ' . Carbon::now()->startOfMonth()->format('d-m-Y') . ' al ' . Carbon::now()->endOfMonth()->format('d-m-Y')
                ];
                break;

            case 4:
                $labels = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
                $total_sales_data = [];
                $total_purchase_data = [];
                $total_earning_data = [];

                for ($i = 0; $i < 12; $i++) {
                    $sales_month = Sale::query()->whereMonth('created_at', $i + 1)->whereYear('created_at', now()->year)->get();
                    $total_purchase = 0;

                    if ($sales_month->count() > 0) {
                        foreach ($sales_month as $sale) {
                            foreach ($sale->sale_detail as $saleDetail) {
                                $total_purchase +=  ($saleDetail->purchase_price * $saleDetail->quantity);
                            }
                        }
                        array_push($total_sales_data, $sales_month->sum('total_sale'));
                    } else {
                        array_push($total_sales_data, 0);
                    }
                    array_push($total_purchase_data, $total_purchase);
                    array_push($total_earning_data, ($sales_month->sum('total_sale') - $total_purchase));
                }

                return [
                    'labels' => $labels,
                    'total_sales_data' => $total_sales_data,
                    'total_purchase_data' => $total_purchase_data,
                    'total_earning_data' => $total_earning_data,
                    'title' => 'Ventas del año (' . Carbon::now()->year . ')'
                ];
                break;
        }
    }

    public function mostEarnedPerProduct()
    {
        $categories_id = Category::where('company_id', auth()->user()->company_id)->pluck('id');
        $products = Product::query()->whereIn('category_id', $categories_id)->get();
        $earnings = [];
        foreach ($products as $product) {
            $earnings[$product->id] = $product->sale_price - $product->purchase_price;
        }
        arsort($earnings);
        $final_data = [];
        foreach ($earnings as $key => $value) {
            $product = Product::findOrFail($key);
            array_push($final_data, [
                'name' => $product->name,
                'sale_price' => $product->sale_price,
                'purchase_price' => $product->purchase_price,
                'earning' => $value
            ]);
        }
        $final_data = array_slice($final_data, 0, 9);
        return $final_data;
    }

    public function mostProductSold()
    {
        //trabajar con la base de datos
    }

    public function calculateDates()
    {
        $payment_plan_id = request()->get("payment_plan_id", false);
        $deadline_id = request()->get("deadline_id", false);
        $total_sale = request()->get("total_sale", false);
        $current_pay_for_deadline = 0;
        $payments = [];
        $times_to_paid = 0;
        switch ($deadline_id) {
            case Sale::DEADLINETREE:
                $times_to_paid = 3;
                $current_pay_for_deadline = $total_sale / $times_to_paid;
                break;
            case Sale::DEADLINESIX:
                $times_to_paid = 6;
                $current_pay_for_deadline = $total_sale / $times_to_paid;

                break;
            case Sale::DEADLINETWELVE:
                $times_to_paid = 12;
                $current_pay_for_deadline = $total_sale / $times_to_paid;
                break;
            default:
                break;
        }


        switch ($payment_plan_id) {
            case Sale::WEEK:
                $current_date = Carbon::now();
                $current_amount = $total_sale;
                $current_paid = 0;
                $current_debt = 0;
                for ($i = 0; $i < $times_to_paid; $i++) {
                    $current_date = $current_date->addWeek();
                    $current_paid = $current_paid += $current_pay_for_deadline;
                    $current_debt = $current_amount - ($current_paid);
                    array_push($payments, [
                        'date' => $current_date->format('d-m-Y'),
                        'amount' => round($current_pay_for_deadline, 2),
                        'debt' => round($current_debt, 2),
                        'current_paid' => round($current_paid, 2)
                    ]);
                }

                break;
            case Sale::FORTNIGHT:
                $current_date = Carbon::now();
                $current_amount = $total_sale;
                $current_paid = 0;
                $current_debt = 0;
                for ($i = 0; $i < $times_to_paid; $i++) {
                    $current_date = $current_date->addDays(15);
                    $current_paid = $current_paid += $current_pay_for_deadline;
                    $current_debt = $current_amount - ($current_paid);
                    array_push($payments, [
                        'date' => $current_date->format('d-m-Y'),
                        'amount' => round($current_pay_for_deadline, 2),
                        'debt' => round($current_debt, 2),
                        'current_paid' => round($current_paid, 2)
                    ]);
                }
                break;
            case Sale::MONTH:
                $current_date = Carbon::now();
                $current_amount = $total_sale;
                $current_paid = 0;
                $current_debt = 0;
                for ($i = 0; $i < $times_to_paid; $i++) {
                    $current_date = $current_date->addMonth();
                    $current_paid = $current_paid += $current_pay_for_deadline;
                    $current_debt = $current_amount - ($current_paid);
                    array_push($payments, [
                        'date' => $current_date->format('d-m-Y'),
                        'amount' => round($current_pay_for_deadline, 2),
                        'debt' => round($current_debt, 2),
                        'current_paid' => round($current_paid, 2)
                    ]);
                }
                break;
            default:
                break;
        }
        return $payments;
    }

    public function getSalesDates(){
        $id = request()->get("id", 1);
        $sale = Sale::findOrFail($id);
        $payment_dates = PaymentDate::where('sale_id', $id)->get();
        $current_total_paid = PaymentDate::where('sale_id', $id)->sum('total_paid');
        $data = [];
        foreach ($payment_dates as $payment_date){
            array_push($data, [
                'date' => Carbon::parse($payment_date->date)->format('d-m-Y'),
                'amount' => $payment_date->amount,
                'status' => $payment_date->amount - $payment_date->total_paid <= 0.1 ? 'Pagado': (Carbon::parse($payment_date->date) < Carbon::now() ? 'Atrasado' : 'Vigente' ),
                'debt' => $payment_date->amount - $payment_date->total_paid ?? 0,
                'total_paid' => $payment_date->total_paid ? $payment_date->total_paid : 0
            ]);
        }
        $total_debt = $sale->total_sale - $current_total_paid;

        return [
            'payment_dates' => $data,
            'total_debt' => $total_debt,
            'current_total_paid' => $current_total_paid,
            'total_sale' => $sale->total_sale
        ];
    }

    public function storePayment(PaymentRequest $request){
        $remainig_to_pay = $request->amount;
        $payment_dates = PaymentDate::where('sale_id', $request->sale_id)->whereRaw('total_paid < amount')->orderBy('date', 'asc')->get();
        $payments = collect();
        while ($remainig_to_pay > 0) {
            if (sizeof($payment_dates) != 0) {
                if ($payment_dates->first()->date > Carbon::now()->toDateString()) {
                    $date_to_pay = $payment_dates->pop();
                } else {
                    $date_to_pay = $payment_dates->shift();
                }

                $date_debt = $date_to_pay->amount - $date_to_pay->total_paid;
                $payment = new Payment();
                $payment->payment_date_id = $date_to_pay->id;
                $payment->amount = $date_debt > $remainig_to_pay ? $remainig_to_pay : $date_debt;
                $payment->paid_at = Carbon::now();
                if($request->payment_method_id == 1){
                    $payment->received_amount = $request->received_amount;
                }
                if($request->payment_method_id == 2){
                    $payment->reference_code = $request->reference_code;
                }
                $payment->save();

                $payments->push($payment);
                $remainig_to_pay -= $date_debt;
            }
        }

        return $payments;
    }

    public function export()
    {
        return Excel::download(new SalesExport, 'Ventas.xlsx');
    }
}
