<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToArray;
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
