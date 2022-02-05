<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;

class WaterReadingExport implements FromArray
{
    protected $water_readings;

    public function __construct(array $water_readings)
    {
        $this->water_readings = $water_readings;
    }

    public function array(): array
    {
        return $this->water_readings;
    }
}
