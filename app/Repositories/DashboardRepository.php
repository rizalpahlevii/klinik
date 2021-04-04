<?php

namespace App\Repositories;

use App\Models\CashierShift;
use App\Models\Sale;
use App\Models\Services\FamilyPlanning;
use App\Models\Services\General;
use App\Models\Services\Laboratory;
use App\Models\Services\Pregnancy;
use App\Models\ShiftCashTransfer;
use App\Models\ShiftCassAdd;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Laravel\Cashier\Cashier;

/**
 * Class DashboardRepository
 */
class DashboardRepository
{

    public function getSalesTotal()
    {
        if ($this->getShift()) {
            $sales = Sale::where('created_at', '>=', $this->getShift()->start_shift)->where('created_at', '<=', Carbon::now())->sum('grand_total');
            return $sales ?? 0;
        } else {
            return 0;
        }
    }

    public function getServicesTotal()
    {
        $general = General::where('created_at', '>=', $this->getShift() != null ? $this->getShift()->start_shift : now())->where('created_at', '<=', Carbon::now())->sum('total_fee');
        $pregnancy = Pregnancy::where('created_at', '>=', $this->getShift() != null ? $this->getShift()->start_shift : now())->where('created_at', '<=', Carbon::now())->sum('total_fee');
        $familyPlanning = FamilyPlanning::where('created_at', '>=', $this->getShift() != null ? $this->getShift()->start_shift : now())->where('created_at', '<=', Carbon::now())->sum('total_fee');
        $laboratory = Laboratory::where('created_at', '>=', $this->getShift() != null ? $this->getShift()->start_shift : now())->where('created_at', '<=', Carbon::now())->sum('total_fee');
        return $general ?? 0 + $pregnancy ?? 0 + $familyPlanning ?? 0 + $laboratory ?? 0;
    }

    public function getShiftSalesTotal()
    {
        return $this->getSalesTotal() + $this->getServicesTotal();
    }

    public function getFinalCash()
    {
        if ($this->getShift()) {
            return ($this->getShiftSalesTotal() + $this->getShift()->initial_cash) - $this->getTransferCash();
        } else {
            return 0;
        }
    }

    public function previousShift()
    {
        $shift = CashierShift::with('cashier')->whereNotNull('end_shift')->orderBy('created_at', 'DESC')->first();
        return $shift;
    }

    public function getShift()
    {
        $shift = CashierShift::with('cashier')->where('cashier_id', auth()->id())->where('end_shift', NULL)->first();
        return $shift;
    }

    public function startShift()
    {
        $checkShift = CashierShift::whereNull('end_shift')->get()->count();
        if ($checkShift == 0) {
            $shift = new CashierShift();
            $shift->cashier_id = auth()->id();
            $shift->start_shift = now();
            if ($this->previousShift()) {
                $shift->initial_cash = $this->previousShift()->final_cash;
            } else {
                $shift->initial_cash = 0;
            }
            $shift->save();
            return $shift;
        } else {
            return false;
        }
    }

    public function endShift()
    {
        $shift = CashierShift::where('cashier_id', auth()->id())->whereNull('end_shift')->first();
        $shift->shift_sales_total = $this->getSalesTotal();
        $shift->final_cash = $this->getFinalCash();
        $shift->end_shift = now();
        $shift->save();
    }

    public function addInitialCash($amount)
    {

        $initial = new ShiftCassAdd();
        $initial->cashier_id = auth()->id();
        if ($this->getShift()) {
            $initial->cashier_shift_id = $this->getShift()->id;
        } else {
            if ($this->previousShift()) {
                $initial->cashier_shift_id = $this->previousShift()->id;
            } else {
                return false;
            }
        }
        $initial->total_add = $amount;
        $update = CashierShift::find($initial->cashier_shift_id);
        $update->initial_cash += $amount;
        $update->save();
        return $initial->save();
    }

    public function getTransferCash()
    {
        $shift = $this->getShift();
        $transfer = ShiftCashTransfer::where('cashier_id', auth()->id())->where('cashier_shift_id', $shift->id)->sum('total_transfer');
        return $transfer ?? 0;
    }

    public function transferCash($amount, $transferProof = null)
    {
        $transfer = new ShiftCashTransfer();
        $transfer->cashier_id = auth()->id();
        $transfer->cashier_shift_id = $this->getShift()->id;
        $transfer->total_transfer = $amount;
        $transfer->transfer_proof = $transferProof;
        $transfer->save();
    }

    public function getUserById($user_id)
    {
        return User::find($user_id);
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
