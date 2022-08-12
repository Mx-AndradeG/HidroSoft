<?php

namespace App\Exports;

use App\Models\Branch\Branch;
use App\Models\Stock\Stock;
use App\Models\Storage\Storage;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class StockExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $branches_id = Branch::where('company_id', auth()->user()->company_id)->pluck('id')->toArray();
        $storages_id = Storage::whereIn('branch_id', $branches_id)->pluck('id')->toArray();
        $query = Stock::query()->where('quantity', '>', 0)->whereIn('storage_id', $storages_id);

        $data = $query->get();
        $data = $data->map(function ($_data) {
            $_data = $_data->only(
                "product_name",
                "storage_name",
                "quantity",
            );
            return $_data;
        });
        return $data;
    }

    public function headings(): array
    {
        return ["Producto", "Almacen", "Cantidad"];
    }
}
