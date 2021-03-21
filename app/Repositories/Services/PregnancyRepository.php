<?php


namespace App\Repositories\Services;

use App\Models\Services\Pregnancy;
use App\Repositories\BaseRepository;

class PregnancyRepository extends BaseRepository
{
    protected $pregnancy;

    public function __construct(Pregnancy $pregnancy)
    {
        $this->pregnancy = $pregnancy;
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
        return $this->pregnancy->with('medic', 'patient')->findOrFail($id);
    }

    public function create($input)
    {
        return $this->pregnancy->create($input);
    }

    public function update($input, $id)
    {
        return $this->pregnancy->find($id)->update($input);
    }
}
