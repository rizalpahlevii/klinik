<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePurchaseRequest;
use App\Http\Requests\UpdatePurchaseRequest;
use App\Models\User;
use App\Queries\ProductDataTable;
use App\Queries\PurchaseDataTable;
use App\Repositories\ProductRepository;
use App\Repositories\PurchaseRepository;
use App\Repositories\SupplierRepository;
use Cookie;
use DB;
use Flash;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PurchaseController extends AppBaseController
{
    protected $purchaseRepository;
    protected $productRepository;
    protected $supplierRepository;
    public function __construct(PurchaseRepository $purchaseRepository, SupplierRepository $supplierRepository, ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
        $this->supplierRepository = $supplierRepository;
        $this->purchaseRepository = $purchaseRepository;
    }

    public function index(Request $request)
    {

        if ($request->ajax()) {
            return DataTables::of((new PurchaseDataTable())->get())
                ->addIndexColumn()
                ->filter(function ($query) use ($request) {
                    if ($request->has('start_date') && $request->has('end_date')) {
                        $query->where('receipt_date', '>=', $request->start_date)->where('receipt_date', '<=', $request->end_date);
                    }
                })
                ->addColumn('grand_total2', function ($row) {
                    return convertToRupiah($row->grand_total, "Rp.");
                })->make(true);
        }
        return view('purchases.data.index');
    }

    public function create()
    {

        $suppliers = $this->supplierRepository->getSuppliers();
        return view('purchases.create', compact('suppliers'));
    }

    public function store(CreatePurchaseRequest $request)
    {
        DB::beginTransaction();
        try {
            if ($request->file) {
                $imageName = time() . '.' . $request->file->getClientOriginalExtension();
                $request->file->move(public_path('/uploads/purchases'), $imageName);
                $request->merge(['photo' => 'uploads/purchases/' . $imageName]);
            }
            $purchase = $this->purchaseRepository->create($request->all());
            Flash::success("Berhasil melakukan transaksi pembelian produk");
            session()->flash('newurl', route('purchases.print', $purchase->id));

            DB::commit();
            Cookie::queue(Cookie::forget('klinik-purchases-carts'));
        } catch (\Exception $e) {
            DB::rollback();
            Flash::error($e->getMessage());
        }
        return redirect()->route('purchases.index');
    }


    public function addCart(Request $request)
    {
        $carts = json_decode($request->cookie('klinik-purchases-carts'), true);

        if ($carts && array_key_exists($request->product_id, $carts)) {
            $carts[$request->product_id]['quantity'] += $request->quantity;
        } else {
            $product = $this->productRepository->findById($request->product_id);
            $carts[$request->product_id] = [
                'quantity' => $request->quantity,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'product_code' => $product->product_code,
                'unit' => $product->unit,
                'price' => $request->price,
            ];
        }


        $cookie = cookie('klinik-purchases-carts', json_encode($carts), 2800);

        return $this->sendSuccess("Berhasil menambahkan produk ke keranjang")->withCookie($cookie);
    }


    public function updateCart(Request $request, $id)
    {
        $carts = json_decode(request()->cookie('klinik-purchases-carts'), true);
        foreach ($carts as $key => $cart) {
            if ($cart['product_id'] == $id) {
                $carts[$key]['quantity'] = $request->qty;
            }
        }
        $cookie = cookie('klinik-purchases-carts', json_encode($carts), 2880);
        return $this->sendSuccess("Berhasil mengubah keranjang")->withCookie($cookie);
    }

    public function loadTable(Request $request)
    {
        $carts = json_decode($request->cookie('klinik-purchases-carts'), true);
        if (!$carts) {
            $carts = [];
        }
        $products = (new ProductDataTable())->get()->get();
        return view('purchases.table', compact('carts', 'products'));
    }

    public function deleteCart(Request $request, $id)
    {
        $carts = json_decode(request()->cookie('klinik-purchases-carts'), true);
        unset($carts[$id]);
        $cookie = cookie('klinik-purchases-carts', json_encode($carts), 2880);
        return $this->sendSuccess("Berhasil menghapus produk ke keranjang")->withCookie($cookie);
    }

    public function getSalesmans($supplier_id)
    {
        return $this->sendResponse($this->supplierRepository->getSalesmanBySupplier($supplier_id), "Success get salesman");
    }

    public function edit($purchase_id)
    {
        $products = (new ProductDataTable())->get()->get();
        $purchase = $this->purchaseRepository->findById($purchase_id);
        $suppliers = $this->supplierRepository->getSuppliers();
        $supplierSalesmans = $this->supplierRepository->getSalesmanBySupplier($purchase->supplier_id);
        return view('purchases.edit.edit', compact('purchase', 'suppliers', 'supplierSalesmans', 'products'));
    }

    public function print($purchase_id)
    {
        $sale = $this->purchaseRepository->findById($purchase_id);

        return view('purchases.data.print', compact('sale'));
    }

    public function getProducts()
    {
        return $this->sendResponse((new ProductDataTable())->get()->get(), "Success to get products data");
    }

    public function update(UpdatePurchaseRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            if ($request->file) {
                $imageName = time() . '.' . $request->file->getClientOriginalExtension();
                $request->file->move(public_path('/uploads/purchases'), $imageName);
                $request->merge(['photo' => 'uploads/purchases/' . $imageName]);
            }
            $purchase =  $this->purchaseRepository->update($request->all(), $id);
            Flash::success("Berhasil melakukan pengubahan transaksi pembelian produk");
            session()->flash('newurl', route('purchases.print', $purchase->id));
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Flash::error($e->getMessage());
        }
        return redirect()->route('purchases.index');
    }

    public function destroy($id)
    {

        $brandModels = [];
        $purchase = $this->purchaseRepository->findById($id);
        if (!auth()->user()->hasRole('owner')) addNotification("melakukan penghapusan data pembelian : " . $purchase->receipt_code);
        $purchase->delete();
        return $this->sendSuccess("Berhasil menghapus data pembelian");
    }
}
