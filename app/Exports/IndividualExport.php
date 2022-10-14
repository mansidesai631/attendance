<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Sheet;



class IndividualExport implements FromCollection, WithHeadings, WithEvents
{
    protected $data;
    /**
    * @return \Illuminate\Support\Collection
    */
    

    public function __construct($data){
        $this->list = $data['list'];
        $this->report_date = $data['report_date'];
        $this->employee_name = $data['employee_name'];
        $this->employee_id = $data['employee_id'];
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

                $sheet->mergeCells('A1:K1');
                $sheet->setCellValue('A1', "Site Name: MT attendance");

                $sheet->mergeCells('A2:K2');
                $sheet->setCellValue('A2', "Report Date: ".date('d-M-Y H:i A'));

                $sheet->mergeCells('A3:K3');
                $sheet->setCellValue('A3', "Title: Individual Attendance Report");

                $sheet->mergeCells('A4:K4');
                $sheet->setCellValue('A4', "Date: ".$this->report_date);

                $sheet->mergeCells('A5:K5');
                $sheet->setCellValue('A5', "Name: ".$this->employee_name);

                $sheet->mergeCells('A6:K6');
                $sheet->setCellValue('A6', "Employee Id: ".$this->employee_id);
            },
        ];
    }

    public function headings() :array{
        return [
                ['Sr.No','Day','Date','In-Time','Out-Time','Time spent','In Location','Out Location','Status']

        ];
    }
}
