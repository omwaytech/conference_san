<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use DomPDF, Mail;

class SendSerialNumber implements ShouldQueue
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
                'name' => $participant->user->fullname($participant, 'user'),
                'registrationId' => $participant->registration_id
            ];

            Mail::send('emails.conference.serial-number', ['data' => $mailData], function ($message) use ($participant) {
                $message->to($participant->user->email)
                    ->subject('Important Information Regarding Your Registration for SANCON-ASPA 2025');
            });
    }
}
