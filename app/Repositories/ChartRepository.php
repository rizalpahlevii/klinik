<?php

namespace App\Repositories;

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
use App\Models\Spending;
use App\Models\StockAdjusment;
use DB;

class ChartRepository
{
    public function getServiceChart()
    {
        return [
            'ekg' => $this->prepareResponse($this->ekgDataForChart()),
            'administration' => $this->prepareResponse($this->administrationDataForChart()),
            'inpatient' => $this->prepareResponse($this->inPatientDataForChart()),
            'laboratory' => $this->prepareResponse($this->getLaboratoryDataForChart()),
            'general' => $this->prepareResponse($this->getGeneralServiceDataForChart()),
            'family_planning' => $this->prepareResponse($this->getLFamilyPlanningDataForChart()),
            'pregnancy' => $this->prepareResponse($this->getPregnancyServiceDataForChart()),
            'immunization' => $this->prepareResponse($this->immunizationDataForChart()),
            'parturition' => $this->prepareResponse($this->parturitionDataForChart()),
        ];
    }

    public function prepareResponse($data)
    {
        $response = [];
        foreach ($data as $row) {
            $response['month'][] = $row['month_name'];
            $response['value'][] = $row['grand_total_sum'];
        }
        return $response;
    }

    public function getChart()
    {
        return [
            'purchase' => $this->prepareResponse($this->getPurchaseDataForChart()),
            'income' => $this->getIncome(),
            'spending' => $this->getSpending(),
            'stock_adjusment' => $this->getStockAdjustment()
        ];
    }

    public function getStockAdjustment()
    {
        $months = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
        $data = [];
        foreach ($months as $key => $month) {
            $adjustments = StockAdjusment::with('product')->whereMonth('created_at', $month)->whereYear('created_at', date('Y'))->get();
            $monthDataTotal = 0;
            foreach ($adjustments as $adjustment) {
                if ($adjustment->product != null) {
                    if ($adjustment->type == "addition") {
                        $monthDataTotal -= ($adjustment->quantity * $adjustment->product->selling_price);
                    } else {
                        $monthDataTotal += ($adjustment->quantity * $adjustment->product->selling_price);
                    }
                }
            }
            $data['month'][] = convertMonthNumber($month);
            $data['value'][] = $monthDataTotal;
        }
        return $data;
    }

    public function getSpending()
    {
        $sales = Spending::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(amount) as grand_total_sum')
        )->groupby('month')->whereYear('created_at', date('Y'))->get()->toArray();
        $salesMonth = array_column($sales, 'month');
        $months = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
        foreach ($months as $month) {
            if (!in_array($month, $salesMonth)) {
                $sales[] = ['month' => $month, 'grand_total_sum' => 0.00];
            }
        }
        $keys = array_column($sales, 'month');
        array_multisort($keys, SORT_ASC, $sales);
        foreach ($sales as $key => $sale) {
            $sales[$key]['month'] = $sale['month'];
            $sales[$key]['month_name'] = convertMonthNumber($sale['month']);
            $sales[$key]['grand_total_sum'] = $sale['grand_total_sum'];
        }
        $data = [];
        foreach ($sales as $row) {
            $data['month'][] = $row['month_name'];
            $data['value'][] = $row['grand_total_sum'];
        }
        return $data;
    }

    public function getIncome()
    {
        $sale = $this->getSalesDataForChart();
        $generalService = $this->getGeneralServiceDataForChart();
        $pregnancy = $this->getPregnancyServiceDataForChart();
        $laboratory = $this->getLaboratoryDataForChart();
        $familyPlanning = $this->getLFamilyPlanningDataForChart();
        $inpatient = $this->inPatientDataForChart();
        $administration = $this->administrationDataForChart();
        $immunization = $this->immunizationDataForChart();
        $parturition = $this->parturitionDataForChart();
        $ekg = $this->ekgDataForChart();
        $newData = [];
        foreach ($sale as $key => $row) {
            $newData[$key]['month'] = $row['month'];
            $newData[$key]['month_name'] = convertMonthNumber($row['month']);
            $newData[$key]['grand_total_sum'] =
                $row['grand_total_sum'] + $generalService[$key]['grand_total_sum'] + $pregnancy[$key]['grand_total_sum'] + $laboratory[$key]['grand_total_sum'] + $familyPlanning[$key]['grand_total_sum'] + $inpatient[$key]['grand_total_sum'] + $administration[$key]['grand_total_sum'] + $ekg[$key]['grand_total_sum'] + $parturition[$key]['grand_total_sum'] + $immunization[$key]['grand_total_sum'];
        }
        $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'Septempber', 'Oktober', 'November', 'Desember'];
        $value = [];
        foreach ($newData as $new) {
            $value[] = $new['grand_total_sum'];
        }
        return [
            'month' => $months,
            'value' => $value
        ];
    }

    public function getPurchaseDataForChart()
    {
        $sales = Purchase::select(
            DB::raw('MONTH(receipt_date) as month'),
            DB::raw('SUM(grand_total) as grand_total_sum')
        )->groupby('month')->whereYear('receipt_date', date('Y'))->get()->toArray();
        $salesMonth = array_column($sales, 'month');
        $months = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
        foreach ($months as $month) {
            if (!in_array($month, $salesMonth)) {
                $sales[] = ['month' => $month, 'grand_total_sum' => 0.00];
            }
        }
        $keys = array_column($sales, 'month');
        array_multisort($keys, SORT_ASC, $sales);
        foreach ($sales as $key => $sale) {
            $sales[$key]['month'] = $sale['month'];
            $sales[$key]['month_name'] = convertMonthNumber($sale['month']);
            $sales[$key]['grand_total_sum'] = $sale['grand_total_sum'];
        }
        return $sales;
    }
    public function getSalesDataForChart()
    {
        $sales = Sale::select(
            DB::raw('MONTH(receipt_date) as month'),
            DB::raw('SUM(grand_total) as grand_total_sum')
        )->groupby('month')->whereYear('receipt_date', date('Y'))->get()->toArray();
        $salesMonth = array_column($sales, 'month');
        $months = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
        foreach ($months as $month) {
            if (!in_array($month, $salesMonth)) {
                $sales[] = ['month' => $month, 'grand_total_sum' => 0.00];
            }
        }
        $keys = array_column($sales, 'month');
        array_multisort($keys, SORT_ASC, $sales);
        foreach ($sales as $key => $sale) {
            $sales[$key]['month'] = $sale['month'];
            $sales[$key]['month_name'] = convertMonthNumber($sale['month']);
            $sales[$key]['grand_total_sum'] = $sale['grand_total_sum'];
        }
        return $sales;
    }

    function getGeneralServiceDataForChart()
    {
        $sales = General::select(
            DB::raw('MONTH(registration_time) as month'),
            DB::raw('SUM(total_fee) as grand_total_sum')
        )->groupby('month')->whereYear('registration_time', date('Y'))->get()->toArray();
        $salesMonth = array_column($sales, 'month');
        $months = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
        foreach ($months as $month) {
            if (!in_array($month, $salesMonth)) {
                $sales[] = ['month' => $month, 'grand_total_sum' => 0.00];
            }
        }
        $keys = array_column($sales, 'month');
        array_multisort($keys, SORT_ASC, $sales);
        foreach ($sales as $key => $sale) {
            $sales[$key]['month'] = $sale['month'];
            $sales[$key]['month_name'] = convertMonthNumber($sale['month']);
            $sales[$key]['grand_total_sum'] = $sale['grand_total_sum'];
        }
        return $sales;
    }

    function getPregnancyServiceDataForChart()
    {
        $sales = Pregnancy::select(
            DB::raw('MONTH(registration_time) as month'),
            DB::raw('SUM(total_fee) as grand_total_sum')
        )->groupby('month')->whereYear('registration_time', date('Y'))->get()->toArray();
        $salesMonth = array_column($sales, 'month');
        $months = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
        foreach ($months as $month) {
            if (!in_array($month, $salesMonth)) {
                $sales[] = ['month' => $month, 'grand_total_sum' => 0.00];
            }
        }
        $keys = array_column($sales, 'month');
        array_multisort($keys, SORT_ASC, $sales);
        foreach ($sales as $key => $sale) {
            $sales[$key]['month'] = $sale['month'];
            $sales[$key]['month_name'] = convertMonthNumber($sale['month']);
            $sales[$key]['grand_total_sum'] = $sale['grand_total_sum'];
        }
        return $sales;
    }
    function getLaboratoryDataForChart()
    {
        $sales = Laboratory::select(
            DB::raw('MONTH(registration_time) as month'),
            DB::raw('SUM(total_fee) as grand_total_sum')
        )->groupby('month')->whereYear('registration_time', date('Y'))->get()->toArray();
        $salesMonth = array_column($sales, 'month');
        $months = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
        foreach ($months as $month) {
            if (!in_array($month, $salesMonth)) {
                $sales[] = ['month' => $month, 'grand_total_sum' => 0.00];
            }
        }
        $keys = array_column($sales, 'month');
        array_multisort($keys, SORT_ASC, $sales);
        foreach ($sales as $key => $sale) {
            $sales[$key]['month'] = $sale['month'];
            $sales[$key]['month_name'] = convertMonthNumber($sale['month']);
            $sales[$key]['grand_total_sum'] = $sale['grand_total_sum'];
        }
        return $sales;
    }
    function getLFamilyPlanningDataForChart()
    {
        $sales = FamilyPlanning::select(
            DB::raw('MONTH(registration_time) as month'),
            DB::raw('SUM(total_fee) as grand_total_sum')
        )->groupby('month')->whereYear('registration_time', date('Y'))->get()->toArray();
        $salesMonth = array_column($sales, 'month');
        $months = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
        foreach ($months as $month) {
            if (!in_array($month, $salesMonth)) {
                $sales[] = ['month' => $month, 'grand_total_sum' => 0.00];
            }
        }
        $keys = array_column($sales, 'month');
        array_multisort($keys, SORT_ASC, $sales);
        foreach ($sales as $key => $sale) {
            $sales[$key]['month'] = $sale['month'];
            $sales[$key]['month_name'] = convertMonthNumber($sale['month']);
            $sales[$key]['grand_total_sum'] = $sale['grand_total_sum'];
        }
        return $sales;
    }
    function inPatientDataForChart()
    {
        $sales = Inpatient::select(
            DB::raw('MONTH(registration_time) as month'),
            DB::raw('SUM(total_fee) as grand_total_sum')
        )->groupby('month')->whereYear('registration_time', date('Y'))->get()->toArray();
        $salesMonth = array_column($sales, 'month');
        $months = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
        foreach ($months as $month) {
            if (!in_array($month, $salesMonth)) {
                $sales[] = ['month' => $month, 'grand_total_sum' => 0.00];
            }
        }
        $keys = array_column($sales, 'month');
        array_multisort($keys, SORT_ASC, $sales);
        foreach ($sales as $key => $sale) {
            $sales[$key]['month'] = $sale['month'];
            $sales[$key]['month_name'] = convertMonthNumber($sale['month']);
            $sales[$key]['grand_total_sum'] = $sale['grand_total_sum'];
        }
        return $sales;
    }
    function immunizationDataForChart()
    {
        $sales = Immunization::select(
            DB::raw('MONTH(registration_time) as month'),
            DB::raw('SUM(total_fee) as grand_total_sum')
        )->groupby('month')->whereYear('registration_time', date('Y'))->get()->toArray();
        $salesMonth = array_column($sales, 'month');
        $months = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
        foreach ($months as $month) {
            if (!in_array($month, $salesMonth)) {
                $sales[] = ['month' => $month, 'grand_total_sum' => 0.00];
            }
        }
        $keys = array_column($sales, 'month');
        array_multisort($keys, SORT_ASC, $sales);
        foreach ($sales as $key => $sale) {
            $sales[$key]['month'] = $sale['month'];
            $sales[$key]['month_name'] = convertMonthNumber($sale['month']);
            $sales[$key]['grand_total_sum'] = $sale['grand_total_sum'];
        }
        return $sales;
    }
    function parturitionDataForChart()
    {
        $sales = Parturition::select(
            DB::raw('MONTH(registration_time) as month'),
            DB::raw('SUM(total_fee) as grand_total_sum')
        )->groupby('month')->whereYear('registration_time', date('Y'))->get()->toArray();
        $salesMonth = array_column($sales, 'month');
        $months = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
        foreach ($months as $month) {
            if (!in_array($month, $salesMonth)) {
                $sales[] = ['month' => $month, 'grand_total_sum' => 0.00];
            }
        }
        $keys = array_column($sales, 'month');
        array_multisort($keys, SORT_ASC, $sales);
        foreach ($sales as $key => $sale) {
            $sales[$key]['month'] = $sale['month'];
            $sales[$key]['month_name'] = convertMonthNumber($sale['month']);
            $sales[$key]['grand_total_sum'] = $sale['grand_total_sum'];
        }
        return $sales;
    }
    function ekgDataForChart()
    {
        $sales = Electrocardiogram::select(
            DB::raw('MONTH(registration_time) as month'),
            DB::raw('SUM(total_fee) as grand_total_sum')
        )->groupby('month')->whereYear('registration_time', date('Y'))->get()->toArray();
        $salesMonth = array_column($sales, 'month');
        $months = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
        foreach ($months as $month) {
            if (!in_array($month, $salesMonth)) {
                $sales[] = ['month' => $month, 'grand_total_sum' => 0.00];
            }
        }
        $keys = array_column($sales, 'month');
        array_multisort($keys, SORT_ASC, $sales);
        foreach ($sales as $key => $sale) {
            $sales[$key]['month'] = $sale['month'];
            $sales[$key]['month_name'] = convertMonthNumber($sale['month']);
            $sales[$key]['grand_total_sum'] = $sale['grand_total_sum'];
        }
        return $sales;
    }



    function administrationDataForChart()
    {
        $sales = Administration::select(
            DB::raw('MONTH(registration_time) as month'),
            DB::raw('SUM(total_fee) as grand_total_sum')
        )->groupby('month')->whereYear('registration_time', date('Y'))->get()->toArray();
        $salesMonth = array_column($sales, 'month');
        $months = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
        foreach ($months as $month) {
            if (!in_array($month, $salesMonth)) {
                $sales[] = ['month' => $month, 'grand_total_sum' => 0.00];
            }
        }
        $keys = array_column($sales, 'month');
        array_multisort($keys, SORT_ASC, $sales);
        foreach ($sales as $key => $sale) {
            $sales[$key]['month'] = $sale['month'];
            $sales[$key]['month_name'] = convertMonthNumber($sale['month']);
            $sales[$key]['grand_total_sum'] = $sale['grand_total_sum'];
        }
        return $sales;
    }
}
