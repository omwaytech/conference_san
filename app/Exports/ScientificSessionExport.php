<?php

namespace App\Exports;

use App\Models\{ScientificSession, Conference, Hall, User};
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Carbon\Carbon;

class ScientificSessionExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    public $sessions;

    public function __construct()
    {
        $this->sessions = ScientificSession::where('status', 1)->orderBy('day', 'ASC')->orderBy('time', 'ASC')->get();
    }

    public function collection()
    {
        $arrayData = [];
        foreach ($this->sessions as $key => $value) {
            // for day start
            $latestConference = Conference::latestConference();
            $startDate = Carbon::parse($latestConference->start_date);
            $endDate = Carbon::parse($latestConference->end_date);
            $dates = [];
            while ($startDate->lte($endDate)) {
                $dates[] = $startDate->toDateString();
                $startDate->addDay();
            }
            foreach ($dates as $k => $date) {
                if ($value->day == $date) {
                    $day = 'Day ' . $k + 1;
                }
            }
            // for day end

            // for type start
            if ($value->type == 1) {
                $type = 'Paper Presentation';
            } else if ($value->type == 2) {
                $type = 'Poster Presentation';
            } else if ($value->type == 3) {
                $type = 'Panel Discussion';
            } else if ($value->type == 4) {
                $type = 'Debate';
            } else if ($value->type == 5) {
                $type = 'General Activity';
            } else if ($value->type == 6) {
                $type = 'None';
            }
            // for type end

            // for topic start
            $topic = '-';
            if (!empty($value->topic)) {
                $topic = $value->topic;
            }
            // for topic end

            // for hall start
            $hallName = '-';
            if (!empty($value->hall_id)) {
                $hallNameArray = [];
                $extractHallId = json_decode($value->hall_id);
                $halls = Hall::whereIn('id', $extractHallId)->get();
                foreach ($halls as $hallKey => $hall) {
                    $hallNameArray[] =  $hall->hall_name;
                }
                $hallName = implode(', ', $hallNameArray);
            }
            // for hall end

            // for chairperson start
            $chairPerson = '-';
            if (!empty($value->chairperson)) {
                $chairPersonArray = [];
                $extractChairPersonId = json_decode($value->chairperson);
                $chairPersons = User::whereIn('id', $extractChairPersonId)->get();
                foreach ($chairPersons as $cpv) {
                    $chairPersonArray[] =  $cpv->fullName($cpv);
                }
                $chairPerson = implode(', ', $chairPersonArray);
            }
            // for chairperson end

            // for co-chairperson start
            $coChairPerson = '-';
            if (!empty($value->co_chairperson)) {
                $coChairPersonArray = [];
                $extractCoChairPersonId = json_decode($value->co_chairperson);
                $coChairPersons = User::whereIn('id', $extractCoChairPersonId)->get();
                foreach ($coChairPersons as $copv) {
                    $coChairPersonArray[] =  $copv->fullName($copv);
                }
                $coChairPerson = implode(', ', $coChairPersonArray);
            }
            // for co-chairperson end

            // for participants start
            $participant = '-';
            if (!empty($value->participants)) {
                $participantsArray = [];
                $extractParticipantId = json_decode($value->participants);
                $participants = User::whereIn('id', $extractParticipantId)->get();
                foreach ($participants as $pv) {
                    $participantsArray[] =  $pv->fullName($pv);
                }
                $participant = implode(', ', $participantsArray);
            }
            // for participants end

            $arrayData[] = [
                'S.No.' => $key + 1,
                'Day' => $day,
                'Time' => $value->time,
                'Duration' => $value->duration,
                'Category' => $value->category->category_name,
                'Type' => $type,
                'Topic' => $topic,
                'Hall' => $hallName,
                'Chairperson' => $chairPerson,
                'Co-Ordinator' => $coChairPerson,
                'Participants' => $participant,
            ];
        }
        return collect($arrayData);
    }

    public function headings(): array
    {
        return ["S.No.", "Day", "Time", "Duration", "Category", "Type", "Topic", "Hall", "Chairperson/Moderator", "Co-Ordinator", "Participants/Panlists/Opponents"];
    }
}
