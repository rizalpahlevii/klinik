<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

use App\Http\Requests\Shifts\ShiftCashTransfer;
use App\Http\Requests\Shifts\TransferCashRequest;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\Services\FamilyPlanning;
use App\Models\Services\General;
use App\Models\Services\Laboratory;
use App\Models\Services\Pregnancy;
use App\Models\Setting;

use App\Queries\ProductDataTable;

use App\Repositories\ChartRepository;
use App\Repositories\DashboardRepository;
use App\Repositories\ProductRepository;
use App\Repositories\StockAdjusmentRepository;

use DB;
use Flash;

class HomeController extends AppBaseController
{
    private $dashboardRepository;
    private $chartRepository;
    private $productRepository;
    private $stockAdjusmentRepository;
    /**
     * Create a new controller instance.
     *
     * @param  DashboardRepository  $dashboardRepository
     */
    public function __construct(
        DashboardRepository $dashboardRepository,
        ChartRepository $chartRepository,
        ProductRepository $productRepository,
        StockAdjusmentRepository $stockAdjusmentRepository

    ) {
        $this->middleware('auth');
        $this->stockAdjusmentRepository = $stockAdjusmentRepository;
        $this->productRepository = $productRepository;
        $this->chartRepository = $chartRepository;
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
        $data['currency'] = Setting::CURRENCIES; // Multi currency tidak diperlukan, bisa dihapus

        /*
            Pengelompokan action seharusnya tidak berdasarkan page
            tapi berdasarkan objek data yang dipakai.
            Misal untuk shift, sebaiknya dibuat ShiftRepository
        */
        $shift = $this->dashboardRepository->getShift();
        $previousShift = $this->dashboardRepository->previousShift();
        $totalSales = $this->dashboardRepository->getShiftSalesTotal();
        $finalCash = $this->dashboardRepository->getFinalCash();
        $highProducts = $this->dashboardRepository->getHighProduct();
        $stockAdjusments = $this->dashboardRepository->stockAdjusments();
        $products = (new ProductDataTable())->get()->get();

        return view('dashboard.index', compact([
            'products',
            'highProducts',
            'stockAdjusments',
            'data',
            'shift',
            'previousShift',
            'totalSales',
            'finalCash'
        ]));
    }

    public function transfer(TransferCashRequest $request)
    {
        $input = $request->collectTransferData();
        $transfer = $this->dashboardRepository->transferCash($input);
        session()->flash('success', 'Berhasil menyetorkan uang sejumlah ' . $transfer->amount);

        return redirect()->back();
    }

    public function stockAdjusment(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'note' => 'nullable|min:3',
            'quantity' => 'numeric'
        ]);
        DB::beginTransaction();
        try {
            $this->stockAdjusmentRepository->create($request->except('_token'));
            DB::commit();
            Flash::success("Berhasil menambahkan stok penyesuaian produk");
        } catch (\Exception $e) {
            DB::rollBack();
            Flash::error($e->getMessage());
        }
        return redirect()->back();
    }
    public function stockAdjusmentUpdate(Request $request, $id)
    {
        $request->validate([
            'product_id_edit' => 'required',
            'note_edit' => 'nullable|min:3',
            'quantity_edit' => 'numeric'
        ]);
        DB::beginTransaction();
        try {
            $this->stockAdjusmentRepository->update($request->except('_token'), $id);
            DB::commit();
            Flash::success("Berhasil menambahkan stok penyesuaian produk");
        } catch (\Exception $e) {
            DB::rollBack();
            Flash::error($e->getMessage());
        }
        return redirect()->back();
    }
    public function stockAdjusmentDelete($id)
    {
        DB::beginTransaction();
        try {
            $this->stockAdjusmentRepository->destroy($id);
            DB::commit();
            Flash::success("Berhasil menghapus stok penyesuaian produk");
        } catch (\Exception $e) {
            DB::rollBack();
            Flash::error($e->getMessage());
        }
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

    /*
        Ganti nama function ini dengan toggleShift
    */
    public function startShift(Request $request)
    {
        $shift = $this->dashboardRepository->getShift();

        /*
            Rapikan if else berikut menjadi GATE principal
        */
        if ($shift) {
            $this->dashboardRepository->endShift();
            Flash::success("Berhasil Mengakhiri Shift");
            return $this->sendSuccess("Berhasil mengakhiri shift");
        } else {
            $response = $this->dashboardRepository->startShift();
            if ($response['status'] == 'success') {
                Flash::success($response['message']);
                return $this->sendSuccess($response['message']);
            } else {
                Flash::error($response['message']);
                return $this->sendSuccess($response['message']);
            }
        }
    }

    public function getChart()
    {
        $response = $this->chartRepository->getChart();
        return response()->json($response);
    }

    public function report()
    {
        $querySale = Sale::whereMonth('receipt_date', '>=', request()->get('month-start'))
            ->whereYear('receipt_date', '>=', request()->get('year-start'))
            ->whereMonth('receipt_date', '<=', request()->get('month-end'))
            ->whereYear('receipt_date', '<=', request()->get('year-end'));
        $saleSum = $querySale->sum('grand_total');
        $sale = $querySale->get();

        $queryGeneralService = General::whereMonth('registration_time', '>=', request()->get('month-start'))
            ->whereYear('registration_time', '>=', request()->get('year-start'))
            ->whereMonth('registration_time', '<=', request()->get('month-end'))
            ->whereYear('registration_time', '<=', request()->get('year-end'));
        $generalServiceSum = $queryGeneralService->sum('total_fee');
        $generalService = $queryGeneralService->get();

        $queryLaboratoryService = Laboratory::whereMonth('registration_time', '>=', request()->get('month-start'))
            ->whereYear('registration_time', '>=', request()->get('year-start'))
            ->whereMonth('registration_time', '<=', request()->get('month-end'))
            ->whereYear('registration_time', '<=', request()->get('year-end'));
        $laboratoryServiceSum = $queryLaboratoryService->sum('total_fee');
        $laboratoryService = $queryLaboratoryService->get();


        $queryPregnancyService = Pregnancy::whereMonth('registration_time', '>=', request()->get('month-start'))
            ->whereYear('registration_time', '>=', request()->get('year-start'))
            ->whereMonth('registration_time', '<=', request()->get('month-end'))
            ->whereYear('registration_time', '<=', request()->get('year-end'));
        $pregnancyServiceSum = $queryPregnancyService->sum('total_fee');
        $pregnancyService = $queryPregnancyService->get();


        $queryFamilyPlanningService = FamilyPlanning::whereMonth('registration_time', '>=', request()->get('month-start'))
            ->whereYear('registration_time', '>=', request()->get('year-start'))
            ->whereMonth('registration_time', '<=', request()->get('month-end'))
            ->whereYear('registration_time', '<=', request()->get('year-end'));
        $familyPlanningServiceSum = $queryFamilyPlanningService->sum('total_fee');
        $familyPlanningService = $queryFamilyPlanningService->get();

        $queryPurchase = Purchase::with('supplier')->whereMonth('receipt_date', '>=', request()->get('month-start'))
            ->whereYear('receipt_date', '>=', request()->get('year-start'))
            ->whereMonth('receipt_date', '<=', request()->get('month-end'))
            ->whereYear('receipt_date', '<=', request()->get('year-end'));
        $purchaseSum = $queryPurchase->sum('grand_total');
        $purchase = $queryPurchase->get();
        return view('report', compact(
            'sale',
            'saleSum',
            'purchase',
            'purchaseSum',
            'familyPlanningService',
            'familyPlanningServiceSum',
            'pregnancyService',
            'pregnancyServiceSum',
            'laboratoryService',
            'laboratoryServiceSum',
            'generalService',
            'generalServiceSum'
        ));
    }
}
