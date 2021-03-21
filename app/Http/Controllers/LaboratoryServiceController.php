<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLaboratoryServiceRequest;
use App\Http\Requests\UpdateLaboratoryServiceRequest;
use App\Queries\Services\LaboratoryDataTable;
use App\Repositories\Services\LaboratoryRepository;
use App\Repositories\MedicRepository;
use App\Repositories\PatientRepository;
use Flash;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class LaboratoryServiceController extends AppBaseController
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
            return DataTables::of((new LaboratoryDataTable())->get())
                ->addIndexColumn()
                ->editColumn('total_fee', function ($row) {
                    return convertToRupiah($row->total_fee, 'Rp. ');
                })->make(true);
        }
        return view('services.laboratories.index');
    }

    public function create()
    {
        $patients = $this->patientRepository->getPatients();
        $medics = $this->medicRepository->getMedics();
        return view('services.laboratories.create', compact('patients', 'medics'));
    }

    public function store(CreateLaboratoryServiceRequest $request)
    {
        $request->merge([
            'phone' => $request->phone_form,
            'service_fee' => convertCurrency($request->fee),
            'discount' => convertCurrency($request->discount),
            'total_fee' => convertCurrency($request->fee) - convertCurrency($request->discount),
        ]);
        $this->laboratoryRepository->create($request->except(['_token', 'fee', 'phone_form']));
        Flash::success("Berhasil menginput layanan laboratorium");
        return redirect()->route('services.laboratories.index');
    }

    public function show($id)
    {
        $data = $this->laboratoryRepository->findById($id);
        return view('services.laboratories.show', compact('data'));
    }

    public function edit($id)
    {
        $patients = $this->patientRepository->getPatients();
        $medics = $this->medicRepository->getMedics();
        $data = $this->laboratoryRepository->findById($id);
        return view('services.laboratories.edit', compact('patients', 'medics', 'data'));
    }

    public function update(UpdateLaboratoryServiceRequest $request, $id)
    {
        $request->merge([
            'phone' => $request->phone_form,
            'service_fee' => convertCurrency($request->fee),
            'discount' => convertCurrency($request->discount),
            'total_fee' => convertCurrency($request->fee) - convertCurrency($request->discount),
        ]);
        $this->laboratoryRepository->update($request->except(['_token', 'fee', 'phone_form']), $id);
        Flash::success("Berhasil mengubah data layanan laboratorium");
        return redirect()->route('services.laboratories.index');
    }

    public function destroy($id)
    {
        $general = $this->laboratoryRepository->findById($id);
        $general->delete();
        if (!auth()->user()->hasRole('owner')) addNotification("melakukan penghapusan data layanan laboratorium : " . $general->service_number);
        return $this->sendSuccess("Berhasil menghapus data layanan laboratorium");
    }

    public function print($id)
    {
        $data = $this->laboratoryRepository->findById($id);
        return view('services.laboratories.print', compact('data'));
    }
}
