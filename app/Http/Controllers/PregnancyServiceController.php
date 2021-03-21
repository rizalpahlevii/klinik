<?php

namespace App\Http\Controllers;

use App\Repositories\MedicRepository;
use App\Repositories\PatientRepository;
use App\Repositories\Services\PregnancyRepository;
use Illuminate\Http\Request;

class PregnancyServiceController extends Controller
{
    protected $pregnancyRepository;
    protected $patientRepository;
    protected $medicRepository;
    public function __construct(PregnancyRepository $pregnancyRepository, PatientRepository $patientRepository, MedicRepository $medicRepository)
    {
        $this->medicRepository = $medicRepository;
        $this->patientRepository = $patientRepository;
        $this->pregnancyRepository = $pregnancyRepository;
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
