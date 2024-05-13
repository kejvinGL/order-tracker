<?php

namespace KejvinGL\OrderTracker\Exports;

use KejvinGL\OrderTracker\Models\Order;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OrderExport
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Order::all();
    }

    public function headings(): array
    {
        return ['Name', 'Email', 'External Id', 'Product', 'Price', 'Status', 'Error Message', 'Created At', 'Updated At'];
    }

    public function map($row): array
    {
        return [
            $row->name,
            $row->email,
            $row->external_id,
            $row->product,
            $row->price,
            $row->status,
            $row->error_message ?? null,
            Date::dateTimeToExcel($row->created_at),
            Date::dateTimeToExcel($row->updated_at),
        ];
    }

    public function columnFormats(): array
    {
        return [
            'H' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'I' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $start = 'A1';
        $end = 'I' . count($this->collection()) + 1;

        $sheet->getStyle($start . ':' . $end)->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => '141414'],
            ],
            'borders' => [
                'outline' => [
                    'borderStyle' => Border::BORDER_THICK,
                    'color' => ['argb' => '4b4b4b'],
                ],
                'vertical' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '4b4b4b']
                ]
            ],
        ]);

        return [
            1 => ['font' => ['bold' => true],
                'borders' => [
                    'bottom' => [
                        'borderStyle' => Border::BORDER_THICK,
                        'color' => ['argb' => '4b4b4b']
                    ],

                ]
            ],
        ];
    }

    public function defaultStyles(Style $defaultStyle)
    {
        return [
            'borders' => [
                '' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000']
                ]
            ],
            'font' => [
                'color' => ['argb' => 'ffffff'], // White color
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ];
    }

}
