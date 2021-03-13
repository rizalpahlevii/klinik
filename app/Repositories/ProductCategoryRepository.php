<?php

namespace App\Repositories;

use App\Models\ProductCategory;

class ProductCategoryRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'category_name'
    ];

    protected $productCategory;

    public function __construct(ProductCategory $productCategory)
    {
        $this->productCategory = $productCategory;
    }

    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    public function model()
    {
        return ProductCategory::class;
    }

    public function findById($id)
    {
        return $this->productCategory->find($id);
    }

    public function store($input)
    {
        $this->productCategory->create($input);
    }

    public function update($input, $id)
    {
        $this->productCategory->find($id)->update($input);
    }

    public function delete($id)
    {
        return $this->findById($id)->delete();
    }
}
