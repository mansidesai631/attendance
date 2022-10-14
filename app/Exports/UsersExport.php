<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class UsersExport implements FromCollection, WithHeadings
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
            'Name',
            'Employee id',
            'Mobile',
            'Manager',
            'Contractor',
            'Designation',
            'Department',
            'Joining Date',
            'Auto Deactivate Staff on',
            'Role'
        ];
    }
}
