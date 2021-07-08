<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateFamilyPlanningRequest;
use App\Http\Requests\CreateParturitionServiceRequest;
use App\Http\Requests\UpdateFamilyPlanningRequest;
use App\Http\Requests\UpdateParturitionServiceRequest;
use App\Queries\Services\ParturitionDataTable;
use App\Repositories\MedicRepository;
use App\Repositories\PatientRepository;
use App\Repositories\Services\ParturitionRepository;
use Flash;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ParturitionServiceController extends AppBaseController
{
    protected $parturitionRepository;
    protected $patientRepository;
    protected $medicRepository;

    public function __construct(
        ParturitionRepository $parturitionRepository,
        PatientRepository $patientRepository,
        MedicRepository $medicRepository
    ) {
        $this->medicRepository = $medicRepository;
        $this->patientRepository = $patientRepository;
        $this->parturitionRepository = $parturitionRepository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of((new ParturitionDataTable())->get())
                ->addIndexColumn()
                ->editColumn('total_fee', function ($row) {
                    return convertToRupiah($row->total_fee, 'Rp. ');
                })->make(true);
        }
        return view('services.parturitions.index');
    }

    public function create()
    {
        $patients = $this->patientRepository->getPatients();
        $medics = $this->medicRepository->getMedics();
        return view('services.parturitions.create', compact('patients', 'medics'));
    }

    public function store(CreateParturitionServiceRequest $request)
    {
        $request->merge([
            'phone' => $request->phone_form,
            'service_fee' => convertCurrency($request->fee),
            'discount' => convertCurrency($request->discount),
            'total_fee' => convertCurrency($request->fee) - convertCurrency($request->discount),
        ]);
        $this->parturitionRepository->create($request->except(['_token', 'fee', 'phone_form']));
        Flash::success("Berhasil menginput layanan partus");
        return redirect()->route('services.parturitions.index');
    }

    public function show($id)
    {
        $data = $this->parturitionRepository->findById($id);
        return view('services.parturitions.show', compact('data'));
    }

    public function edit($id)
    {
        $patients = $this->patientRepository->getPatients();
        $medics = $this->medicRepository->getMedics();
        $data = $this->parturitionRepository->findById($id);
        return view('services.parturitions.edit', compact('patients', 'medics', 'data'));
    }

    public function update(UpdateParturitionServiceRequest $request, $id)
    {
        $request->merge([
            'phone' => $request->phone_form,
            'service_fee' => convertCurrency($request->fee),
            'discount' => convertCurrency($request->discount),
            'total_fee' => convertCurrency($request->fee) - convertCurrency($request->discount),
        ]);
        $this->parturitionRepository->update($request->except(['_token', 'fee', 'phone_form']), $id);
        Flash::success("Berhasil mengubah data layanan partus");
        return redirect()->route('services.parturitions.index');
    }

    public function destroy($id)
    {
        $general = $this->parturitionRepository->findById($id);
        $general->delete();
        if (!auth()->user()->hasRole('owner')) addNotification("melakukan penghapusan data layanan partus : " . $general->service_number);
        return $this->sendSuccess("Berhasil menghapus data layanan partus");
    }

    public function print($id)
    {
        $data = $this->parturitionRepository->findById($id);
        return view('services.parturitions.print', compact('data'));
    }
}
