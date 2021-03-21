<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\ProductBrand;
use App\Repositories\BaseRepository;

class ProductBrandRepository extends BaseRepository
{
    protected $productBrand;
    protected $product;
    public function __construct(ProductBrand $productBrand, Product $product)
    {
        $this->product = $product;
        $this->productBrand = $productBrand;
    }
    protected $fieldSearchable = [
        'brand_name'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ProductBrand::class;
    }

    public function create($input)
    {
        return $this->productBrand->create($input);
    }

    public function findById($id)
    {
        return $this->productBrand->find($id);
    }

    public function update($input, $id)
    {
        return $this->findById($id)->update($input);
    }

    public function getProducts($brand_id)
    {
        return $this->product->with('category')->where('brand_id', $brand_id)->get();
    }

    public function delete($id)
    {
        return $this->findById($id)->delete();
    }
}
