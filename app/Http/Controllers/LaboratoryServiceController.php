<?php

namespace App\Http\Controllers;

use App\Repositories\Services\LaboratoryRepository;
use App\Repositories\MedicRepository;
use App\Repositories\PatientRepository;
use Illuminate\Http\Request;

class LaboratoryServiceController extends Controller
{
    protected $laboratoryRepository;
    protected $patientRepository;
    protected $medicRepository;
    public function __construct(LaboratoryRepository $laboratoryRepository, PatientRepository $patientRepository, MedicRepository $medicRepository)
    {
        $this->medicRepository = $medicRepository;
        $this->patientRepository = $patientRepository;
        $this->laboratoryRepository = $laboratoryRepository;
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
