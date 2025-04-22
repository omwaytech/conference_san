<?php

namespace App\Exports;

use App\Models\ConferenceRegistration;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use DB;

class AttendanceListExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $participants = ConferenceRegistration::where([
            'verified_status' => 1,
            'conference_registrations.status' => 1,
        ])
            ->join('users', 'conference_registrations.user_id', '=', 'users.id')
            ->join('user_details', 'conference_registrations.user_id', '=', 'user_details.user_id')
            ->orderBy('f_name', 'asc')
            ->whereNotNull('users.email')
            ->where(function ($query) {
                $query->where('attend_type', 1)
                    ->whereExists(function ($subQuery) {
                        $subQuery->select(DB::raw(1))
                            ->from('attendances')
                            ->whereRaw('attendances.conference_registration_id = conference_registrations.id');
                    });
            })
            ->get()
            ->unique('user_id');
        // dd($participants);
        foreach ($participants as $key => $value) {
            // if (!empty($value->user->userDetail->country_id)) {
            //     $countryName = $value->user->userDetail->country->country_name;
            // } else {
            // $countryName = 'India';
            // }

            $arrayData[] = [
                'S.No.' => $key + 1,
                'Name' => $value->user->fullName($value, 'user'),
                // 'Type' => $value->user->userDetail->memberType->type ?? null,
                'Email' => $value->user->email,
                'Phone' => $value->user->userDetail->phone,
                'councilNumber' => $value->user->userDetail->council_number,
                // 'totalAttendee' => $value->total_attendee,
                // 'country' => $value->user->userDetail->country->country_name,
            ];
        }
        return collect($arrayData);
    }

    public function headings(): array
    {
        return ["S.No.", "Name", "Email", "Phone", "Council Number"];
    }
}
