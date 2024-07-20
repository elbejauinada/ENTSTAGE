<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\User;

class ActivationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $activationLink;

    public function __construct(User $user, $activationLink)
    {
        $this->user = $user;
        $this->activationLink = $activationLink;
    }

    public function build()
    {
        return $this->markdown('emails.activation')
                    ->with([
                        'user' => $this->user,
                        'activationLink' => $this->activationLink,
                    ]);
    }
}
