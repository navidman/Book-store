<?php

namespace App\Jobs;

use App\Models\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class LogJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $userId, $api;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($userId, $api)
    {
        $this->userId = $userId;
        $this->api = $api;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            Request::create(['user_id' => $this->userId, 'api' => $this->api]);
        } catch (\Throwable $throwable) {
            report($throwable);
        }
    }
}
