<?php

namespace App\Repositories;

use App\Models\Spending;

class SpendingRepository extends BaseRepository
{
    protected $spending;
    public function __construct(Spending $spending)
    {
        $this->spending = $spending;
    }

    protected $fieldSearchable = [
        'name',
        'created_at',
        'type',
        'amount'
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
        return Spending::class;
    }

    public function findById($id)
    {
        return $this->spending->findOrFail($id);
    }

    public function create($input)
    {
        return $this->spending->create($input);
    }

    public function update($input, $id)
    {
        return $this->spending->find($id)->update($input);
    }
}
