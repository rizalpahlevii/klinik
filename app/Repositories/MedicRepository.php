<?php

namespace App\Repositories;

use App\Models\Medic;
use App\Models\Patient;
use App\Models\Services\FamilyPlanning;
use App\Models\Services\General;
use App\Models\Services\Laboratory;
use App\Models\Services\Pregnancy;
use Exception;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class MedicRepository extends BaseRepository
{
    protected $medic;

    protected $patient;
    public function __construct(Medic $medic, Patient $patient)
    {
        $this->patient = $patient;
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

    public function getMedicAssociatedData($id, $onlyOneRelation = null)
    {
        $query = $this->medic;
        if ($onlyOneRelation) {
            $query = $query->with($onlyOneRelation);
        } else {
            $query = $query->with(
                'generalServices.patient',
                'laboratoryServices.patient',
                'pregnancyServices.patient',
                'familyPlanningServices.patient',
                'immunizationServices.patient',
                'parturitionServices.patient',
                'electrocardiogramServices.patient',
                'inpatientServices.patient',
                'administrationServices.patient',
            );
        }
        return $query->findOrFail($id);
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

    public function getPatients($medic_id)
    {
        $generals = General::where('medic_id', $medic_id)->get()->pluck('patient_id')->toArray();
        $pregnancies = Pregnancy::where('medic_id', $medic_id)->get()->pluck('patient_id')->toArray();
        $familyPlannings = FamilyPlanning::where('medic_id', $medic_id)->get()->pluck('patient_id')->toArray();
        $laboratories = Laboratory::where('medic_id', $medic_id)->get()->pluck('patient_id')->toArray();
        $patientdId = array_unique(array_merge($generals, $pregnancies, $familyPlannings, $laboratories));
        return $this->patient->whereIn('id', $patientdId)->get();
    }
}
