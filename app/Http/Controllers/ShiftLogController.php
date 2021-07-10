<?php

namespace App\Http\Controllers;

use App\Models\CashierShift;
use Illuminate\Http\Request;

class ShiftLogController extends Controller
{
    public function index()
    {
        $shifts = CashierShift::with('cashier')->orderBy('created_at', 'DESC')->get();
        return view('shift-logs.index', compact('shifts'));
    }
}
