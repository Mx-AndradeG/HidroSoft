<?php

namespace App\Exports;

use App\Models\Branch\Branch;
use App\Models\Supplier\Supplier;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SupplierExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = Supplier::query()->where('company_id', auth()->user()->company_id);

        $data = $query->get();
        $data = $data->map(function ($_data) {
            $_data = $_data->only(
                "company_name",
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
        return ["Nombre de Proveedor", "Domicilio", "Telefono", "Fecha de Registro"];
    }
}
