<?php

namespace App\Jobs;

use App\Mail\WorkshopAttendeeBulkMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\{Presenter, Attendee, User};
use Mail;

class WorkshopAttendeeBulkJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $attendees;
    public $data;

    /**
     * Create a new job instance.
     */
    public function __construct($attendees, $data)
    {
        foreach ($attendees as $value) {
            if ($value->type == "Presenter") {
                $attendee = Presenter::where('registeration_id', $value->registered_id)->first();
                $name = $attendee->presenter->name;
                $email = $attendee->presenter->email;
            } elseif ($value->type == "Attendee") {
                $attendee = Attendee::where('registeration_id', $value->registered_id)->first();
                $name = $attendee->name;
                $email = $attendee->email;
            } elseif ($value->type == "Without-Conference") {
                $attendee = User::where('id', $value->registered_id)->first();
                $name = $attendee->name;
                $email = $attendee->email;
            }
            $attendeesArray[] = [
                'name' => $name,
                'email' => $email,
            ];
        }
        $this->attendees = $attendeesArray;
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->attendees as $index => $attendee) {
            $delayInSeconds = $index * 30;
            Mail::to($attendee['email'])->later(now()->addSeconds($delayInSeconds), new WorkshopAttendeeBulkMail($attendee, $this->data));
        }
    }
}
