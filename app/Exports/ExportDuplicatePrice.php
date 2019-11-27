<?php

namespace App\Exports;

use App\PriceTemp;
use Illuminate\Database\Query\Builder;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;

class ExportDuplicatePrice implements FromQuery
{
    use Exportable;

    /**
     * @return Builder
     */
    public function query()
    {
        return PriceTemp::query()->whereNotNull('updated_at');
    }
}
