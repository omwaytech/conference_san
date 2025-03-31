<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class WorkshopTrainerExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public $workshop;

    public function __construct($workshop)
    {
        $this->workshop = $workshop;
    }
    public function collection()
    {
        $arrayData = []; 
        $serial = 1; 

        $trainers = $this->workshop->trainers
            ->where('status', 1)
            ->sortBy('name');

        foreach ($trainers as $value) {
            $arrayData[] = [
                'S.No.' => $serial++, 
                'Name' => $value->name,
                'Affiliation' => $value->affiliation,
            ];
        }

        return collect($arrayData);
    }



    public function headings(): array
    {
        return ["S.No.", "Name", "Affiliation"];
    }
}
