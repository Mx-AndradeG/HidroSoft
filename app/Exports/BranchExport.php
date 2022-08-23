<?php

namespace App\Exports;

use App\Models\Branch\Branch;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BranchExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = Branch::query()->where('company_id', auth()->user()->company_id);
        $data = $query->get();
        $data = $data->map(function ($_data) {
            $_data = $_data->only(
                "name",
                "address",
                "phone",
                "Formatted_created_at",
            );
            return $_data;
        });
        return $data;
    }

    public function headings(): array
    {
        return ["Nombre", "Direccion", "Telefono", "Fecha de creacion"];
    }
}
