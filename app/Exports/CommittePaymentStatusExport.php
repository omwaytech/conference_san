<?php

namespace App\Exports;

use App\Models\CommitteeMember;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class CommittePaymentStatusExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $commetteMembers = CommitteeMember::where('status', 1)->get();

        foreach ($commetteMembers as $key => $commetteMember) {

            $arrayData[] = [

                'S.No.' => $key + 1,
                'Name' => $commetteMember->user->fullname($commetteMember, 'user'),
                'Email' => $commetteMember->user->email,
                'Phone' => $commetteMember->user->userDetail->phone,
                'Committee Name' => $commetteMember->committee->committee_name,
                'Has Paid?' => $commetteMember->user->conferenceRegistration ? 'Paid' : 'Unpaid'
            ];
        }

        return collect($arrayData);
    }

    public function headings(): array
    {
        return ['S.No.', "Name", "Email", "Phone", "Committee Name", 'Has Paid?'];
    }
}
