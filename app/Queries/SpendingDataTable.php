<?php


namespace App\Queries;

use App\Models\CashierShift;
use App\Models\Spending;
use Auth;

class SpendingDataTable
{
    public function get()
    {
        $spending = Spending::whereNotNull('id');
        if (Auth::user()->hasRole('cashier')) {
            $cashiers = CashierShift::where('cashier_id', Auth::user())->get()->pluck('id')->toArray();
            $spending = $spending->whereIn('shift_cashier_id', $cashiers);
        }
        return $spending->orderBy('created_at', 'desc');
    }
}
