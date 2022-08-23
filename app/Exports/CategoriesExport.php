<?php

namespace App\Exports;

use App\Models\Categories\Category;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class CategoriesExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = Category::query()->where('company_id', auth()->user()->company_id);

        $data = $query->get();
        $data = $data->map(function ($_data) {
            $_data = $_data->only(
                "name",
                "description",
                "Formatted_created_at",
            );
            return $_data;
        });
        return $data;
    }

    public function headings(): array
    {
        return ["Nombre", "Descripcion", "Fecha de creacion"];
    }
}
