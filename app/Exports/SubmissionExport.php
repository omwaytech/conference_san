<?php

namespace App\Exports;

use App\Models\Conference;
use App\Models\Submission;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SubmissionExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public $submission;

    public function __construct()
    {
        $conference = Conference::latestConference();
        $this->submission = Submission::where(['submissions.status' => 1, 'conference_id' => $conference->id])
            ->join('users', 'submissions.user_id', '=', 'users.id')
            ->orderBy('users.f_name', 'asc')
            ->get();
    }
    public function collection()
    {
        foreach ($this->submission as $key => $value) {
            if (!empty($value->user->userDetail->country_id)) {
                $countryName = $value->user->userDetail->country->country_name;
            } else {
                $countryName = 'Nepal';
            }

            if ($value->request_status == 1) {
                $status = 'Accepted';
            } elseif ($value->request_status == 0) {
                $status = 'Pending';
            } elseif ($value->request_status == 3) {
                $status = 'Rejected';
            } else {
                $status = 'Correction';
            }
            if (!empty($value->user->conferenceRegistration)) {
                $registeredStatus = 'Yes';
            } else {
                $registeredStatus = 'No';
            }
            $arrayData[] = [
                'S.No.' => $key + 1,
                'Name' => $value->user->fullName($value, 'user'),
                'Type' => $value->user->userDetail->memberType->type ?? null,
                'presentationType' => $value->presentation_type == 1 ? 'Poster' : 'Oral(Abstract)',
                'Email' => $value->user->email,
                // 'Has Registered Conference?' => $registeredStatus,
                'councilNumber' => $value->user->userDetail->council_number,
                'requestStatus' => $status,
                'country' => $countryName,
                'shortCv' => $value->conferenceRegistration ? strip_tags(html_entity_decode($value->conferenceRegistration->description)) : null

            ];
        }

        return collect($arrayData);
    }
    public function headings(): array
    {
        return ["S.No.", "Name", "Member Type", "Presentation Type", "Email", "Medical Council Number", "Request Status", "Country", 'shortCv'];
    }
}
