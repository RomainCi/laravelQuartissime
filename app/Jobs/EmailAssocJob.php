<?php

namespace App\Jobs;

use App\Mail\VerifEmailAssoc;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class EmailAssocJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $token;
    protected $nomAssoc;
    protected $email;
    /**
     * Create a new job instance.
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
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        Mail::to($this->email)->send(new VerifEmailAssoc($this->token, $this->nomAssoc, $this->email));
    }
}
