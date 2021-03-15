<?php

namespace App\Http\Controllers;

use App\Exports\PatientExport;
use App\Http\Requests\CreatePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Models\Patient;
use App\Models\Service;
use App\Queries\PatientDataTable;
use App\Repositories\PatientRepository;
use DataTables;
use Exception;
use Flash;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PatientController extends AppBaseController
{
    /** @var  PatientRepository */
    private $patientRepository;

    public function __construct(PatientRepository $patientRepo)
    {
        $this->patientRepository = $patientRepo;
    }

    /**
     * Display a listing of the Patient.
     *
     * @param  Request  $request
     *
     * @throws Exception
     *
     * @return Factory|View
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            return Datatables::of((new PatientDataTable())->get())->addIndexColumn()->make(true);
        }

        return view('patients.index');
    }

    /**
     * Show the form for creating a new Patient.
     *
     * @return Factory|View
     */
    public function create()
    {
        $bloodGroup = getBloodGroups();

        return view('patients.create', compact('bloodGroup'));
    }

    /**
     * Store a newly created Patient in storage.
     *
     * @param  CreatePatientRequest  $request
     *
     * @return RedirectResponse|Redirector
     */
    public function store(CreatePatientRequest $request)
    {
        $input = $request->all();

        $this->patientRepository->store($input);
        Flash::success('Patient saved successfully.');

        return redirect(route('patients.index'));
    }


    /**
     * @param  int  $patientId
     *
     * @return Factory|RedirectResponse|Redirector|View
     */
    public function show($patientId)
    {
        $data = $this->patientRepository->getPatientAssociatedData($patientId);
        return view('patients.show', compact('data'));
    }

    /**
     * Show the form for editing the specified Patient.
     *
     * @param  Patient  $patient
     *
     * @return Factory|View
     */
    public function edit($id)
    {
        $patient = $this->patientRepository->getPatient($id);
        $bloodGroup = getBloodGroups();

        return view('patients.edit', compact('patient', 'bloodGroup'));
    }

    /**
     * @param  Patient  $patient
     * @param  UpdatePatientRequest  $request
     *
     * @return RedirectResponse|Redirector
     */
    public function update(UpdatePatientRequest $request, $id)
    {
        $input = $request->all();

        $this->patientRepository->update($input, $id);

        Flash::success('Patient updated successfully.');

        return redirect(route('patients.index'));
    }

    /**
     * Remove the specified Patient from storage.
     *
     * @param  Patient  $patient
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $patientModels = [
            Service::class
        ];
        $result = canDelete($patientModels, 'patient_id', $id);
        if ($result) {
            return $this->sendError('Patient can\'t be deleted.');
        } else {

            $patient = $this->patientRepository->getPatient($id);
            if (!auth()->user()->hasRole('owner')) addNotification("melakukan penghapusan data pasien : " . $patient->name);

            $patient->delete();
            return $this->sendSuccess('Patient deleted successfully.');
        }
    }

    /**
     * @param  int  $id
     *
     * @return JsonResponse
     */
    public function activeDeactiveStatus($id)
    {
        $patient = Patient::findOrFail($id);
        $status = !$patient->user->status;
        $patient->user()->update(['status' => $status]);

        return $this->sendSuccess('Status updated successfully.');
    }

    /**
     * @return BinaryFileResponse
     */
    public function patientExport()
    {
        return Excel::download(new PatientExport, 'patients-' . time() . '.xlsx');
    }
}
