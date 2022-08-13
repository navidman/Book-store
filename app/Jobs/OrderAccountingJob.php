<?php

namespace App\Jobs;

use App\Models\Accounting;
use App\Models\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class OrderAccountingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $userId, $amount;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($userId, $amount)
    {
        $this->userId = $userId;
        $this->amount = $amount;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $accounting = Accounting::whereUserId($this->userId)->first();
            if ($accounting) {
                $accounting->update(['to_pay' => $accounting->amount + $this->amount * 0.2]);
            }
            if (!$accounting) {
                Accounting::Create(['user_id' => $this->userId, 'to_pay' => $this->amount * 0.2]);
            }
        } catch (\Throwable $throwable) {
            report($throwable);
        }
    }
}
