@extends('layouts.app')
@section('title')
Pengguna
@endsection
@section('page_css')
<link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="container-fluid">
    <div class="animated fadeIn">
        {{-- <div class="page-header">
            <h3 class="page__heading">Pengguna</h3>
            <div class="flex-end-sm">
                <a href="{{ route('users.create') }}" class="btn btn-primary">Tambah Pengguna</a>
    </div>
</div> --}}
<div class="row">
    <div class="col-md-12">
        @include('flash::message')
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                @include('users.table')
            </div>
        </div>
    </div>
</div>
</div>
@include('users.templates.templates')
</div>
@endsection
@section('page_scripts')
<script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ mix('assets/js/custom/custom-datatable.js') }}"></script>
@endsection
@section('scripts')
<script>
    let usersUrl = "{{ url('users') }}";
</script>
<script src="{{ mix('assets/js/users/users.js') }}"></script>
<script src="{{ mix('assets/js/custom/delete.js') }}"></script>
@endsection