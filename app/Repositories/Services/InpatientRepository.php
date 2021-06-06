<?php


namespace App\Repositories\Services;

use App\Models\Services\Inpatient;
use App\Repositories\BaseRepository;

class InpatientRepository extends BaseRepository
{
    protected $inpatient;

    public function __construct(Inpatient $inpatient)
    {
        $this->inpatient = $inpatient;
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
        return Inpatient::class;
    }

    public function findById($id)
    {
        return $this->inpatient->with('medic', 'patient')->findOrFail($id);
    }

    public function create($input)
    {
        return $this->inpatient->create($input);
    }

    public function update($input, $id)
    {
        return $this->inpatient->find($id)->update($input);
    }
}
