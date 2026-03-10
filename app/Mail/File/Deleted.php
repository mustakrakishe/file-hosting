<?php

namespace App\Mail\File;

use App\Models\File;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Deleted extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $fileName,
        public string $filePath,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'File is deleted',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'email',
        );
    }
}
