<?php

namespace App\Exports;

use App\Exports\Sheets\AreaDailyRecordsSheet;
use App\Models\Area;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class DailyRecordsExport implements WithMultipleSheets
{
    protected $areas;

    public function __construct()
    {
        $this->areas = Area::all(); // Obtener todas las áreas para generar hojas por área
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];
        foreach ($this->areas as $area) {
            $sheets[] = new AreaDailyRecordsSheet($area); // Crear una hoja por cada área
        }

        return $sheets;
    }
}