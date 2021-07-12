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
use App\Models\Services\Administration;
use App\Models\Services\Electrocardiogram;
use App\Models\Services\FamilyPlanning;
use App\Models\Services\General;
use App\Models\Services\Immunization;
use App\Models\Services\Inpatient;
use App\Models\Services\Laboratory;
use App\Models\Services\Parturition;
use App\Models\Services\Pregnancy;
use App\Models\Setting;
use App\Models\Spending;
use App\Models\StockAdjusment;
use App\Queries\ProductDataTable;

use App\Repositories\ChartRepository;
use App\Repositories\DashboardRepository;
use App\Repositories\ProductRepository;
use App\Repositories\StockAdjusmentRepository;
use Auth;
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
        $spending = $this->dashboardRepository->getSpending();
        $stockAdjusments = $this->dashboardRepository->stockAdjusments();
        $products = (new ProductDataTable())->get()->get();
        $cashAdd = $this->dashboardRepository->getCashAdd();
        return view('dashboard.index', compact([
            'spending',
            'products',
            'highProducts',
            'stockAdjusments',
            'data',
            'shift',
            'previousShift',
            'totalSales',
            'finalCash',
            'cashAdd'
        ]));
    }

    public function transfer(TransferCashRequest $request)
    {
        $input = $request->collectInput();
        if ($input['amount'] > $this->dashboardRepository->getFinalCash()) {
            Flash::error("Nominal Setor Melebihi Kas Sekarang");
            return redirect()->back();
        }
        $transfer = $this->dashboardRepository->transferCash($input);
        Flash::success('Berhasil menyetorkan uang sejumlah ' . $transfer->total_transfer);

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

    public function getServiceChart()
    {
        return response()->json($this->chartRepository->getServiceChart());
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

        $queryimmunizationService = Immunization::whereMonth('registration_time', '>=', request()->get('month-start'))
            ->whereYear('registration_time', '>=', request()->get('year-start'))
            ->whereMonth('registration_time', '<=', request()->get('month-end'))
            ->whereYear('registration_time', '<=', request()->get('year-end'));
        $immunizationServiceSum = $queryimmunizationService->sum('total_fee');
        $immunizationService = $queryimmunizationService->get();

        $queryinpatientService = Inpatient::whereMonth('registration_time', '>=', request()->get('month-start'))
            ->whereYear('registration_time', '>=', request()->get('year-start'))
            ->whereMonth('registration_time', '<=', request()->get('month-end'))
            ->whereYear('registration_time', '<=', request()->get('year-end'));
        $inpatientServiceSum = $queryinpatientService->sum('total_fee');
        $inpatientService = $queryinpatientService->get();

        $queryparturitionService = Parturition::whereMonth('registration_time', '>=', request()->get('month-start'))
            ->whereYear('registration_time', '>=', request()->get('year-start'))
            ->whereMonth('registration_time', '<=', request()->get('month-end'))
            ->whereYear('registration_time', '<=', request()->get('year-end'));
        $parturitionServiceSum = $queryparturitionService->sum('total_fee');
        $parturitionService = $queryparturitionService->get();

        $queryekgService = Electrocardiogram::whereMonth('registration_time', '>=', request()->get('month-start'))
            ->whereYear('registration_time', '>=', request()->get('year-start'))
            ->whereMonth('registration_time', '<=', request()->get('month-end'))
            ->whereYear('registration_time', '<=', request()->get('year-end'));
        $ekgServiceSum = $queryekgService->sum('total_fee');
        $ekgService = $queryekgService->get();

        $queryadministrationService = Administration::whereMonth('registration_time', '>=', request()->get('month-start'))
            ->whereYear('registration_time', '>=', request()->get('year-start'))
            ->whereMonth('registration_time', '<=', request()->get('month-end'))
            ->whereYear('registration_time', '<=', request()->get('year-end'));
        $administrationServiceSum = $queryadministrationService->sum('total_fee');
        $administrationService = $queryadministrationService->get();

        $queryPurchase = Purchase::with('supplier')->whereMonth('receipt_date', '>=', request()->get('month-start'))
            ->whereYear('receipt_date', '>=', request()->get('year-start'))
            ->whereMonth('receipt_date', '<=', request()->get('month-end'))
            ->whereYear('receipt_date', '<=', request()->get('year-end'));
        $purchaseSum = $queryPurchase->sum('grand_total');
        $purchase = $queryPurchase->get();

        $querySpending = Spending::with('shift.cashier')->whereMonth('created_at', '>=', request()->get('month-start'))
            ->whereYear('created_at', '>=', request()->get('year-start'))
            ->whereMonth('created_at', '<=', request()->get('month-end'))
            ->whereYear('created_at', '<=', request()->get('year-end'));
        $spendingSum = $querySpending->sum('amount');
        $spending = $querySpending->get();

        $stockAdjusment = StockAdjusment::with('product')->whereMonth('created_at', '>=', request()->get('month-start'))
            ->whereYear('created_at', '>=', request()->get('year-start'))
            ->whereMonth('created_at', '<=', request()->get('month-end'))
            ->whereYear('created_at', '<=', request()->get('year-end'))->get();
        $stockAdjusmentSum = 0;
        foreach ($stockAdjusment as $row) {
            $stockAdjusmentSum += $row->quantity * $row->product->selling_price;
        }

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
            'generalServiceSum',
            'inpatientService',
            'inpatientServiceSum',
            'immunizationService',
            'immunizationServiceSum',
            'parturitionService',
            'parturitionServiceSum',
            'ekgService',
            'ekgServiceSum',
            'administrationService',
            'administrationServiceSum',
            'spending',
            'spendingSum',
            'stockAdjusment',
            'stockAdjusmentSum'
        ));
    }
}
