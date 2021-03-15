<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductBrandRequest;
use App\Http\Requests\UpdateProductBrandRequest;
use App\Models\Product;
use App\Models\ProductBrand;
use App\Queries\ProductBrandDataTable;
use Illuminate\Http\Request;
use DataTables;
use Flash;
use App\Repositories\ProductBrandRepository;

class ProductBrandController extends AppBaseController
{
    protected $productBrandRepository;
    public function __construct(ProductBrandRepository $productBrandRepository)
    {
        $this->productBrandRepository = $productBrandRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of((new ProductBrandDataTable)->get())->make(true);
        }
        return view('product_brands.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('product_brands.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProductBrandRequest $request)
    {
        $this->productBrandRepository->create($request->all());
        return $this->sendSuccess("Berhasil menyimpan data merek baru");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brand = $this->productBrandRepository->findById($id);
        return $this->sendResponse($brand, 'Berhasil mendapatkan data merek');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductBrandRequest $request, $id)
    {
        $this->productBrandRepository->update($request->all(), $id);
        return $this->sendSuccess('Data merek berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brandModels = [
            Product::class
        ];
        $result = canDelete($brandModels, 'brand_id', $id);
        if ($result) {
            return $this->sendError("Data merek tidak dapat dihapus");
        } else {
            $productBrand = $this->productBrandRepository->findById($id);
            if (!auth()->user()->hasRole('owner')) addNotification("melakukan penghapusan data merek : " . $productBrand->brand_name);
            $productBrand->delete();
            return $this->sendSuccess("Berhasil menghpus data merek");
        }
    }
}
