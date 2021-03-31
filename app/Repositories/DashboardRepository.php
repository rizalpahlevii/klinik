<?php

namespace App\Repositories;

use App\Models\Cash;
use App\Models\Shift;
use App\Models\User;
use Carbon\Carbon;
use Exception;

/**
 * Class DashboardRepository
 */
class DashboardRepository
{
    public function endShift()
    {
        $shift = Shift::where('user_id', auth()->id())->where('status', 'active')->first();
        $shift->status = 'ended';
        $shift->end_shift = now();
        $shift->save();
        $this->createCash($shift->cash_now);
    }
    public function startShift()
    {
        $previousShift = $this->previousShift();
        if ($previousShift) {
            $previousShiftname = $this->getUserById($previousShift->user_id)->fullname;
            $previousShiftEnd = $previousShift->end_shift;
        } else {
            $previousShiftname = '-';
            $previousShiftEnd = NULL;
        }
        $shift = new Shift();
        $shift->user_id = auth()->id();
        $shift->previous_cashier_name = $previousShiftname;
        $shift->status  = 'active';
        $shift->start_shift = now();
        $shift->previous_end_shift = $previousShiftEnd;
        $shift->initial_cash = 0;
        $shift->total_sales = 0;
        $shift->cash_now = 0;
        $shift->save();
    }
    public function getShift()
    {
        $shift = Shift::with('user')->where('user_id', auth()->id())->orderBy('id', 'DESC')->where('status', 'active')->first();
        return $shift;
    }

    public function createCash($amount)
    {
        $cash = new Cash();
        $cash->amount = $amount;
        $cash->user_id = auth()->id();
        $cash->save();
    }

    public function getUserById($user_id)
    {
        return User::find($user_id);
    }

    public function previousShift()
    {
        return Shift::orderBy('id', 'DESC')->where('status', 'ended')->first();
    }

    /**
     * @param  string  $startDate
     * @param  string  $endDate
     *
     * @throws Exception
     * @return array
     */
    public function getDate($startDate, $endDate)
    {
        $dateArr = [];
        $subStartDate = '';
        $subEndDate = '';
        if (!($startDate && $endDate)) {
            $data = [
                'dateArr'   => $dateArr,
                'startDate' => $subStartDate,
                'endDate'   => $subEndDate,
            ];

            return $data;
        }
        $end = trim(substr($endDate, 0, 10));
        $start = Carbon::parse($startDate)->toDateString();
        /** @var \Illuminate\Support\Carbon $startDate */
        $startDate = Carbon::createFromFormat('Y-m-d', $start);
        /** @var \Illuminate\Support\Carbon $endDate */
        $endDate = Carbon::createFromFormat('Y-m-d', $end);

        while ($startDate <= $endDate) {
            $dateArr[] = $startDate->copy()->format('Y-m-d');
            $startDate->addDay();
        }
        $start = current($dateArr);
        $endDate = end($dateArr);
        $subStartDate = Carbon::parse($start)->startOfDay()->format('Y-m-d H:i:s');
        $subEndDate = Carbon::parse($endDate)->endOfDay()->format('Y-m-d H:i:s');

        $data = [
            'dateArr'   => $dateArr,
            'startDate' => $subStartDate,
            'endDate'   => $subEndDate,
        ];

        return $data;
    }
}
