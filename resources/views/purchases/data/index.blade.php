@extends('layouts.app')
@section('title')
Data Pembelian
@endsection

@section('page_css')
<link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="page-header">
            <h3 class="page__heading">Data Pembelian</h3>
            <div class="filter-container">
                @if (session()->has('newurl'))
                <input type="hidden" value="{{ session()->get('newurl') }}" name="newurl" id="newurl">
                @else
                <input type="hidden" value="no" name="newurl" id="newurl">
                @endif

                <div class="mr-0 actions-btn">
                    <a href="{{ route('purchases.create') }}" class="btn btn-primary">
                        Input Faktur
                    </a>
                </div>
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
                                        <button type="button" id="btn-filter" class="btn btn-success mt-4">
                                            Cek Mutasi</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @include('purchases.data.table')
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('purchases.data.templates.templates')
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
    let purchaseUrl = "{{url('purchases/')}}"
    let supplierUrl = "{{url('suppliers/')}}"
</script>
@if (auth()->user()->hasRole('owner'))
<script src="{{ mix('assets/js/purchases/purchases.js') }}"></script>
@else
<script src="{{ mix('assets/js/purchases/purchases-could-edit.js') }}"></script>
@endif

<script src="{{ mix('assets/js/custom/delete.js') }}"></script>
@endsection
