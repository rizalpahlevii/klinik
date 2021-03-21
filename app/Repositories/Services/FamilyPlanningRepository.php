<?php


namespace App\Repositories\Services;

use App\Models\Services\FamilyPlanning;
use App\Repositories\BaseRepository;

class FamilyPlanningRepository extends BaseRepository
{
    protected $familyPlanning;

    public function __construct(FamilyPlanning $familyPlanning)
    {
        $this->familyPlanning = $familyPlanning;
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
        return FamilyPlanning::class;
    }

    public function findById($id)
    {
        return $this->familyPlanning->with('medic', 'patient')->findOrFail($id);
    }

    public function create($input)
    {
        return $this->familyPlanning->create($input);
    }

    public function update($input, $id)
    {
        return $this->familyPlanning->find($id)->update($input);
    }
}
