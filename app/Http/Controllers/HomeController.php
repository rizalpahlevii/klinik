<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Repositories\DashboardRepository;
use DB;
use Flash;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends AppBaseController
{
    private $dashboardRepository;

    /**
     * Create a new controller instance.
     *
     * @param  DashboardRepository  $dashboardRepository
     */
    public function __construct(DashboardRepository $dashboardRepository)
    {
        $this->middleware('auth');
        $this->dashboardRepository = $dashboardRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return Factory|View
     */
    public function index()
    {
        return view('home');
    }

    /**
     * @return Factory|View
     */
    public function dashboard()
    {
        $data['currency'] = Setting::CURRENCIES;
        $shift = $this->dashboardRepository->getShift();
        $previousShift = $this->dashboardRepository->previousShift();
        $totalSales = $this->dashboardRepository->getShiftSalesTotal();
        $finalCash = $this->dashboardRepository->getFinalCash();
        return view('dashboard.index', compact('data', 'shift', 'previousShift', 'totalSales', 'finalCash'));
    }

    public function transfer(Request $request)
    {
        $request->validate([
            'transfer_proof' => 'nullable|mimes:pdf,jpg,jpeg,png|max:5000'
        ]);
        if ($request->transfer_proof) {
            $file = $request->file('transfer_proof');
            $fileName = time() . "_" . $file->getClientOriginalName();
            $file->move('upload/transfer-proof', $fileName);
        } else {
            $fileName = null;
        }
        $this->dashboardRepository->transferCash(convertCurrency($request->amount), $fileName);
        Flash::success("Berhasil menyetorkan uang sejumlah ." . convertCurrency($request->amount));
        return redirect()->back();
    }

    public function cashAdd(Request $request)
    {
        DB::beginTransaction();
        try {
            $repo = $this->dashboardRepository->addInitialCash(convertCurrency($request->cash_add));
            if ($repo != false) {
                Flash::success("Berhasil menambah kas awal");
            } else {
                Flash::success("Gagal menambah kas awal");
            }
            DB::commit();
        } catch (\Exception $th) {
            Flash::error($th->getMessage());
            DB::rollBack();
        }
        return redirect()->back();
    }

    public function startShift(Request $request)
    {
        $shift = $this->dashboardRepository->getShift();
        if ($shift) {
            $this->dashboardRepository->endShift();
            Flash::success("Berhasil Mengakhiri Shift");
            return $this->sendSuccess("Berhasil mengakhiri shift");
        } else {
            $response = $this->dashboardRepository->startShift();
            if ($response['success']) {
                Flash::success($response['message']);
                return $this->sendSuccess($response['message']);
            } else {
                Flash::error($response['message']);
                return $this->sendSuccess($response['message']);
            }
        }
    }
}
