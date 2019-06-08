<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ReportExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{

    private $aData;
    private $aHeading;

	public function __construct($aHeading, $aData)
	{
        $this->aData = $aData;
        $this->aHeading = $aHeading;
	}
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect($this->aData);
    }

    public function headings(): array
    {
        return $this->aHeading;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $headerCellRange = 'A1:H1'; // All headers
                $dataCellRange = 'A2:H' . strval(count($this->aData) + 1);

                
                $headerStyleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            'color' => ['argb' => '00000000'],
                        ],
                    ],
                ];

                $dataStyleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '00000000'],
                        ],
                    ],
                ];
                $event->sheet->getDelegate()->getStyle($headerCellRange)->getFont()->setSize(14);
                $event->sheet->getDelegate()->getStyle($headerCellRange)->applyFromArray($headerStyleArray);
                $event->sheet->getDelegate()->getStyle($dataCellRange)->applyFromArray($dataStyleArray);
                $event->sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);
            },
        ];
    }
}
