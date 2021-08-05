@extends('layouts.app')
@section('title')
Data Penjualan
@endsection

@section('page_css')
<link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="page-header">
            <b>Tabel Data Penjualan</b>

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
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="start">Dari Tanggal <span class="required"></span></label>
                                            <input type="date" class="form-control" id="start"
                                                value="{{ date('Y-m-d') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="start">Hingga Tanggal <span class="required"></span></label>
                                            <input type="date" class="form-control" id="end"
                                                value="{{ date('Y-m-d') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="button" id="btn-filter" class="btn btn-lightgreen mt-4">
                                            Cek Mutasi</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @include('sales.datas.table')
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('sales.datas.templates.templates')
</div>
@endsection

@section('page_scripts')
<script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ mix('assets/js/custom/custom-datatable.js') }}"></script>
@endsection

@section('scripts')
<script>
    let saleUrl = "{{url('sales/data')}}"
</script>
<script src="{{ mix('assets/js/sales/datas/datas.js') }}"></script>
<script src="{{ mix('assets/js/custom/delete.js') }}"></script>
@endsection