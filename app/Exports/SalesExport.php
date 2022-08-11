<?php

namespace App\Exports;

use App\Models\Branch\Branch;
use App\Models\Sale\Sale;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalesExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $branches_id = Branch::where('company_id', auth()->user()->company_id)->pluck('id')->toArray();

        $query = Sale::whereIn('branch_id', $branches_id);
        $data = $query->get();
        $data = $data->map(function ($_data) {
            $_data = $_data->only(
                "user_name",
                "branch_name",
                "customer_name",
                "payment_method_name",
                "formatted_total_sale",
                "Formatted_created_at"
            );
            return $_data;
        });

        return $data;
    }
    public function headings(): array
    {
        return ["Vendedor", "Sucursal", "Cliente", ' Metodo de pago', "Total de compra", "Fecha de venta"];
    }
}
