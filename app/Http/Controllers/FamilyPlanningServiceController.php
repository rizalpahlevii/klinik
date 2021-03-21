<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateFamilyPlanningRequest;
use App\Http\Requests\UpdateFamilyPlanningRequest;
use App\Queries\Services\FamilyPlanningDataTable;
use App\Repositories\Services\FamilyPlanningRepository;
use App\Repositories\MedicRepository;
use App\Repositories\PatientRepository;
use Flash;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class FamilyPlanningServiceController extends AppBaseController
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
            return DataTables::of((new FamilyPlanningDataTable())->get())
                ->addIndexColumn()
                ->editColumn('total_fee', function ($row) {
                    return convertToRupiah($row->total_fee, 'Rp. ');
                })->make(true);
        }
        return view('services.family_plannings.index');
    }

    public function create()
    {
        $patients = $this->patientRepository->getPatients();
        $medics = $this->medicRepository->getMedics();
        return view('services.family_plannings.create', compact('patients', 'medics'));
    }

    public function store(CreateFamilyPlanningRequest $request)
    {
        $request->merge([
            'phone' => $request->phone_form,
            'service_fee' => convertCurrency($request->fee),
            'discount' => convertCurrency($request->discount),
            'total_fee' => convertCurrency($request->fee) - convertCurrency($request->discount),
        ]);
        $this->familyPlanningRepository->create($request->except(['_token', 'fee', 'phone_form']));
        Flash::success("Berhasil menginput layanan KB");
        return redirect()->route('services.family_plannings.index');
    }

    public function show($id)
    {
        $data = $this->familyPlanningRepository->findById($id);
        return view('services.family_plannings.show', compact('data'));
    }

    public function edit($id)
    {
        $patients = $this->patientRepository->getPatients();
        $medics = $this->medicRepository->getMedics();
        $data = $this->familyPlanningRepository->findById($id);
        return view('services.family_plannings.edit', compact('patients', 'medics', 'data'));
    }

    public function update(UpdateFamilyPlanningRequest $request, $id)
    {
        $request->merge([
            'phone' => $request->phone_form,
            'service_fee' => convertCurrency($request->fee),
            'discount' => convertCurrency($request->discount),
            'total_fee' => convertCurrency($request->fee) - convertCurrency($request->discount),
        ]);
        $this->familyPlanningRepository->update($request->except(['_token', 'fee', 'phone_form']), $id);
        Flash::success("Berhasil mengubah data layanan KB");
        return redirect()->route('services.family_plannings.index');
    }

    public function destroy($id)
    {
        $familyPlanning = $this->familyPlanningRepository->findById($id);
        $familyPlanning->delete();
        if (!auth()->user()->hasRole('owner')) addNotification("melakukan penghapusan data layanan KB : " . $familyPlanning->service_number);
        return $this->sendSuccess("Berhasil menghapus data layanan umum");
    }
}
