<?php

namespace App\Repositories;

use App\Models\Sale;
use App\Models\Services\FamilyPlanning;
use App\Models\Services\General;
use App\Models\Services\Laboratory;
use App\Models\Services\Pregnancy;
use DB;

class ChartRepository
{
    public function getChart()
    {
        $sale = $this->getSalesDataForChart();
        $generalService = $this->getGeneralServiceDataForChart();
        $pregnancy = $this->getPregnancyServiceDataForChart();
        $laboratory = $this->getLaboratoryDataForChart();
        $familyPlanning = $this->getLFamilyPlanningDataForChart();
        $newData = [];
        foreach ($sale as $key => $row) {
            $newData[$key]['month'] = $row['month'];
            $newData[$key]['month_name'] = convertMonthNumber($row['month']);
            $newData[$key]['grand_total_sum'] = $row['grand_total_sum'] + $generalService[$key]['grand_total_sum'] + $pregnancy[$key]['grand_total_sum'] + $laboratory[$key]['grand_total_sum'] + $familyPlanning[$key]['grand_total_sum'];
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
}
