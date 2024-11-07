<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class StudReportExport implements FromCollection, WithHeadings, WithEvents, WithStrictNullComparison
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $students;

    public function __construct($students)
    {
        $this->students = $students;
    }

    public function collection()
    {
        // Retornar la colección de estudiantes procesada
        return collect($this->students)->map(function($student) {

            return [
                'CIF' => $student['student']->user->cif,
                'Nombre' => $student['student']->user->name,
                'Apellido' => $student['student']->user->lastname,
                'Carrera' => $student['student']->degree->name,
                'Total Horas' => $student['total_hours'],
                'Estado' => $student['status'],
            ];
        });
    }

    public function headings(): array
    {
        return [
            'CIF',
            'Nombre',
            'Apellido',
            'Carrera',
            'Total Horas',
            'Estado',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $studentsCount = $this->students->count();

                $dataRange = 'E2:E' . ($studentsCount+1);
                $event->sheet->getStyle($dataRange)->getNumberFormat()->setFormatCode('#,##0');

                $cellRange = 'A1:F1';

                $event->sheet->getStyle($cellRange)->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'color' => ['rgb' => '0099A8'],
                    ],
                    'font' => [
                        'bold' => true, 
                    ],
                ]);
                
               
                $dataRange = 'A1:F' . ($studentsCount +1);

             
                $event->sheet->getStyle($dataRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'], 
                        ],
                    ],
                
                ]);

                foreach (range('A', 'F') as $column) {
                    $event->sheet->getColumnDimension($column)->setAutoSize(true);
                }

                $event->sheet->getStyle('A1:F' . $event->sheet->getHighestRow())
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            },

        ];
    }
}
