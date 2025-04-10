<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
Use Mail;
class SendWorkshopCertificateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $participant;
    /**
     * Create a new job instance.
     */
    public function __construct($participant)
    {
        $this->participant = $participant;
    }


    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $participant = $this->participant;

        $mailData = [
            'id' => $participant->id,
            'name' => $participant->user->fullname($participant, 'user'),
            // 'registrationId' => $participant->registration_id,
            // 'namePrefix' => $participant->user->namePrefix->prefix,
            'token' => $participant->token,
            // 'memberType' => $participant->user->userDetail->member_type_id,
            // 'country' => $participant->user->userDetail->country->country_name,
            // 'registrant_type' => $participant->registrant_type
        ];

        Mail::send('emails.conference.send-workshop-certificate', ['data' => $mailData], function ($message) use ($participant) {
            $message->to($participant->user->email)
                ->subject('SANCON ASPA 2025 Workshop Certificate');
        });
    }
}
