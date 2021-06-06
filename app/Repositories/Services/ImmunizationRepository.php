<?php


namespace App\Repositories\Services;

use App\Models\Services\Immunization;
use App\Repositories\BaseRepository;

class ImmunizationRepository extends BaseRepository
{
    protected $immunization;

    public function __construct(Immunization $immunization)
    {
        $this->immunization = $immunization;
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
        return Immunization::class;
    }

    public function findById($id)
    {
        return $this->immunization->with('medic', 'patient')->findOrFail($id);
    }

    public function create($input)
    {
        return $this->immunization->create($input);
    }

    public function update($input, $id)
    {
        return $this->immunization->find($id)->update($input);
    }
}
