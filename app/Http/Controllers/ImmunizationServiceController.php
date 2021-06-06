<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateFamilyPlanningRequest;
use App\Http\Requests\CreateImmunizationServiceRequest;
use App\Http\Requests\UpdateFamilyPlanningRequest;
use App\Http\Requests\UpdateImmunizationServiceRequest;
use App\Queries\Services\ImmunizationDataTable;
use App\Repositories\MedicRepository;
use App\Repositories\PatientRepository;
use App\Repositories\Services\ImmunizationRepository;
use Flash;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ImmunizationServiceController extends AppBaseController
{
    protected $immunizationRepository;
    protected $patientRepository;
    protected $medicRepository;
    public function __construct(
        ImmunizationRepository $immunizationRepository,
        PatientRepository $patientRepository,
        MedicRepository $medicRepository
    ) {
        $this->medicRepository = $medicRepository;
        $this->patientRepository = $patientRepository;
        $this->immunizationRepository = $immunizationRepository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of((new ImmunizationDataTable())->get())
                ->addIndexColumn()
                ->editColumn('total_fee', function ($row) {
                    return convertToRupiah($row->total_fee, 'Rp. ');
                })->make(true);
        }
        return view('services.immunizations.index');
    }

    public function create()
    {
        $patients = $this->patientRepository->getPatients();
        $medics = $this->medicRepository->getMedics();
        return view('services.immunizations.create', compact('patients', 'medics'));
    }

    public function store(CreateImmunizationServiceRequest $request)
    {
        $request->merge([
            'phone' => $request->phone_form,
            'service_fee' => convertCurrency($request->fee),
            'discount' => convertCurrency($request->discount),
            'total_fee' => convertCurrency($request->fee) - convertCurrency($request->discount),
        ]);
        $this->immunizationRepository->create($request->except(['_token', 'fee', 'phone_form']));
        Flash::success("Berhasil menginput layanan Imunisasi");
        return redirect()->route('services.immunizations.index');
    }

    public function show($id)
    {
        $data = $this->immunizationRepository->findById($id);
        return view('services.immunizations.show', compact('data'));
    }

    public function edit($id)
    {
        $patients = $this->patientRepository->getPatients();
        $medics = $this->medicRepository->getMedics();
        $data = $this->immunizationRepository->findById($id);
        return view('services.immunizations.edit', compact('patients', 'medics', 'data'));
    }

    public function update(UpdateImmunizationServiceRequest $request, $id)
    {
        $request->merge([
            'phone' => $request->phone_form,
            'service_fee' => convertCurrency($request->fee),
            'discount' => convertCurrency($request->discount),
            'total_fee' => convertCurrency($request->fee) - convertCurrency($request->discount),
        ]);
        $this->immunizationRepository->update($request->except(['_token', 'fee', 'phone_form']), $id);
        Flash::success("Berhasil mengubah data layanan Imunisasi");
        return redirect()->route('services.immunizations.index');
    }

    public function destroy($id)
    {
        $familyPlanning = $this->immunizationRepository->findById($id);
        $familyPlanning->delete();
        if (!auth()->user()->hasRole('owner')) addNotification("melakukan penghapusan data layanan Imunisasi : " . $familyPlanning->service_number);
        return $this->sendSuccess("Berhasil menghapus data layanan umum");
    }

    public function print($id)
    {
        $data = $this->immunizationRepository->findById($id);
        return view('services.immunizations.print', compact('data'));
    }
}
