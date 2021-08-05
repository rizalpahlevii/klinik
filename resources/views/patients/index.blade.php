@extends('layouts.app')
@section('title')
Pasien
@endsection

@section('page_css')
<link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="container-fluid">
    <div class="animated fadeIn">


        <div class="row">
            <div class="col-md-12">
                @include('flash::message')
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        @include('patients.table')
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('patients.templates.templates')
</div>
@endsection

@section('page_scripts')
<script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ mix('assets/js/custom/custom-datatable.js') }}"></script>
@endsection

@section('scripts')
<script>
    let patientUrl = "{{url('patients')}}"
</script>
<script src="{{ mix('assets/js/patients/patients.js') }}"></script>
<script src="{{ mix('assets/js/custom/delete.js') }}"></script>
@endsection