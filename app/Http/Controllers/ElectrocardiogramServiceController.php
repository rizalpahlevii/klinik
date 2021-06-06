<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateElectrocardiogramServiceRequest;
use App\Http\Requests\CreateFamilyPlanningRequest;
use App\Http\Requests\UpdateElectrocardiogramServiceRequest;
use App\Http\Requests\UpdateFamilyPlanningRequest;
use App\Queries\Services\ElectrocardiogramDataTable;
use App\Repositories\MedicRepository;
use App\Repositories\PatientRepository;
use App\Repositories\Services\ElectrocardiogramRepository;
use Flash;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ElectrocardiogramServiceController extends AppBaseController
{
    protected $electrocardiogramRepository;
    protected $patientRepository;
    protected $medicRepository;
    public function __construct(
        ElectrocardiogramRepository $electrocardiogramRepository,
        PatientRepository $patientRepository,
        MedicRepository $medicRepository
    ) {
        $this->medicRepository = $medicRepository;
        $this->patientRepository = $patientRepository;
        $this->electrocardiogramRepository = $electrocardiogramRepository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of((new ElectrocardiogramDataTable())->get())
                ->addIndexColumn()
                ->editColumn('total_fee', function ($row) {
                    return convertToRupiah($row->total_fee, 'Rp. ');
                })->make(true);
        }
        return view('services.electrocardiograms.index');
    }

    public function create()
    {
        $patients = $this->patientRepository->getPatients();
        $medics = $this->medicRepository->getMedics();
        return view('services.electrocardiograms.create', compact('patients', 'medics'));
    }

    public function store(CreateElectrocardiogramServiceRequest $request)
    {
        $request->merge([
            'phone' => $request->phone_form,
            'service_fee' => convertCurrency($request->fee),
            'discount' => convertCurrency($request->discount),
            'total_fee' => convertCurrency($request->fee) - convertCurrency($request->discount),
        ]);
        $this->electrocardiogramRepository->create($request->except(['_token', 'fee', 'phone_form']));
        Flash::success("Berhasil menginput layanan EKG");
        return redirect()->route('services.electrocardiograms.index');
    }

    public function show($id)
    {
        $data = $this->electrocardiogramRepository->findById($id);
        return view('services.electrocardiograms.show', compact('data'));
    }

    public function edit($id)
    {
        $patients = $this->patientRepository->getPatients();
        $medics = $this->medicRepository->getMedics();
        $data = $this->electrocardiogramRepository->findById($id);
        return view('services.electrocardiograms.edit', compact('patients', 'medics', 'data'));
    }

    public function update(UpdateElectrocardiogramServiceRequest $request, $id)
    {
        $request->merge([
            'phone' => $request->phone_form,
            'service_fee' => convertCurrency($request->fee),
            'discount' => convertCurrency($request->discount),
            'total_fee' => convertCurrency($request->fee) - convertCurrency($request->discount),
        ]);
        $this->electrocardiogramRepository->update($request->except(['_token', 'fee', 'phone_form']), $id);
        Flash::success("Berhasil mengubah data layanan EKG");
        return redirect()->route('services.electrocardiograms.index');
    }

    public function destroy($id)
    {
        $familyPlanning = $this->electrocardiogramRepository->findById($id);
        $familyPlanning->delete();
        if (!auth()->user()->hasRole('owner')) addNotification("melakukan penghapusan data layanan EKG : " . $familyPlanning->service_number);
        return $this->sendSuccess("Berhasil menghapus data layanan umum");
    }

    public function print($id)
    {
        $data = $this->electrocardiogramRepository->findById($id);
        return view('services.electrocardiograms.print', compact('data'));
    }
}
