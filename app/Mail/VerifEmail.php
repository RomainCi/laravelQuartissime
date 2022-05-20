<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $token = "";
    public $user = [];
    public $userRiverain = [];
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token, $user, $userRiverain)
    {
        $this->token = $token;
        $this->user = $user;
        $this->userRiverain = $userRiverain;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->userRiverain != []) {

            return $this->from('no-reply@quartissime-nice.fr')
                ->subject('verification')
                ->view('emails.infoRiverain');
        } else {
            return $this->from('no-reply@quartissime-nice.fr')
                ->subject('ne pas repondre')
                ->view('emails.verifEmail');
        }
    }
}
