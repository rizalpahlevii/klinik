<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateSalesDataRequest;
use App\Queries\ProductDataTable;
use App\Queries\SalesDataTable;
use App\Repositories\MedicRepository;
use App\Repositories\PatientRepository;
use App\Repositories\SaleRepository;
use DB;
use Flash;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SalesDataController extends Controller
{
    protected $saleRepository;
    protected $medicRepository;
    protected $patientRepository;
    public function __construct(SaleRepository $saleRepository, PatientRepository $patientRepository, MedicRepository $medicRepository)
    {
        $this->patientRepository = $patientRepository;
        $this->medicRepository = $medicRepository;
        $this->saleRepository = $saleRepository;
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of((new SalesDataTable())->get())
                ->filter(function ($query) use ($request) {
                    if ($request->has('start_date') && $request->has('end_date')) {
                        $query->where('receipt_date', '>=', $request->start_date)->where('receipt_date', '<=', $request->end_date);
                    }
                })
                ->addIndexColumn()
                ->addColumn('grand_total2', function ($row) {
                    return convertToRupiah($row->grand_total, "Rp.");
                })->make(true);
        }
        return view('sales.datas.index');
    }

    public function edit($id)
    {
        $patients = $this->patientRepository->getPatients();
        $medics = $this->medicRepository->getMedics();
        $sale = $this->saleRepository->findById($id);
        $products = (new ProductDataTable())->get()->get();
        return view('sales.datas.edit.index', compact('sale', 'patients', 'medics', 'products'));
    }

    public function update(UpdateSalesDataRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $this->saleRepository->update($request->all(), $id);
            DB::commit();
            Flash::success("Berhasil melakukan pengubahan transaksi pembelian produk");
        } catch (\Exception $e) {
            DB::rollBack();
            Flash::error($e->getMessage());
        }
        return redirect()->route('sales.datas.index');
    }

    public function print($id)
    {
        $sale = $this->saleRepository->findById($id);

        return view('sales.datas.print', compact('sale'));
    }

    public function show($id)
    {
        $sale = $this->saleRepository->findById($id);
        return view('sales.datas.show', compact('sale'));
    }
}
