<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGeneralServiceRequest;
use App\Http\Requests\UpdateGeneralServiceRequest;
use App\Queries\Services\GeneralDataTable;
use App\Repositories\Services\GeneralRepository;
use App\Repositories\MedicRepository;
use App\Repositories\PatientRepository;
use Flash;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class GeneralServiceController extends AppBaseController
{
    protected $generalRepository;
    protected $patientRepository;
    protected $medicRepository;
    public function __construct(GeneralRepository $generalRepository, PatientRepository $patientRepository, MedicRepository $medicRepository)
    {
        $this->medicRepository = $medicRepository;
        $this->patientRepository = $patientRepository;
        $this->generalRepository = $generalRepository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of((new GeneralDataTable())->get())
                ->addIndexColumn()
                ->editColumn('total_fee', function ($row) {
                    return convertToRupiah($row->total_fee, 'Rp. ');
                })->make(true);
        }
        return view('services.generals.index');
    }

    public function create()
    {
        $patients = $this->patientRepository->getPatients();
        $medics = $this->medicRepository->getMedics();
        return view('services.generals.create', compact('patients', 'medics'));
    }

    public function store(CreateGeneralServiceRequest $request)
    {
        $request->merge([
            'phone' => $request->phone_form,
            'service_fee' => convertCurrency($request->fee),
            'discount' => convertCurrency($request->discount),
            'total_fee' => convertCurrency($request->fee) - convertCurrency($request->discount),
        ]);
        $this->generalRepository->create($request->except(['_token', 'fee', 'phone_form']));
        Flash::success("Berhasil menginput layanan umum");
        return redirect()->route('services.generals.index');
    }

    public function show($id)
    {
        $data = $this->generalRepository->findById($id);
        return view('services.generals.show', compact('data'));
    }

    public function edit($id)
    {
        $patients = $this->patientRepository->getPatients();
        $medics = $this->medicRepository->getMedics();
        $data = $this->generalRepository->findById($id);
        return view('services.generals.edit', compact('patients', 'medics', 'data'));
    }

    public function update(UpdateGeneralServiceRequest $request, $id)
    {
        $request->merge([
            'phone' => $request->phone_form,
            'service_fee' => convertCurrency($request->fee),
            'discount' => convertCurrency($request->discount),
            'total_fee' => convertCurrency($request->fee) - convertCurrency($request->discount),
        ]);
        $this->generalRepository->update($request->except(['_token', 'fee', 'phone_form']), $id);
        Flash::success("Berhasil mengubah data layanan umum");
        return redirect()->route('services.generals.index');
    }

    public function destroy($id)
    {
        $general = $this->generalRepository->findById($id);
        $general->delete();
        if (!auth()->user()->hasRole('owner')) addNotification("melakukan penghapusan data layanan umum : " . $general->service_number);
        return $this->sendSuccess("Berhasil menghapus data layanan umum");
    }

    public function print($id)
    {
        $data = $this->generalRepository->findById($id);
        return view('services.generals.print', compact('data'));
    }
}
