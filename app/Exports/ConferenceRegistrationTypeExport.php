<?php

namespace App\Exports;

use App\Models\ConferenceRegistration;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ConferenceRegistrationTypeExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public $type;

    public function __construct($type)
    {
        $this->type = $type;
    }
    public function collection()
    {
        $registrants = ConferenceRegistration::where(['conference_registrations.status' => 1])
            ->join('users', 'conference_registrations.user_id', '=', 'users.id')
            ->orderBy('users.f_name')
            ->get();

        $arrayData = [];
        $serialNumber = 1; // Initialize serial number counter

        foreach ($registrants as $registrant) {
            if ($this->type == 1 && $registrant->committeMember->isNotEmpty() && $registrant->user->userDetail->country_id == 125) {
                $arrayData[] = [
                    'S.No.' => $serialNumber++,
                    'Name' => $registrant->user->fullName($registrant, 'user'),
                    'Type' => $registrant->user->userDetail->memberType->type ?? null,
                    'Email' => $registrant->user->email,
                    'registrationId' => $registrant->registration_id,
                    'isPaid' => $registrant->is_paid == 2 ? 'Unpaid' : ''


                ];
            } elseif ($this->type == 2 && $registrant->user->userDetail->country_id != 125) {
                $arrayData[] = [
                    'S.No.' => $serialNumber++,
                    'Name' => $registrant->user->fullName($registrant, 'user'),
                    'Type' => $registrant->user->userDetail->memberType->type ?? null,
                    'Email' => $registrant->user->email,
                    'registrationId' => $registrant->registration_id,
                    'isPaid' => $registrant->is_paid == 2 ? 'Unpaid' : ''


                ];
            } elseif ($this->type == 3 && $registrant->user->userDetail->country_id == 125 && $registrant->registrant_type == 1 && !$registrant->committeMember->isNotEmpty()) {
                $arrayData[] = [
                    'S.No.' => $serialNumber++,
                    'Name' => $registrant->user->fullName($registrant, 'user'),
                    'Type' => $registrant->user->userDetail->memberType->type ?? null,
                    'Email' => $registrant->user->email,
                    'registrationId' => $registrant->registration_id,
                    'isPaid' => $registrant->is_paid == 2 ? 'Unpaid' : ''


                ];
            } elseif ($this->type == 4 && $registrant->user->userDetail->country_id == 125 && $registrant->registrant_type == 2 && !$registrant->committeMember->isNotEmpty()) {
                $arrayData[] = [
                    'S.No.' => $serialNumber++,
                    'Name' => $registrant->user->fullName($registrant, 'user'),
                    'Type' => $registrant->user->userDetail->memberType->type ?? null,
                    'Email' => $registrant->user->email,
                    'registrationId' => $registrant->registration_id,
                    'isPaid' => $registrant->is_paid == 2 ? 'Unpaid' : ''

                ];
            }
        }
        return collect($arrayData);
    }


    public function headings(): array
    {
        return ["S.No.", "Name", "Member Type", "Email", "Registration Id","Is Paid", "Day 1", "Day 2"];
    }
}
