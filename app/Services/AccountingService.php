<?php

namespace App\Services;

use App\Models\Accounting;
use App\Models\Book;

class AccountingService
{
    public function getAccounting()
    {
        $accountings = Accounting::all();
        return $accountings;
    }
}
