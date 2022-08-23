<?php

namespace App\Exports;

use App\Models\Customer\Customer;
use App\Models\Storage\Storage;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class CustomerExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = Customer::query()->where('company_id', auth()->user()->company_id);

        $data = $query->get();
        $data = $data->map(function ($_data) {
            $_data = $_data->only(
                "name",
                "address",
                "email",
                "phone",
                "rfc",
                "social",
                "Formatted_created_at",
            );
            return $_data;
        });
        return $data;
    }

    public function headings(): array
    {
        return ["Nombre", "Direccion", "Email", "Telefono", "RFC", "Razon Sócial", "Fecha de creacion"];
    }
}
