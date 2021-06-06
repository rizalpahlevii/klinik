<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAdministrationServiceRequest;
use App\Http\Requests\CreateFamilyPlanningRequest;
use App\Http\Requests\UpdateAdministrationServiceRequest;
use App\Http\Requests\UpdateFamilyPlanningRequest;
use App\Queries\Services\AdministrationDataTable;
use App\Queries\Services\FamilyPlanningDataTable;
use App\Repositories\MedicRepository;
use App\Repositories\PatientRepository;
use App\Repositories\Services\AdministrationRepository;
use Flash;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AdministrationServiceController extends AppBaseController
{
    protected $administrationRepository;
    protected $patientRepository;
    protected $medicRepository;
    public function __construct(
        AdministrationRepository $administrationRepository,
        PatientRepository $patientRepository,
        MedicRepository $medicRepository
    ) {
        $this->medicRepository = $medicRepository;
        $this->patientRepository = $patientRepository;
        $this->administrationRepository = $administrationRepository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of((new AdministrationDataTable())->get())
                ->addIndexColumn()
                ->editColumn('total_fee', function ($row) {
                    return convertToRupiah($row->total_fee, 'Rp. ');
                })->make(true);
        }
        return view('services.administrations.index');
    }

    public function create()
    {
        $patients = $this->patientRepository->getPatients();
        $medics = $this->medicRepository->getMedics();
        return view('services.administrations.create', compact('patients', 'medics'));
    }

    public function store(CreateAdministrationServiceRequest $request)
    {
        $request->merge([
            'phone' => $request->phone_form,
            'service_fee' => convertCurrency($request->fee),
            'discount' => convertCurrency($request->discount),
            'total_fee' => convertCurrency($request->fee) - convertCurrency($request->discount),
        ]);
        $this->administrationRepository->create($request->except(['_token', 'fee', 'phone_form']));
        Flash::success("Berhasil menginput layanan Administrasi");
        return redirect()->route('services.administrations.index');
    }

    public function show($id)
    {
        $data = $this->administrationRepository->findById($id);
        return view('services.administrations.show', compact('data'));
    }

    public function edit($id)
    {
        $patients = $this->patientRepository->getPatients();
        $medics = $this->medicRepository->getMedics();
        $data = $this->administrationRepository->findById($id);
        return view('services.administrations.edit', compact('patients', 'medics', 'data'));
    }

    public function update(UpdateAdministrationServiceRequest $request, $id)
    {
        $request->merge([
            'phone' => $request->phone_form,
            'service_fee' => convertCurrency($request->fee),
            'discount' => convertCurrency($request->discount),
            'total_fee' => convertCurrency($request->fee) - convertCurrency($request->discount),
        ]);
        $this->administrationRepository->update($request->except(['_token', 'fee', 'phone_form']), $id);
        Flash::success("Berhasil mengubah data layanan Administrasi");
        return redirect()->route('services.administrations.index');
    }

    public function destroy($id)
    {
        $familyPlanning = $this->administrationRepository->findById($id);
        $familyPlanning->delete();
        if (!auth()->user()->hasRole('owner')) addNotification("melakukan penghapusan data layanan Administrasi : " . $familyPlanning->service_number);
        return $this->sendSuccess("Berhasil menghapus data layanan umum");
    }

    public function print($id)
    {
        $data = $this->administrationRepository->findById($id);
        return view('services.administrations.print', compact('data'));
    }
}
