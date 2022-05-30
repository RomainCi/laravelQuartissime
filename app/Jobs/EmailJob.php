<?php

namespace App\Jobs;

use App\Mail\VerifEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class EmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $token;
    protected $user;
    protected $userRiverain;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($token, $user, $userRiverain)
    {
        //
        $this->token = $token;
        $this->user = $user;
        $this->userRiverain = $userRiverain;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        Mail::to($this->user['email'])->send(new VerifEmail($this->token, $this->user, $this->userRiverain));
    }
}
