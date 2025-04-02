<?php

namespace App\Exports;

use App\Models\ConferenceRegistration;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ConferenceRegistrationExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    public $participants;
    public $type;
    public $memberTypeId;
    public $voucherAttached;
    public function __construct($type)
    {
        $conference = session()->get('conferenceDetail');
        if ($type == 'attendees') {
            $this->participants = ConferenceRegistration::where(['registrant_type' => 1, 'is_invited' => 0, 'conference_registrations.status' => 1, 'conference_id' => $conference->id])
                ->join('users', 'conference_registrations.user_id', '=', 'users.id')
                ->orderBy('users.f_name', 'asc')
                ->get();
        } elseif ($type == 'presenters') {
            $this->participants = ConferenceRegistration::where(['registrant_type' => 2, 'is_invited' => 0, 'conference_registrations.status' => 1, 'conference_id' => $conference->id])
                ->join('users', 'conference_registrations.user_id', '=', 'users.id')
                ->orderBy('users.f_name', 'asc')
                ->get();
        } elseif ($type == 'guest-attendees') {
            $this->participants = ConferenceRegistration::where(['registrant_type' => 1, 'is_invited' => 1, 'conference_registrations.status' => 1, 'conference_id' => $conference->id])
                ->join('users', 'conference_registrations.user_id', '=', 'users.id')
                ->orderBy('users.f_name', 'asc')
                ->get();
        } elseif ($type == 'guest-presenters') {
            $this->participants = ConferenceRegistration::where(['registrant_type' => 2, 'is_invited' => 1, 'conference_registrations.status' => 1, 'conference_id' => $conference->id])
                ->join('users', 'conference_registrations.user_id', '=', 'users.id')
                ->orderBy('users.f_name', 'asc')
                ->get();
        } elseif ($type == 'all') {
            $this->participants = ConferenceRegistration::where(['conference_registrations.status' => 1, 'conference_id' => $conference->id])
                ->join('users', 'conference_registrations.user_id', '=', 'users.id')
                ->orderBy('users.f_name', 'asc')
                ->get();
        } elseif ($type == 'national') {
            $this->participants = ConferenceRegistration::where(['verified_status' => 1, 'status' => 1, 'conference_id' => $conference->id])
                ->whereHas('userDetail', function ($query) {
                    $query->whereHas('memberType', function ($subquery) {
                        $subquery->where('delegate', 'National');
                    });
                })->latest()->get();
        } elseif ($type == 'international') {
            $this->participants = ConferenceRegistration::where(['verified_status' => 1, 'status' => 1, 'conference_id' => $conference->id])
                ->whereHas('userDetail', function ($query) {
                    $query->whereHas('memberType', function ($subquery) {
                        $subquery->where('delegate', 'International');
                    });
                })->latest()->get();
        }
        $this->type = $type;
    }
    // public function __construct($type, $memberTypeId = null, $voucherAttached = null)
    // {
    //     $conference = session()->get('conferenceDetail');

    //     $query = ConferenceRegistration::where(['conference_registrations.status' => 1, 'conference_id' => $conference->id])
    //         ->join('users', 'conference_registrations.user_id', '=', 'users.id');

    //     if ($type == 'attendees') {
    //         $query->where(['registrant_type' => 1, 'is_invited' => 0]);
    //     } elseif ($type == 'presenters') {
    //         $query->where(['registrant_type' => 2, 'is_invited' => 0]);
    //     } elseif ($type == 'guest-attendees') {
    //         $query->where(['registrant_type' => 1, 'is_invited' => 1]);
    //     } elseif ($type == 'guest-presenters') {
    //         $query->where(['registrant_type' => 2, 'is_invited' => 1]);
    //     } elseif ($type == 'all') {
    //     } elseif ($type == 'national') {
    //         $query->where(['verified_status' => 1])
    //             ->whereHas('userDetail', function ($q) {
    //                 $q->whereHas('memberType', function ($subq) {
    //                     $subq->where('delegate', 'National');
    //                 });
    //             });
    //     } elseif ($type == 'international') {
    //         $query->where(['verified_status' => 1])
    //             ->whereHas('userDetail', function ($q) {
    //                 $q->whereHas('memberType', function ($subq) {
    //                     $subq->where('delegate', 'International');
    //                 });
    //             });
    //     }

    //     if ($memberTypeId !== null) {
    //         $query->whereHas('userDetail', function ($q) use ($memberTypeId) {
    //             $q->where('member_type_id', $memberTypeId);
    //         });
    //     }

    //     if ($voucherAttached !== null) {
    //         if ($voucherAttached == 1) {
    //             $query->whereNotNull('payment_voucher')
    //                 ->where('payment_voucher', 'NOT LIKE', 'FonePay');
    //         } elseif ($voucherAttached == 2) {
    //             $query->where(function ($q) {
    //                 $q->whereNull('payment_voucher')
    //                     ->orWhere('payment_voucher', 'FonePay');
    //             });
    //         }
    //     }

    //     $this->participants = $query->orderBy('users.f_name', 'asc')->get();
    //     $this->type = $type;
    //     dd($this->participants);
    // }


    public function collection()
    {
        foreach ($this->participants as $key => $value) {
            if (!empty($value->user->userDetail->country_id)) {
                $countryName = $value->user->userDetail->country->country_name;
            } else {
                $countryName = 'Nepal';
            }

            if ($value->verified_status == 1) {
                $status = 'Verified';
            } elseif ($value->verified_status == 0) {
                $status = 'Unverified';
            } else {
                $status = 'Rejected';
            }

            if ($this->type == 'all') {
                if ($value->registrant_type == 1 && $value->is_invited == 0) {
                    $participantType = 'Attendee';
                } elseif ($value->registrant_type == 2 && $value->is_invited == 0) {
                    $participantType = 'Speaker';
                } elseif ($value->registrant_type == 1 && $value->is_invited == 1) {
                    $participantType = 'Guest-Attendee';
                } elseif ($value->registrant_type == 2 && $value->is_invited == 1) {
                    $participantType = 'Guest-Speaker';
                }

                if ($value->committeMember->isNotEmpty()) {
                    $color = 'red';
                } elseif ($value->registrant_type == 1) {
                    $color = 'Sky Blue';
                } elseif ($value->registrant_type == 2) {
                    $color = 'Green';
                }

                $arrayData[] = [
                    'S.No.' => $key + 1,
                    'Name' => $value->user->fullName($value, 'user'),
                    'Type' => $value->user->userDetail->memberType->type ?? null,
                    'Email' => $value->user->email,
                    'Phone' => $value->user->userDetail->phone,
                    'councilNumber' => $value->user->userDetail->council_number,
                    'totalAttendee' => $value->total_attendee,
                    'status' => $status,
                    'country' => $countryName,
                    'participantType' => $participantType,
                    'registrationId' => $value->registration_id,
                    'color' => $color,

                ];
            } else {
                $arrayData[] = [
                    'S.No.' => $key + 1,
                    'Name' => $value->user->fullName($value, 'user'),
                    'Type' => $value->user->userDetail->memberType->type ?? null,
                    'Email' => $value->user->email,
                    'Phone' => $value->user->userDetail->phone,
                    'councilNumber' => $value->user->userDetail->council_number,
                    'totalAttendee' => $value->total_attendee,
                    'status' => $status,
                    'country' => $countryName,
                    'registrationId' => $value->registration_id,

                ];
            }
        }

        return collect($arrayData);
    }

    public function headings(): array
    {
        if ($this->type == 'all') {
            return ["S.No.", "Name", "Member Type", "Email", "Phone", "Medical Council Number", "No. of People", "Verification Status", "Country", "Participant Type", 'Registration Id','color'];
        } else {
            return ["S.No.", "Name", "Member Type", "Email", "Phone", "Medical Council Number", "No. of People", "Verification Status", "Country", 'Registration Id'];
        }
    }
}
