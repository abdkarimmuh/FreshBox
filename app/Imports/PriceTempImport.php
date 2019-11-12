<?php

namespace App\Imports;

use App\PriceTemp;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PriceTempImport implements WithHeadingRow, ToArray
{

    /**
     * @param array $array
     * @return array
     */
    public function array(array $array)
    {
        return $array;
    }
}
