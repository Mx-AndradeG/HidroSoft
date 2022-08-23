<?php

namespace App\Exports;

use App\Models\Storage\Storage;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class StorageExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = Storage::query()->whereHas('branch', function ($query){
            return $query->where('company_id', auth()->user()->company_id);
        });

        $data = $query->get();
        $data = $data->map(function ($_data) {
            $_data = $_data->only(
                "name",
                "address",
                "branch_name",
                "Formatted_created_at",
            );
            return $_data;
        });
        return $data;
    }

    public function headings(): array
    {
        return ["Nombre", "Direccion", "Sucursal", "Fecha de creacion"];
    }
}
