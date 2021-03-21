<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePregnancyServiceRequest;
use App\Http\Requests\UpdatePregnancyServiceRequest;
use App\Queries\Services\PregnancyDataTable;
use App\Repositories\MedicRepository;
use App\Repositories\PatientRepository;
use App\Repositories\Services\PregnancyRepository;
use Flash;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PregnancyServiceController extends AppBaseController
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
            return DataTables::of((new PregnancyDataTable())->get())
                ->addIndexColumn()
                ->editColumn('total_fee', function ($row) {
                    return convertToRupiah($row->total_fee, 'Rp. ');
                })->make(true);
        }
        return view('services.pregnancies.index');
    }

    public function create()
    {
        $patients = $this->patientRepository->getPatients();
        $medics = $this->medicRepository->getMedics();
        return view('services.pregnancies.create', compact('patients', 'medics'));
    }

    public function store(CreatePregnancyServiceRequest $request)
    {
        $request->merge([
            'phone' => $request->phone_form,
            'service_fee' => convertCurrency($request->fee),
            'discount' => convertCurrency($request->discount),
            'total_fee' => convertCurrency($request->fee) - convertCurrency($request->discount),
        ]);
        $this->pregnancyRepository->create($request->except(['_token', 'fee', 'phone_form']));
        Flash::success("Berhasil menginput layanan umum");
        return redirect()->route('services.pregnancies.index');
    }

    public function show($id)
    {
        $data = $this->pregnancyRepository->findById($id);
        return view('services.pregnancies.show', compact('data'));
    }

    public function edit($id)
    {
        $patients = $this->patientRepository->getPatients();
        $medics = $this->medicRepository->getMedics();
        $data = $this->pregnancyRepository->findById($id);
        return view('services.pregnancies.edit', compact('patients', 'medics', 'data'));
    }

    public function update(UpdatePregnancyServiceRequest $request, $id)
    {
        $request->merge([
            'phone' => $request->phone_form,
            'service_fee' => convertCurrency($request->fee),
            'discount' => convertCurrency($request->discount),
            'total_fee' => convertCurrency($request->fee) - convertCurrency($request->discount),
        ]);
        $this->pregnancyRepository->update($request->except(['_token', 'fee', 'phone_form']), $id);
        Flash::success("Berhasil mengubah data layanan umum");
        return redirect()->route('services.pregnancies.index');
    }

    public function destroy($id)
    {
        $general = $this->pregnancyRepository->findById($id);
        $general->delete();
        if (!auth()->user()->hasRole('owner')) addNotification("melakukan penghapusan data layanan umum : " . $general->service_number);
        return $this->sendSuccess("Berhasil menghapus data layanan umum");
    }

    public function print($id)
    {
        $data = $this->pregnancyRepository->findById($id);
        return view('services.pregnancies.print', compact('data'));
    }
}
