<?php

namespace App\Jobs;

use App\Mail\PassMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailer;

class SendPassEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public $filePath;
    public $email;
    public function __construct($filePath, $email)
    {
        $this->filePath = $filePath;
        $this->email = $email;
    }

    /**
     * Execute the job.
     */
    public function handle(Mailer $mailer)
    {
        $mailer->to($this->email)->send(new PassMail($this->filePath));
    }
}
