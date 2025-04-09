<?php

namespace App\Exports;

use App\Models\Sponsor;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SponsorExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $sponsor = Sponsor::where('status', 1)->orderBy('name','ASC')->get();

        foreach ($sponsor as $key => $value) {


            $arrayData[] = [
                'S.No.' => $key + 1,
                'Name' => $value->name,
                'Registration Id' => $value->registration_id,
            ];
        }
        return collect($arrayData);
    }

    public function headings(): array
    {
        return ["S.No.", "Name", "Registration Id"];
    }
}
