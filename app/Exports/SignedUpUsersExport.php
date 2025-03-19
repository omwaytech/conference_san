<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SignedUpUsersExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    public $users;

    public function __construct()
    {
        $this->users = User::where(['status' => 1, 'role' => 2])->orderBy('f_name', 'ASC')->get();
    }

    public function collection()
    {
        foreach ($this->users as $key => $value) {
            if (!empty($value->conferenceRegistration)) {
                $registeredStatus = 'Yes';
            } else {
                $registeredStatus = 'No';
            }

            if ($value->workshopRegistration->count() > 0) {
                $totalRegisteredWorkshops = $value->workshopRegistration->count();
            } else {
                $totalRegisteredWorkshops = '0';
            }

            $arrayData[] = [
                'S.No.' => $key + 1,
                'Name' => $value->fullName($value),
                'Email' => $value->email,
                'Phone' => $value->userDetail->phone,
                'Has Registered Conference?' => $registeredStatus,
                'No. of Workshop Registrations' => $totalRegisteredWorkshops,
            ];
        }

        return collect($arrayData);
    }

    public function headings(): array
    {
        return ["S.No.", "Name", "Email", "Phone", "Has Registered Conference?", "No. of Workshop Registrations"];
    }
}
