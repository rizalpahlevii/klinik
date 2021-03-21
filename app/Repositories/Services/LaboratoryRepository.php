<?php

namespace App\Repositories\Services;

use App\Models\Services\Laboratory;
use App\Repositories\BaseRepository;

class LaboratoryRepository extends BaseRepository
{
    protected $laboratory;

    public function __construct(Laboratory $laboratory)
    {
        $this->laboratory = $laboratory;
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
        return Pregnancy::class;
    }

    public function findById($id)
    {
        return $this->laboratory->with('medic', 'patient')->findOrFail($id);
    }

    public function create($input)
    {
        return $this->laboratory->create($input);
    }

    public function update($input, $id)
    {
        return $this->laboratory->find($id)->update($input);
    }
}
