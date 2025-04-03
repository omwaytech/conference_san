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
            if ($value->request_status == 1) {
                $affiliationDetails = trim(
                    implode(', ', array_filter([
                        $value->user->userDetail->affiliation ?? '',
                        $value->user->userDetail->institute_name ?? '',
                        $value->user->userDetail->address ?? ''
                    ]))
                );
                $arrayData[] = [
                    'S.No.' => $key + 1,
                    'presentationType' => $value->presentation_type == 1 ? 'Poster' : 'Oral(Abstract)',
                    'topic' => $value->topic,
                    'Name' => $value->user->fullName($value, 'user'),
                    'Affiliation' => $affiliationDetails,
                    'Type' => $value->user->userDetail->memberType->type ?? null,
                    'Email' => $value->user->email,
                    'Phone' => $value->user->userDetail->phone,
                    'councilNumber' => $value->user->userDetail->council_number,
                    'country' => $countryName,

                ];
            }
        }

        return collect($arrayData);
    }
    public function headings(): array
    {
        return ["S.No.", "Presentation Type", "Title", "Name", "Affiliation", "Member Type", "Email", "Phone Number", " Council Number", "Country"];
    }
}
