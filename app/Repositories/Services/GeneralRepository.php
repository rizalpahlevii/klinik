<?php


namespace App\Repositories\Services;

use App\Models\Service;
use App\Models\Services\General;
use App\Repositories\BaseRepository;

class GeneralRepository extends BaseRepository
{

    protected $general;

    public function __construct(General $general)
    {
        $this->general = $general;
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
        return General::class;
    }

    public function findById($id)
    {
        return $this->general->with('medic', 'patient')->findOrFail($id);
    }

    public function update($input, $id)
    {
        return $this->general->find($id)->update($input);
    }
}
