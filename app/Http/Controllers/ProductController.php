<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Queries\ProductDataTable;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use DataTables;
use Flash;

class ProductController extends AppBaseController
{
    protected $productRepository;
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of((new ProductDataTable())->get())
                ->addIndexColumn()
                ->make(true);
        }
        return view('products.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->productRepository->getCategories();
        $brands = $this->productRepository->getBrands();
        return view('products.create', compact('categories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProductRequest $request)
    {
        $request->merge(['name' => $request->product_name]);
        $this->productRepository->create($request->all());
        Flash::success("Berhasil membuat data produk baru");
        return redirect()->route('products.index');
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
        $categories = $this->productRepository->getCategories();
        $brands = $this->productRepository->getBrands();
        $product = $this->productRepository->findById($id);
        return view('products.edit', compact('categories', 'brands', 'product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, $id)
    {
        $request->merge(['name' => $request->product_name]);
        $this->productRepository->update($request->all(), $id);
        Flash::success("Berhasil mengubah data produk ");
        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $brandModels = [];
        $result = canDelete($brandModels, 'product_id', $product->id);
        if ($result) {
            return $this->sendError("Data produk tidak dapat dihapus");
        } else {
            if (!auth()->user()->hasRole('owner')) addNotification("melakukan penghapusan data produk : " . $product->name);
            $product->delete();
            return $this->sendSuccess("Berhasil menghpus data produk");
        }
    }
}
