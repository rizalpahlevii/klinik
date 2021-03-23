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
            $this->saleRepository->create($request->all());
            Flash::success("Berhasil melakukan transaksi pembelian produk");
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            Flash::error("Ada Kesalahan Dalan melakukan transaksi");
        }
        $carts = Cookie::forget('klinik-sales-carts');
        return redirect()->route('sales.cashiers.index')->withCookie($carts);
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
                'price' => $product->selling_price,
            ];
        }


        $cookie = cookie('klinik-sales-carts', json_encode($carts), 2800);

        return $this->sendSuccess("Berhasil menambahkan produk ke keranjang")->withCookie($cookie);
    }

    public function loadTable(Request $request)
    {
        $carts = json_decode($request->cookie('klinik-sales-carts'), true);
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
