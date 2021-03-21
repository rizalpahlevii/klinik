@extends('layouts.app')
@section('title')
Detail Layanan KB
@endsection
@section('page_css')
<link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="container-fluid">
    <div class="animated fadeIn">
        @include('flash::message')
        <div class="d-flex justify-content-end py-2">
            <div>
                <a href="{{ route('services.family_plannings.index') }}"
                    class="btn btn-primary pull-right">{{ 'Kembali' }}</a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Detail Layanan KB : {{ $data->service_number }}</strong>
                    </div>
                    <div class="card-body">
                        @include('services.family_plannings.show_fields')
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
<script src="{{ mix('assets/js/patients/patients_data_listing.js') }}"></script>
@endsection
