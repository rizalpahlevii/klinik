@extends('layouts.app')
@section('title')
Shift Log
@endsection
@section('page_css')
<link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="container-fluid">
    <div class="animated fadeIn">
        @include('flash::message')
        <div class="page-header">
            <h3 class="page__heading">Shift Log</h3>

        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="stock-adjusment-datatable" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Kasir</th>
                                        <th>Start Shift</th>
                                        <th>Akhir Shift</th>
                                        <th>Kas Awal</th>
                                        <th>Total Penjualan</th>
                                        <th>Penambahan Kas</th>
                                        <th>Kas Akhir</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($shifts as $shift)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $shift->cashier->fullname }}</td>
                                        <td>{{ $shift->start_shift }}</td>
                                        <td>{{ $shift->end_shift }}</td>
                                        <td>{{ convertToRupiah($shift->initial_cash,'Rp. ') }}</td>
                                        <td>{{ convertToRupiah($shift->shift_sales_total,'Rp. ') }}</td>
                                        <td>{{ convertToRupiah($shift->cashAdds()->sum('total_add'),'Rp. ') }}</td>
                                        <td>{{ convertToRupiah($shift->final_cash,'Rp. ') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


@endsection
@section('page_scripts')
<script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ mix('assets/js/custom/custom-datatable.js') }}"></script>
@endsection
@section('scripts')
<script>
    $('#stock-adjusment-datatable').dataTable();

</script>
@endsection
