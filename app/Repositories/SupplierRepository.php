<?php

namespace App\Repositories;

use App\Models\Supplier;
use App\Models\SupplierSalesman;

class SupplierRepository extends BaseRepository
{
    protected $fieldSearchable = ['name', 'phone', 'address'];

    protected $supplier;

    protected $salesMan;

    public function __construct(Supplier $supplier, SupplierSalesman $supplierSalesman)
    {
        $this->supplier = $supplier;
        $this->salesMan = $supplierSalesman;
    }

    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    public function model()
    {
        return Supplier::class;
    }

    public function getSupplier($supplier_id)
    {
        return $this->supplier->findOrFail($supplier_id);
    }


    public function createSupplier($input)
    {
        $input['name'] = $input['name_form'];
        $input['phone'] = preparePhoneNumber($input, 'phone_form');
        $input['address'] = $input['address_form'];
        $this->supplier->create($input);
    }

    public function updateSupplier($input, $supplier_id)
    {
        $input['name'] = $input['name_form'];
        $input['phone'] = preparePhoneNumber($input, 'phone_form');
        $input['address'] = $input['address_form'];
        $this->supplier->find($supplier_id)->update($input);
    }

    public function getSalesman($salesManId)
    {
        return $this->salesMan->find($salesManId);
    }


    public function createSalesman($input, $supplier_id)
    {
        $input['salesman_name'] = $input['salesman_name'];
        $input['supplier_id'] = $supplier_id;
        $input['phone'] = $input['salesman_phone'];
        $this->salesMan->create($input);
    }

    public function getSupplierAssociatedData($supplier_id)
    {
        return $this->supplier->with('salesmans')->findOrFail($supplier_id)->first();
    }

    public function deleteSalesman($salesManId)
    {
        return $this->salesMan->find($salesManId)->delete();
    }
}
