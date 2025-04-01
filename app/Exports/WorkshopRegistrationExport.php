<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class WorkshopRegistrationExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    public $workshop;

    public function __construct($workshop)
    {
        $this->workshop = $workshop;
    }

    public function collection()
    {
        foreach ($this->workshop->registrations->where('verified_status', 1)->where('status', 1) as $key => $value) {
            if (!empty($value->user->userDetail->country_id)) {
                $countryName = $value->user->userDetail->country->country_name;
            } else {
                $countryName = 'Nepal';
            }

            $arrayData[] = [
                'S.No.' => $key + 1,
                'Name' => $value->user->fullName($value, 'user'),
                'Type' => $value->user->userDetail->memberType->type ?? null,
                'Email' => $value->user->email,
                'Phone' => $value->user->userDetail->phone,
                'councilNumber' => $value->user->userDetail->council_number,
                'country' => $countryName,
                'MealType' => $value->meal_type == 1 ? 'Veg' : ($value->meal_type == 2 ? 'Non-Veg' : ''),
            ];
        }
        return collect($arrayData);
    }

    public function headings(): array
    {
        return ["S.No.", "Name", "Member Type", "Email", "Phone", "Medical Council Number", "Country"];
    }
}
