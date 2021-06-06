<?php


namespace App\Repositories\Services;

use App\Models\Services\Administration;
use App\Repositories\BaseRepository;

class AdministrationRepository extends BaseRepository
{
    protected $admininstration;

    public function __construct(Administration $admininstration)
    {
        $this->admininstration = $admininstration;
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
        return Administration::class;
    }

    public function findById($id)
    {
        return $this->admininstration->with('medic', 'patient')->findOrFail($id);
    }

    public function create($input)
    {
        return $this->admininstration->create($input);
    }

    public function update($input, $id)
    {
        return $this->admininstration->find($id)->update($input);
    }
}
