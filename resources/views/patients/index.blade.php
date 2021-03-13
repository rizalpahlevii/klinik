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
        @include('flash::message')
        <div class="page-header">
            <h3 class="page__heading">Pasien</h3>
            <div class="filter-container">

                <div class="mr-0 actions-btn">
                    <div class="btn-group" role="group">
                        <button id="patientActions" type="button" class="btn btn-primary dropdown-toggle"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions
                        </button>
                        <div class="dropdown-menu" aria-labelledby="patientActions" x-placement="bottom-start">
                            <a href="{{ route('patients.create') }}" class="dropdown-item">
                                Input Pasien
                            </a>
                        </div>
                    </div>
                </div>
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
