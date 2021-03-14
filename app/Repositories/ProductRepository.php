<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\ProductCategory;

class ProductRepository extends BaseRepository
{
    protected $product;

    protected $productBrand;

    protected $productCategory;

    public function __construct(Product $product, ProductBrand $productBrand, ProductCategory $productCategory)
    {
        $this->productBrand = $productBrand;
        $this->product = $product;
        $this->productCategory = $productCategory;
    }

    protected $fieldSearchable = [
        'product_code',
        'name',
        'category_id',
        'brand_id',
        'unit',
        'selling_price',
        'current_stock',
        'total_minimum_stock',
        'side_effects',
        'notes'
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
        return Product::class;
    }

    public function getBrands()
    {
        return $this->productBrand->get();
    }

    public function getCategories()
    {
        return $this->productCategory->get();
    }

    public function findById($id)
    {
        return $this->product->with('brand', 'category')->findOrFail($id);
    }

    public function create($input)
    {
        return $this->product->create($input);
    }

    public function update($input, $id)
    {
        return $this->product->find($id)->update($input);
    }

    public function delete($id)
    {
        return $this->product->find($id)->delete();
    }
}
