<?php

namespace App\Jobs;

use App\Models\Accounting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PaymentAccountingJob implements ShouldQueue
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
                $accounting->update(['to_pay' => $accounting->to_pay - $this->amount]);
            }
        } catch (\Throwable $throwable) {
            report($throwable);
        }
    }
}
