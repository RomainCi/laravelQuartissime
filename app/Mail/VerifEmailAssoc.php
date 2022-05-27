<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifEmailAssoc extends Mailable
{
    use Queueable, SerializesModels;
    public $token = "";
    public $nomAssoc = "";
    public $email = "";
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token, $nomAssoc, $email)
    {
        $this->token = $token;
        $this->nomAssoc = $nomAssoc;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('no-reply@quartissime-nice.fr')
            ->subject('verification')
            ->view('emails.verifAssoc');
    }
}
