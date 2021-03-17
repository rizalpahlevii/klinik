<?php

namespace App\Repositories;

use Exception;
use App\Models\Patient;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class PatientRepository
 * @package App\Repositories
 * @version February 14, 2020, 5:53 am UTC
 */
class PatientRepository extends BaseRepository
{

    protected $patient;
    public function __construct(Patient $patient)
    {
        $this->patient = $patient;
    }

    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
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
        return Patient::class;
    }

    /**
     * @param  array  $input
     *
     * @param  bool  $mail
     * @return bool
     */
    public function store($input)
    {
        try {
            $input['name'] = $input['name_form'];
            $input['birth_date'] = $input['birth_date'];
            $input['phone'] = $input['phone_form'];
            $input['gender'] = $input['gender_form'];
            $input['blood_group'] = $input['blood_group'] == "null" ? null : $input['blood_group'];
            $input['address'] = $input['address_form'];
            $input['city'] = $input['city'];
            $this->patient->create($input);
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }

        return true;
    }

    /**
     * @param  array  $input
     * @param  Patient  $patient
     *
     * @return bool
     */
    public function update($input, $patien_id)
    {
        try {
            $input['name'] = $input['name_form'];
            $input['birth_date'] = $input['birth_date'];
            $input['phone'] = $input['phone_form'];
            $input['gender'] = $input['gender_form'];
            $input['blood_group'] = $input['blood_group'] == "null" ? null : $input['blood_group'];
            $input['address'] = $input['address_form'];
            $input['city'] = $input['city'];
            $patien = $this->patient->find($patien_id)->update($input);
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }

        return true;
    }
    public function getPatient($id)
    {
        return $this->patient->find($id);
    }
    public function getPatientAssociatedData($id)
    {
        return $this->patient->with('services.medic')->findOrFail($id);
    }
}
