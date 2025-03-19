<?php

namespace App\Exports;

use App\Models\Conference;
use App\Models\ConferenceRegistration;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ConferenceRegisrationIndian implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $latestConference = Conference::latestConference();
        $query = ConferenceRegistration::where(['conference_registrations.status' => 1, 'conference_id' => $latestConference->id])
            ->join('users', 'conference_registrations.user_id', '=', 'users.id')->orderBy('users.f_name', 'asc')->get();

        foreach ($query as $key => $value) {
            // if (!empty($value->user->userDetail->country_id)) {
            //     $countryName = $value->user->userDetail->country->country_name;
            // } else {
            // $countryName = 'India';
            // }

            if ($countryName = $value->user->userDetail->country->country_name == 'India') {

                $arrayData[] = [
                    'S.No.' => $key + 1,
                    'Name' => $value->user->fullName($value, 'user'),
                    'Type' => $value->user->userDetail->memberType->type,
                    'Email' => $value->user->email,
                    'Phone' => $value->user->userDetail->phone,
                    'councilNumber' => $value->user->userDetail->council_number,
                    'totalAttendee' => $value->total_attendee,
                    'country' => $value->user->userDetail->country->country_name,
                    'isInvited' => $value->is_invited == 1 ? 'Invited' : 'Self Registred'
                ];
            }
        }
        return collect($arrayData);
    }

    public function headings(): array
    {
        return ["S.No.", "Name", "Member Type", "Email", "Phone", "Medical Council Number", "No. of People", "Country",'Registation Type'];
    }
}
