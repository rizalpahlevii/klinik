<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateFamilyPlanningRequest;
use App\Http\Requests\CreateInpatientServiceRequest;
use App\Http\Requests\UpdateFamilyPlanningRequest;
use App\Http\Requests\UpdateInpatientServiceRequest;
use App\Queries\Services\AdministrationDataTable;
use App\Queries\Services\FamilyPlanningDataTable;
use App\Queries\Services\InpatientDataTable;
use App\Repositories\MedicRepository;
use App\Repositories\PatientRepository;
use App\Repositories\Services\InpatientRepository;
use Flash;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class InpatientServiceController extends AppBaseController
{
    protected $inpatientRepository;
    protected $patientRepository;
    protected $medicRepository;
    public function __construct(
        InpatientRepository $inpatientRepository,
        PatientRepository $patientRepository,
        MedicRepository $medicRepository
    ) {
        $this->medicRepository = $medicRepository;
        $this->patientRepository = $patientRepository;
        $this->inpatientRepository = $inpatientRepository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of((new InpatientDataTable())->get())
                ->addIndexColumn()
                ->editColumn('total_fee', function ($row) {
                    return convertToRupiah($row->total_fee, 'Rp. ');
                })->make(true);
        }
        return view('services.inpatients.index');
    }

    public function create()
    {
        $patients = $this->patientRepository->getPatients();
        $medics = $this->medicRepository->getMedics();
        return view('services.inpatients.create', compact('patients', 'medics'));
    }

    public function store(CreateInpatientServiceRequest $request)
    {
        $request->merge([
            'phone' => $request->phone_form,
            'service_fee' => convertCurrency($request->fee),
            'discount' => convertCurrency($request->discount),
            'total_fee' => convertCurrency($request->fee) - convertCurrency($request->discount),
        ]);
        $this->inpatientRepository->create($request->except(['_token', 'fee', 'phone_form']));
        Flash::success("Berhasil menginput layanan Rawat Inap");
        return redirect()->route('services.inpatients.index');
    }

    public function show($id)
    {
        $data = $this->inpatientRepository->findById($id);
        return view('services.inpatients.show', compact('data'));
    }

    public function edit($id)
    {
        $patients = $this->patientRepository->getPatients();
        $medics = $this->medicRepository->getMedics();
        $data = $this->inpatientRepository->findById($id);
        return view('services.inpatients.edit', compact('patients', 'medics', 'data'));
    }

    public function update(UpdateInpatientServiceRequest $request, $id)
    {
        $request->merge([
            'phone' => $request->phone_form,
            'service_fee' => convertCurrency($request->fee),
            'discount' => convertCurrency($request->discount),
            'total_fee' => convertCurrency($request->fee) - convertCurrency($request->discount),
        ]);
        $this->inpatientRepository->update($request->except(['_token', 'fee', 'phone_form']), $id);
        Flash::success("Berhasil mengubah data layanan Rawat Inap");
        return redirect()->route('services.inpatients.index');
    }

    public function destroy($id)
    {
        $familyPlanning = $this->inpatientRepository->findById($id);
        $familyPlanning->delete();
        if (!auth()->user()->hasRole('owner')) addNotification("melakukan penghapusan data layanan Rawat Inap : " . $familyPlanning->service_number);
        return $this->sendSuccess("Berhasil menghapus data layanan umum");
    }

    public function print($id)
    {
        $data = $this->inpatientRepository->findById($id);
        return view('services.inpatients.print', compact('data'));
    }
}
