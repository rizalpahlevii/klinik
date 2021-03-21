<?php

namespace App\Http\Controllers;

use App\Repositories\Services\FamilyPlanningRepository;
use App\Repositories\MedicRepository;
use App\Repositories\PatientRepository;
use Illuminate\Http\Request;

class FamilyPlanningServiceController extends Controller
{
    protected $familyPlanningRepository;
    protected $patientRepository;
    protected $medicRepository;
    public function __construct(FamilyPlanningRepository $familyPlanningRepository, PatientRepository $patientRepository, MedicRepository $medicRepository)
    {
        $this->medicRepository = $medicRepository;
        $this->patientRepository = $patientRepository;
        $this->familyPlanningRepository = $familyPlanningRepository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
        }
    }

    public function create()
    {
        $patients = $this->patientRepository->getPatients();
        $medics = $this->medicRepository->getMedics();
    }

    public function store()
    {
    }
}
