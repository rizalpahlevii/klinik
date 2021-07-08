<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSpendingRequest;
use App\Queries\SpendingDataTable;
use App\Repositories\SpendingRepository;
use Auth;
use Barryvdh\Debugbar\Controllers\BaseController;
use Exception;
use Flash;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SpendingController extends AppBaseController
{
    protected $spendingRepository;
    public function __construct(SpendingRepository $spendingRepository)
    {
        $this->spendingRepository = $spendingRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of((new SpendingDataTable())->get())
                ->addIndexColumn()
                ->addColumn('amount', function ($row) {
                    return convertToRupiah($row->amount, "Rp.");
                })
                ->addColumn('date', function ($row) {
                    return $row->created_at->format('Y-m-d H:i:s');
                })
                ->addColumn('type', function ($row) {
                    if ($row->type == "salary") {
                        return "Gaji";
                    }
                    if ($row->type == "office_supplies") {
                        return "Keperluan Kantor";
                    }
                    if ($row->type == "operational") {
                        return "Operasional";
                    }
                    if ($row->type == "non_operational") {
                        return "Non Operasional";
                    }
                })
                ->filter(function ($query) use ($request) {
                    if ($request->has('start_date') && $request->has('end_date')) {
                        $query->whereDate('created_at', '>=', $request->start_date)->whereDate('created_at', '<=', $request->end_date);
                    }
                    if ($request->has('type')) {
                        if ($request->type != "all") {
                            $query->where('type', $request->type);
                        }
                    }
                })->make(true);
        }

        return view('spendings.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!getShift()) abort(403);
        return view('spendings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateSpendingRequest $request)
    {
        if (!getShift()) abort(403);
        try {
            $request->merge(['amount' => convertCurrency($request->amount)]);
            if (Auth::user()->hasRole('cashier')) {
                if ($request->amount > 200000) {
                    throw new Exception("Jumlah pengeluaran melebihi batas");
                }
            }
            $request->merge(['cashier_shift_id' => getShift()->id]);

            $this->spendingRepository->create($request->except(['_token']));
            Flash::success("Berhasil menyimpan pengeluaran");
        } catch (\Exception $th) {
            Flash::error($th->getMessage());
        }
        return redirect()->route('spendings.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!getShift()) abort(403);
        $spending = $this->spendingRepository->findById($id);
        $amount = intval($spending->amount);
        return view('spendings.edit', compact('spending', 'amount'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!getShift()) abort(403);
        try {
            $request->merge(['amount' => convertCurrency($request->amount)]);
            if (Auth::user()->hasRole('cashier')) {
                if ($request->amount > 200000) {
                    throw new Exception("Jumlah pengeluaran melebihi batas");
                }
            }
            $this->spendingRepository->update($request->except(['_token']), $id);
            Flash::success("Berhasil menyimpan pengeluaran");
        } catch (\Exception $th) {
            Flash::error($th->getMessage());
        }
        return redirect()->route('spendings.index'); //
    }

    public function print($id)
    {
        $spending = $this->spendingRepository->findById($id);
        return view('spendings.print', compact('spending'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
