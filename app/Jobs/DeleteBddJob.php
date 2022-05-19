<?php

namespace App\Jobs;

use App\Mail\VerifEmail;
use Illuminate\Bus\Queueable;
use App\Models\VerifEmailRiverain;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class DeleteBddJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */

    protected $id = [];

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id)
    {

        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //supression bdd 


        $user = VerifEmailRiverain::findOrfail($this->id);
        $user->delete();
    }
}
