<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CourseCertificateMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $studentName,
        public string $courseTitle,
        public ?string $customMessage,
        public string $attachmentPath,
        public string $attachmentName,
    ) {}

    public function build()
    {
        return $this->subject("Your Certificate — {$this->courseTitle}")
            ->view('emails.course-certificate')
            ->attach($this->attachmentPath, [
                'as' => $this->attachmentName,
                'mime' => 'application/pdf',
            ]);
    }
}
