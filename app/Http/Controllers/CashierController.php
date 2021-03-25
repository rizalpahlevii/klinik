<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSaleCashierRequest;
use App\Queries\ProductDataTable;
use App\Repositories\MedicRepository;
use App\Repositories\PatientRepository;
use App\Repositories\ProductRepository;
use App\Repositories\SaleRepository;
use Cookie;
use DB;
use Flash;
use Illuminate\Http\Request;

class CashierController extends AppBaseController
{
    protected $saleRepository;
    protected $medicRepository;
    protected $patientRepository;
    protected $productRepository;
    public function __construct(SaleRepository $saleRepository, MedicRepository $medicRepository, PatientRepository $patientRepository, ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
        $this->patientRepository = $patientRepository;
        $this->medicRepository = $medicRepository;
        $this->saleRepository = $saleRepository;
    }

    public function store(CreateSaleCashierRequest $request)
    {
        DB::beginTransaction();
        try {
            $sale = $this->saleRepository->create($request->all());
            Flash::success("Berhasil melakukan transaksi pembelian produk");
            DB::commit();
            Cookie::queue(Cookie::forget('klinik-sales-carts'));
            session()->flash('newurl', route('sales.datas.print', $sale->id));
        } catch (\Throwable $th) {
            DB::rollback();
            Flash::error("Ada Kesalahan Dalam melakukan transaksi");
        }
        return redirect()->route('sales.cashiers.index');
    }
    public function index(Request $request)
    {
        $patients = $this->patientRepository->getPatients();
        $medics = $this->medicRepository->getMedics();
        $carts = json_decode($request->cookie('klinik-sales-carts'), true);
        $products = (new ProductDataTable())->get()->get();
        return view('sales.cashiers.index', compact('products', 'carts', 'medics', 'patients'));
    }

    public function addCart(Request $request)
    {
        $carts = json_decode($request->cookie('klinik-sales-carts'), true);


        $product = $this->productRepository->findById($request->product_id);
        if ($carts && array_key_exists($request->product_id, $carts)) {
            if ($product->current_stock >= $carts[$request->product_id]['quantity'] += $request->quantity) {
                $carts[$request->product_id]['quantity'] += $request->quantity;
            } else {
                return $this->sendError("Stok Tidak Cukup", 200);
            }
        } else {
            if ($product->current_stock >= $request->quantity) {
                $carts[$request->product_id] = [
                    'quantity' => $request->quantity,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_code' => $product->product_code,
                    'unit' => $product->unit,
                    'price' => $product->selling_price,
                ];
            } else {
                return $this->sendError("Stok Tidak Cukup", 200);
            }
        }


        $cookie = cookie('klinik-sales-carts', json_encode($carts), 2800);

        return $this->sendSuccess("Berhasil menambahkan produk ke keranjang")->withCookie($cookie);
    }

    public function loadTable(Request $request)
    {
        $carts = json_decode($request->cookie('klinik-sales-carts'), true);
        if (!$carts) {
            $carts = [];
        }
        $products = (new ProductDataTable())->get()->get();

        return view('sales.cashiers.table', compact('carts', 'products'));
    }

    public function deleteCart(Request $request, $id)
    {
        $carts = json_decode(request()->cookie('klinik-sales-carts'), true);
        unset($carts[$id]);
        $cookie = cookie('klinik-sales-carts', json_encode($carts), 2880);
        return $this->sendSuccess("Berhasil menghapus produk ke keranjang")->withCookie($cookie);
    }
}
