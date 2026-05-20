<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ReportsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $data;
    
    public function __construct($data)
    {
        $this->data = $data;
    }
    
    public function collection()
    {
        return collect($this->data);
    }
    
    public function headings(): array
    {
        return [
            'Utility Type',
            'Property Name',
            'Reading Date',
            'Previous Value',
            'Current Value',
            'Units Consumed'
        ];
    }
    
    public function map($row): array
    {
        return [
            $row->utility_type,
            $row->property_name,
            $row->reading_date,
            $row->previous_value,
            $row->current_value,
            $row->units_consumed
        ];
    }
}
