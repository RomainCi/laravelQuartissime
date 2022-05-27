<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InfoAssocEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $userAssoc = [];
    public $chemin = [];
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($userAssoc, $chemin)
    {
        $this->userAssoc = $userAssoc;
        $this->chemin = $chemin;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->from('no-reply@quartissime-nice.fr')
            ->subject('infoAssoc')
            ->view('emails.infoAssoc');
        foreach ($this->chemin as $filePath) {
            $email->attach($filePath->pathPhoto);
        }

        return $email;
    }
}
