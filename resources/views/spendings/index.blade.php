@extends('layouts.app')
@section('title')
Data Pengeluaran
@endsection

@section('page_css')
<link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="page-header">

            <div class="filter-container">
                @if (session()->has('newurl'))
                <input type="hidden" value="{{ session()->get('newurl') }}" name="newurl" id="newurl">
                @else
                <input type="hidden" value="no" name="newurl" id="newurl">
                @endif

                @if (getShift())
                <div class="mr-0 actions-btn">
                    <a href="{{ route('spendings.create') }}" class="btn btn-primary">
                        Input Pengeluaran
                    </a>
                </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @include('flash::message')
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-12">
                                <b class="page__heading">Tabel Pembelian</b>
                                <div class="row mt-3">

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="start">Dari Tanggal <span class="required"></span></label>
                                            <input type="date" class="form-control" id="start"
                                                value="{{ Carbon\Carbon::now()->startOfMonth()->format('Y-m-d') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="start">Hingga Tanggal <span class="required"></span></label>
                                            <input type="date" class="form-control" id="end"
                                                value="{{ Carbon\Carbon::now()->format('Y-m-d') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="type">Jenis Pengeluaran <span class="required"></span></label>
                                            <select name="type" id="type" class="form-control">
                                                <option value="">Semua</option>
                                                <option value="salary">Gaji</option>
                                                <option value="office_supplies">Keperluan Kantor</option>
                                                <option value="operational">Operasional</option>
                                                <option value="non_operational">Non Operasional</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <button type="button" id="btn-filter" class="btn btn-primary mt-4">
                                            Cek Mutasi</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4 mb-2">
                            <div class="col-12">
                                <b>Jenis Pengeluaran</b>

                            </div>

                        </div>
                        @include('spendings.table')
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('spendings.templates.templates')
</div>
@endsection

@section('page_scripts')
<script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ mix('assets/js/custom/custom-datatable.js') }}"></script>
@endsection

@section('scripts')
<script>
    $(document).ready(function(){
        newurl = $('#newurl').val()
        if(newurl!="no"){
            window.open(newurl);
        }
    })
    let spendingUrl = "{{url('spendings/')}}"
</script>

<script src="{{ mix('assets/js/spendings/spendings.js') }}"></script>

<script src="{{ mix('assets/js/custom/delete.js') }}"></script>
@endsection
@push('script')
<script>
    // $('.dataTables_length').html(`<div class="d-flex">
    //     <a class="btn btn-type rounded-0 btn-secondary">Semua</a>
    //     <a class="btn btn-type rounded-0 btn-secondary">Gaji</a>
    //     <a class="btn btn-type rounded-0 btn-secondary">Keperluan Kantor</a>
    //     <a class="btn btn-type rounded-0 btn-secondary">Operasional</a>
    //     <a class="btn btn-type rounded-0 btn-secondary">Non Operasional</a>
    // </div>`)
    // $('.btn-type').
</script>
@endpush
