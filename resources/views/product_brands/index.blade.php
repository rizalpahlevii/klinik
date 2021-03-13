@extends('layouts.app')
@section('title')
Merek
@endsection

@section('page_css')
<link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="container-fluid">
    <div class="animated fadeIn">
        @include('flash::message')
        <div class="page-header">
            <h3 class="page__heading">Merek</h3>
            <div class="flex-end-sm">
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Tambah Merek</a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            @include('product_brands.table')
                        </div>
                    </div>
                    @include('product_brands.modal')
                    @include('product_brands.edit_modal')
                </div>
            </div>
        </div>
    </div>
    @include('product_brands.templates.templates')
</div>
@endsection

@section('page_scripts')
<script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ mix('assets/js/custom/custom-datatable.js') }}"></script>
@endsection

@section('scripts')
<script>
    let brandCreateUrl = "{{ route('brands.store') }}";

    let brandsUrl = "{{url('brands')}}"
</script>
<script src="{{ mix('assets/js/product_brands/product_brands.js') }}"></script>
<script src="{{ mix('assets/js/custom/delete.js') }}"></script>
@endsection
