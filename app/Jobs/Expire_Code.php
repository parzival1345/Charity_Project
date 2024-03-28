<?php

namespace App\Jobs;

use App\Models\Save_code;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class Expire_Code implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach (Save_code::all() as $Save_code) {
            if (now() >= $Save_code->expire_at) {
                $Save_code->delete();
            }
        }
    }
}
