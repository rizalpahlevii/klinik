<?php

namespace App\Repositories;

use App\Models\ProductBrand;
use App\Repositories\BaseRepository;

class ProductBrandRepository extends BaseRepository
{
    protected $productBrand;
    public function __construct(ProductBrand $productBrand)
    {
        $this->productBrand = $productBrand;
    }
    protected $fieldSearchable = [
        'brand_name', 'brand_phone', 'brand_address'
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

    public function delete($id)
    {
        return $this->findById($id)->delete();
    }
}
