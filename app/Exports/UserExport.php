<?php

namespace App\Exports;

use App\Models\Branch\Branch;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $branches_id = Branch::where('company_id', auth()->user()->company_id)->pluck('id')->toArray();

        $query = User::whereIn('branch_id', $branches_id);
        $data = $query->get();
        $data = $data->map(function ($_data) {
            $_data = $_data->only(
                "name",
                "email",
                "user_type_name",
                "Formatted_created_at"
            );
            return $_data;
        });

        return $data;
    }
    public function headings(): array
    {
        return ["Nombre de Usuario", "Email", "Tipo / Rol", "Fecha de Registro"];
    }
}
