<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMedicRequest;
use App\Http\Requests\UpdateMedicRequest;
use App\Models\Medic;
use App\Models\Service;
use App\Models\Services\FamilyPlanning;
use App\Models\Services\General;
use App\Models\Services\Laboratory;
use App\Models\Services\Pregnancy;
use App\Queries\MedicDataTable;
use App\Repositories\MedicRepository;
use Illuminate\Http\Request;
use DataTables;
use Flash;

class MedicController extends AppBaseController
{
    protected $medicRepository;
    public function __construct(MedicRepository $medicRepository)
    {
        $this->medicRepository = $medicRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of((new MedicDataTable())->get())->addIndexColumn()->make(true);
        }
        return view('medics.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bloodGroup  = getBloodGroups();
        return view('medics.create', compact('bloodGroup'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateMedicRequest $request)
    {
        $input = $request->all();

        $this->medicRepository->store($input);
        Flash::success('Berhasil menyimpan data dokter baru.');

        return redirect(route('medics.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->medicRepository->getMedicAssociatedData($id);
        $patients = $this->medicRepository->getPatients($id);
        return view('medics.show', compact('data', 'patients'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $medic = $this->medicRepository->getMedic($id);
        $bloodGroup  = getBloodGroups();

        return view('medics.edit', compact('medic', 'bloodGroup'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMedicRequest $request, $id)
    {
        $input = $request->all();

        $this->medicRepository->update($input, $id);

        Flash::success('Berhasil mengubah data dokter.');

        return redirect(route('medics.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $medicModels = [
            General::class,
            FamilyPlanning::class,
            Laboratory::class,
            Pregnancy::class
        ];
        $result = canDelete($medicModels, 'medic_id', $id);
        if ($result) {
            return $this->sendError('Doctor can\'t be deleted.');
        } else {
            $medic = $this->medicRepository->getMedic($id);
            if (!auth()->user()->hasRole('owner')) addNotification("melakukan penghapusan data dokter : " . $medic->name);
            $medic->delete();
            return $this->sendSuccess('Berhasil menghapus data dokter.');
        }
    }
}
