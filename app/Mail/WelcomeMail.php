<?php
namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $password;

    public function __construct(User $user, string $password)
    {
        $this->email = $user->email;
        $this->password = $password;
    }

    public function build()
    {
        return $this->view('emails.welcome');
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Ваші дані для входу',
        );
    }
}

