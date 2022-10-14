<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LocationExport implements FromCollection, WithHeadings
{
	protected $data;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($data){
        $this->data = $data;
    }

    public function collection()
    {
        return collect($this->data);
    }

    public function headings() :array{
        return [
            'Location Name',
            'Address',
            'Latitude',
            'Longitude',
            'Max Radius',
            'Added By(Name)',
            'Added by(EmpId)',
            'Added Date'
        ];
    }
}
