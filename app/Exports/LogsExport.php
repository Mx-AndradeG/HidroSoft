<?php

namespace App\Exports;

use App\Models\Branch\Branch;
use App\Models\Log\Log;
use App\Models\Stock\Stock;
use App\Models\Storage\Storage;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class LogsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = Log::query()->where('company_id', auth()->user()->company_id);

        $data = $query->get();
        $data = $data->map(function ($_data) {
            $_data = $_data->only(
                "user_name",
                "module",
                "action",
                "Formatted_created_at"
            );
            return $_data;
        });
        return $data;
    }

    public function headings(): array
    {
        return ["Usuario", "Modulo", "Tipo", "Fecha"];
    }
}
