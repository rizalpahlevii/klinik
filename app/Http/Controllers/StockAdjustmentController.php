<?php

namespace App\Http\Controllers;

use App\Queries\ProductDataTable;
use App\Repositories\DashboardRepository;
use App\Repositories\ProductRepository;
use App\Repositories\StockAdjusmentRepository;
use DB;
use Flash;
use Illuminate\Http\Request;

class StockAdjustmentController extends Controller
{
    protected $dashboardRepository;
    protected $productRepository;
    protected $stockAdjusmentRepository;
    public function __construct(
        DashboardRepository $dashboardRepository,
        ProductRepository $productRepository,
        StockAdjusmentRepository $stockAdjusmentRepository
    ) {
        $this->stockAdjusmentRepository = $stockAdjusmentRepository;
        $this->productRepository = $productRepository;
        $this->dashboardRepository = $dashboardRepository;
    }
    public function index()
    {
        $products = (new ProductDataTable)->get()->get();
        $stockAdjusments = $this->dashboardRepository->stockAdjusments();
        return view('stock-adjusments.index', compact('stockAdjusments', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'note' => 'nullable|min:3',
            'quantity' => 'numeric',
            'type' => 'required',
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

    public function update(Request $request, $id)
    {
        $request->validate([
            'product_id_edit' => 'required',
            'note_edit' => 'nullable|min:3',
            'quantity_edit' => 'numeric',
            'type_edit' => 'required'
        ]);
        DB::beginTransaction();
        try {
            $this->stockAdjusmentRepository->update($request->except('_token'), $id);
            DB::commit();
            Flash::success("Berhasil mengubah stok penyesuaian produk");
        } catch (\Exception $e) {
            DB::rollBack();
            Flash::error($e->getMessage());
        }
        return redirect()->back();
    }

    public function destroy($id)
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
}
