<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Sheet;



class DailyExport implements FromCollection, WithHeadings, WithEvents
{
    protected $data;
    /**
    * @return \Illuminate\Support\Collection
    */
    

    public function __construct($data){
        $this->list = $data['list'];
        $this->report_date = $data['report_date'];
    }

    public function collection()
    {
        return collect($this->list);
    }

    public function registerEvents(): array {
        
        return [
            BeforeSheet::class => function(BeforeSheet $event) {
                /** @var Sheet $sheet */
                $sheet = $event->sheet;

                $sheet->mergeCells('A1:O1');
                $sheet->setCellValue('A1', "Site Name: MT attendance");

                $sheet->mergeCells('A2:O2');
                $sheet->setCellValue('A2', "Report Date: ".date('d-M-Y H:i A'));

                $sheet->mergeCells('A3:O3');
                $sheet->setCellValue('A3', "Title: Daily Attendance Report");

                $sheet->mergeCells('A4:O4');
                $sheet->setCellValue('A4', "Date: ".$this->report_date);
            },
        ];
    }

    public function headings() :array{
        return [
                ['Sr.No','Name','Email','Employee Id','Zone','Ward','Department','Designation','Manager','In-Time','In-Map Url','Out-Time','Out-Map Url','Time spent','Status']

        ];
    }
}
