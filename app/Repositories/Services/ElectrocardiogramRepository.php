<?php


namespace App\Repositories\Services;

use App\Models\Services\Electrocardiogram;
use App\Repositories\BaseRepository;

class ElectrocardiogramRepository extends BaseRepository
{
    protected $electrocardiogram;

    public function __construct(Electrocardiogram $electrocardiogram)
    {
        $this->electrocardiogram = $electrocardiogram;
    }
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'service_number',
        'registration_time',
        'service_fee',
        'discount',
        'total_fee',
        'patient_id',
        'medic_id',
        'notes',
        'phone',
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
        return Electrocardiogram::class;
    }

    public function findById($id)
    {
        return $this->electrocardiogram->with('medic', 'patient')->findOrFail($id);
    }

    public function create($input)
    {
        return $this->electrocardiogram->create($input);
    }

    public function update($input, $id)
    {
        return $this->electrocardiogram->find($id)->update($input);
    }
}
