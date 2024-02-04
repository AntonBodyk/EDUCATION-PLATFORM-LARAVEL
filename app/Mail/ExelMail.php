<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ExelMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pathToFile;
    /**
     * Create a new message instance.
     */
    public function __construct($pathToFile)
    {
        $this->pathToFile = $pathToFile;
    }

    public function build()
    {
        if (file_exists($this->pathToFile)) {
            // Прикрепляем файл к письму
            return $this->view('emails.mail_sample')
                ->attach($this->pathToFile, [
                    'as' => 'export.xlsx',
                    'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                ])
                ->subject('Excel Export');
        } else {
            return $this->view('emails.mail_sample')->subject('Excel Export');
        }
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Звіт по данним користувачів',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.mail_sample',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [

        ];

    }
}
