<?php

namespace App\Exports\Sheets;

use App\Models\Area;
use App\Models\DailyRecord;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;

class AreaDailyRecordsSheet implements FromArray, WithTitle
{
    protected $area;

    public function __construct(Area $area)
    {
        $this->area = $area;
    }

    /**
     * @return array
     */
    public function array(): array
    {
        return $this->dataForSheet();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->area->nombre; // Título de la hoja será el nombre del área
    }

    private function dataForSheet()
    {
        $records = DailyRecord::with(['bed.area', 'patient'])
            ->whereHas('bed.area', function ($query) {
                $query->where('id', $this->area->id); // Filtrar registros por el área actual
            })
            ->whereDate('fecha_registro', now()->toDateString()) // Filtrar solo los registros de hoy
            ->get();

        $data = [
            ['Cama', 'Paciente', 'Fecha Registro', 'Desayuno', 'Am10', 'Almuerzo', 'Pm4', 'Cena', 'Indicaciones', 'Diagnóstico'], // Encabezados
        ];

        foreach ($records as $record) {
            $data[] = [
                $record->bed->codigo,
                optional($record->patient)->nombreCompleto(), // Usando el método nombreCompleto() del modelo Patient
                $record->fecha_registro,
                $record->desayuno ?: 'No registrado',
                $record->am10 ?: 'No registrado',
                $record->almuerzo ?: 'No registrado',
                $record->pm4 ?: 'No registrado',
                $record->cena ?: 'No registrado',
                $record->indicaciones ?: 'N/A',
                $record->diagnostico ?: 'No especificado',
            ];
        }

        return $data;
    }

}