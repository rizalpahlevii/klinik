@extends('layouts.app')
@section('title')
Jabatan
@endsection
@section('page_css')
<link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="container-fluid">
    <div class="animated fadeIn">
        @include('flash::message')
        <div class="page-header">
            <h3 class="page__heading">Jabatan</h3>
            <div class="flex-end-sm">
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Tambah Jabatan</a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        @include('roles.table')
                    </div>
                    @include('roles.modal')
                    @include('roles.edit_modal')
                </div>
            </div>
        </div>
    </div>
    @include('roles.templates.templates')
</div>
@endsection
@section('page_scripts')
<script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ mix('assets/js/custom/custom-datatable.js') }}"></script>
@endsection
@section('scripts')
<script>
    let roleCreateUrl = "{{ route('roles.store') }}";
        let rolesUrl = "{{ url('roles') }}";
</script>
<script src="{{ mix('assets/js/roles/roles.js') }}"></script>
<script src="{{ mix('assets/js/custom/delete.js') }}"></script>
@endsection
