<?php

namespace App\Exports;

use App\Models\Products\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = Product::query()->whereHas('category', function ($query){
            return $query->where('company_id', auth()->user()->company_id);
        });

        $data = $query->get();
        $data = $data->map(function ($_data) {
            $_data = $_data->only(
                'name',
                'purchase_price',
                'description',
                'code',
                'sale_price',
                'category_name',
                'supplier_name',
                'Formatted_created_at'
            );
            return $_data;
        });

        return $data;
    }
    public function headings(): array
    {
        return ["Nombre", "Precio de compra", "Descripcion", "Codigo", "Precio de venta", "Categoria", "Proveedor", "Fecha de Registro"];
    }
}
