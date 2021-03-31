<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Repositories\DashboardRepository;
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

        $shift = $this->dashboardRepository->getShift();
        $data['currency'] = Setting::CURRENCIES;
        return view('dashboard.index', compact('data', 'shift'));
    }

    public function startShift(Request $request)
    {
        $shift = $this->dashboardRepository->getShift();
        if ($shift) {
            $this->dashboardRepository->endShift();
            return $this->sendSuccess("Berhasil mengakhiri shift");
        } else {
            $this->dashboardRepository->startShift();
            return $this->sendSuccess("Berhasil memulai shift");
        }
    }
}
