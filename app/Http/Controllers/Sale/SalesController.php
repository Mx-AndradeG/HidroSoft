<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sale\StoreSaleRequest;
use App\Models\Branch\Branch;
use App\Models\Categories\Category;
use App\Models\PaymentMethod\PaymentMethod;
use App\Models\Products\Product;
use App\Models\Sale\Sale;
use PhpParser\Node\Stmt\Switch_;
use Carbon\Carbon;

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

        $branches_id = Branch::where('company_id', auth()->user()->company_id)->pluck('id')->toArray();

        $query = Sale::whereIn('branch_id', $branches_id);

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

    public function getHeaderInfoDashboard()
    {
        $range_id = request()->get("range_id", 1);
        $branches_id = Branch::where('company_id', auth()->user()->company_id)->pluck('id')->toArray();
        switch($range_id){
            case 1:
                $sales_today = Sale::whereIn('branch_id', $branches_id)->whereDate('created_at',  Carbon::now()->toDateString());
                if($sales_today->count() > 0){
                    $total_amount_sale_today = $sales_today->sum('total_sale');
                    $total_count_sale_today  = $sales_today->count();
                    $total_inventory_amount_today = 0;
                    $total_products_sale_today = 0;
                    $sales_data = $sales_today->get();
                    foreach($sales_data as $sale){
                        foreach($sale->sale_detail as $saleDetail){
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
                }else{
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
                if($sales_this_week->count() > 0){
                    $total_amount_sale_this_week = $sales_this_week->sum('total_sale');
                    $total_count_sale_this_week  = $sales_this_week->count();
                    $total_inventory_amount_this_week = 0;
                    $total_products_sale_this_week = 0;
                    $sales_data = $sales_this_week->get();
                    foreach($sales_data as $sale){
                        foreach($sale->sale_detail as $saleDetail){
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
                }else{
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
                if($sales_this_month->count() > 0){
                    $total_amount_sale_this_month = $sales_this_month->sum('total_sale');
                    $total_count_sale_this_month  = $sales_this_month->count();
                    $total_inventory_amount_this_month = 0;
                    $total_products_sale_this_month = 0;
                    $sales_data = $sales_this_month->get();
                    foreach($sales_data as $sale){
                        foreach($sale->sale_detail as $saleDetail){
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
                }else{
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
                if($sales_this_year->count() > 0){
                    $total_amount_sale_this_year = $sales_this_year->sum('total_sale');
                    $total_count_sale_this_year  = $sales_this_year->count();
                    $total_inventory_amount_this_year = 0;
                    $total_products_sale_this_year = 0;
                    $sales_data = $sales_this_year->get();
                    foreach($sales_data as $sale){
                        foreach($sale->sale_detail as $saleDetail){
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
                }else{
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

    public function chartPieDataDashboard(){
        $range_id = request()->get("range_id", 1);
        $branches_id = Branch::where('company_id', auth()->user()->company_id)->pluck('id')->toArray();

        switch($range_id){
            case 1:
                $sales_today_cash = Sale::whereIn('branch_id', $branches_id)
                                    ->whereDate('created_at',  Carbon::now()->toDateString())
                                    ->where('payment_method_id', PaymentMethod::CASH)->sum('total_sale');

                $sales_today_card = Sale::whereIn('branch_id', $branches_id)
                                    ->whereDate('created_at',  Carbon::now()->toDateString())
                                    ->where('payment_method_id', PaymentMethod::CARD)->sum('total_sale');                    

                return [
                    'cash' => $sales_today_cash,
                    'card' => $sales_today_card
                ];
            break;
            case 2:
                $sales_this_week_cash = Sale::whereIn('branch_id', $branches_id)
                                    ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                                    ->where('payment_method_id', PaymentMethod::CASH)->sum('total_sale');
                                    
                $sales_this_week_card = Sale::whereIn('branch_id', $branches_id)
                                    ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                                    ->where('payment_method_id', PaymentMethod::CARD)->sum('total_sale');
                                    
                return [
                    'cash' => $sales_this_week_cash,
                    'card' => $sales_this_week_card
                ];
            break;
            case 3:
                $sales_this_month_cash = Sale::whereIn('branch_id', $branches_id)
                                    ->whereMonth('created_at', Carbon::now()->month)
                                    ->where('payment_method_id', PaymentMethod::CASH)->sum('total_sale');
                                    
                $sales_this_month_card = Sale::whereIn('branch_id', $branches_id)
                                    ->whereMonth('created_at', Carbon::now()->month)
                                    ->where('payment_method_id', PaymentMethod::CARD)->sum('total_sale');
                                    
                return [
                    'cash' => $sales_this_month_cash,
                    'card' => $sales_this_month_card
                ];
            break;
            case 4:
                $sales_this_year_cash = Sale::whereIn('branch_id', $branches_id)
                                    ->whereYear('created_at', Carbon::now()->year)
                                    ->where('payment_method_id', PaymentMethod::CASH)->sum('total_sale');
                                    
                $sales_this_year_card = Sale::whereIn('branch_id', $branches_id)
                                    ->whereYear('created_at', Carbon::now()->year)
                                    ->where('payment_method_id', PaymentMethod::CARD)->sum('total_sale');
                                    
                return [
                    'cash' => $sales_this_year_cash,
                    'card' => $sales_this_year_card
                ];
            }
    }

    public function barDataChartDashboard(){
        $range_id = request()->get("range_id", 1);
        $branches_id = Branch::where('company_id', auth()->user()->company_id)->pluck('id')->toArray();
        switch($range_id){
            case 1:
                $sales_today = Sale::whereIn('branch_id', $branches_id)->whereDate('created_at',  Carbon::now()
                                    ->toDateString())->orderBy('created_at', 'desc')->limit(10)->get();
                $labels     = [];
                $total_sales_data = [];
                $total_purchase_data = [];
                $total_earning_data = [];

                if($sales_today->count() > 0){
                    foreach($sales_today as $sale){
                        array_push($labels, 'Venta #'.$sale->id);
                        array_push($total_sales_data, $sale->total_sale);
                        $total_purchase = 0;
                        foreach($sale->sale_detail as $saleDetail){
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

                while($current_date->toDateString() <= Carbon::now()->endOfWeek()->toDateString()){
                    $sales_today = Sale::whereIn('branch_id', $branches_id)->whereDate('created_at',  $current_date)->get();
                    $total_sales = 0;
                    $total_purchase = 0;
                    if($sales_today->count() > 0){
                        array_push($total_sales_data, $sales_today->sum('total_sale'));                        
                        foreach($sales_today as $sale){
                            foreach($sale->sale_detail as $saleDetail){
                                $total_purchase +=  ($saleDetail->purchase_price * $saleDetail->quantity);
                            }
                        }
                    }else{
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
                    'title' => 'Ventas de la semana ('.Carbon::now()->week.') del: '.Carbon::now()->startOfWeek()->format('d-m-Y').' al '.Carbon::now()->endOfWeek()->format('d-m-Y')
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
                    if($sales_today->count() > 0){
                        foreach($sales_today as $sale){
                            foreach($sale->sale_detail as $saleDetail){
                                $total_purchase +=  ($saleDetail->purchase_price * $saleDetail->quantity);
                            }
                        }
                        array_push($total_sales_data, $sales_today->sum('total_sale'));
                    }else{
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
                    'title' => 'Ventas de mes ('.Carbon::now()->month.') del: '.Carbon::now()->startOfMonth()->format('d-m-Y').' al '.Carbon::now()->endOfMonth()->format('d-m-Y')
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

                    if($sales_month->count() > 0){
                        foreach($sales_month as $sale){
                            foreach($sale->sale_detail as $saleDetail){
                                $total_purchase +=  ($saleDetail->purchase_price * $saleDetail->quantity);
                            }
                        }
                        array_push($total_sales_data, $sales_month->sum('total_sale'));
                    }else{
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
                    'title' => 'Ventas del año ('.Carbon::now()->year.')'
                ];
            break;

        }
    }

    public function mostEarnedPerProduct(){
        $categories_id = Category::where('company_id', auth()->user()->company_id)->pluck('id');
        $products = Product::query()->whereIn('category_id', $categories_id)->get();
        $earnings = [];
        foreach($products as $product){
            $earnings[$product->id] = $product->sale_price - $product->purchase_price;
        }
        arsort($earnings);
        $final_data = [];
        foreach($earnings as $key => $value) {
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

    public function mostProductSold(){
        //trabajar con la base de datos
    }
}
