<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductCategoryRequest;
use App\Http\Requests\UpdateProductCategoryRequest;
use App\Models\Product;
use App\Queries\ProductCategoryDataTable;
use App\Repositories\ProductCategoryRepository;
use Illuminate\Http\Request;
use DataTables;

class ProductCategoryController extends AppBaseController
{
    protected $productCategoryRepository;

    public function __construct(ProductCategoryRepository $productCategoryRepository)
    {
        $this->productCategoryRepository = $productCategoryRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of((new ProductCategoryDataTable())->get())->make(true);
        }
        return view('product_categories.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProductCategoryRequest $request)
    {
        $input = $request->all();

        $this->productCategoryRepository->store($input);

        return $this->sendSuccess("Kategori Produk Berhasil Dibuat");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = $this->productCategoryRepository->findById($id);

        return $this->sendResponse($category, "Berhasil mendapatkan data kategori");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductCategoryRequest $request, $id)
    {
        $this->productCategoryRepository->update($request->all(), $id);
        return $this->sendSuccess("Berhasil mengubah data kategori");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $categoryModels = [
            Product::class
        ];
        $result = canDelete($categoryModels, 'category_id', $id);
        if ($result) {
            return $this->sendError("Data kategori tidak dapat dihapus");
        } else {
            $this->productCategoryRepository->delete($id);
            return $this->sendSuccess("Berhasil menghpus data kategori");
        }
    }
}
