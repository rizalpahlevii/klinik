<?php

namespace App\Repositories;

use App\Models\Medic;
use Exception;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class MedicRepository extends BaseRepository
{
    protected $medic;

    public function __construct(Medic $medic)
    {
        $this->medic = $medic;
    }
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'specialization',
        'birth_date',
        'phone',
        'gender',
        'blood_group',
        'address',
        'city'
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
        return Medic::class;
    }

    public function store($input)
    {
        try {
            $input['name'] = $input['name_form'];
            $input['specialization'] = $input['specialization'];
            $input['birth_date'] = $input['birth_date'];
            $input['phone'] = $input['phone_form'];
            $input['gender'] = $input['gender_form'];
            $input['blood_group'] = $input['blood_group'] == "null" ? null : $input['blood_group'];
            $input['address'] = $input['address_form'];
            $input['city'] = $input['city'];
            $this->medic->create($input);
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }

        return true;
    }

    public function getMedicAssociatedData($id)
    {
        return $this->medic->with('services.patient')->findOrFail($id);
    }

    public function update($input, $medic_id)
    {
        try {
            $input['name'] = $input['name_form'];
            $input['birth_date'] = $input['birth_date'];
            $input['specialization'] = $input['specialization'];
            $input['phone'] = $input['phone_form'];
            $input['gender'] = $input['gender_form'];
            $input['blood_group'] = $input['blood_group'] == "null" ? null : $input['blood_group'];
            $input['address'] = $input['address_form'];
            $input['city'] = $input['city'];
            $this->medic->find($medic_id)->update($input);
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }

        return true;
    }

    public function getMedic($id)
    {
        return $this->medic->findOrFail($id);
    }

    public function getMedics()
    {
        return $this->medic->get();
    }
}
