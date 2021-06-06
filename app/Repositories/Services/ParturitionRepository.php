<?php


namespace App\Repositories\Services;

use App\Models\Services\Parturition;
use App\Repositories\BaseRepository;

class ParturitionRepository extends BaseRepository
{
    protected $parturition;

    public function __construct(Parturition $parturition)
    {
        $this->parturition = $parturition;
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
        return Parturition::class;
    }

    public function findById($id)
    {
        return $this->parturition->with('medic', 'patient')->findOrFail($id);
    }

    public function create($input)
    {
        return $this->parturition->create($input);
    }

    public function update($input, $id)
    {
        return $this->parturition->find($id)->update($input);
    }
}
