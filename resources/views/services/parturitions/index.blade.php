@extends('layouts.app')
@section('title')
Daftar Layanan Partus
@endsection

@section('page_css')
<link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="page-header">
            <h3 class="page__heading">Daftar Layanan Partus</h3>
            <div class="filter-container">

                @if (auth()->user()->hasRole(['owner','cashier']))
                @if (getShift())

                <div class="mr-0 actions-btn">
                    <a href="{{ route('services.parturitions.create') }}" class="btn btn-primary">Layanan Baru</a>
    </div>
    @endif
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
                @include('services.parturitions.table')
            </div>
        </div>
    </div>
</div>
</div>
@include('services.parturitions.templates.templates')
</div>
@endsection

@section('page_scripts')
<script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ mix('assets/js/custom/custom-datatable.js') }}"></script>
@endsection

@section('scripts')
<script>
    let parturitionUrl = "{{url('services/parturitions')}}";
    let patientUrl = "{{ url('patients') }}";
    let medicUrl = "{{ url('medics') }}";
</script>
<script src="{{ mix('assets/js/services/parturitions/parturitions.js') }}"></script>
<script src="{{ mix('assets/js/custom/delete.js') }}"></script>
@endsection