@extends('layouts.app')
@section('title')
Daftar Kategori Obat
@endsection
@section('page_css')
<link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="container-fluid">
    <div class="animated fadeIn">
        @include('flash::message')
        <div class="page-header">
            <h3 class="page__heading">Daftar Kategori Obat</h3>
            <div class="flex-end-sm">
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Tambah Kategori</a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        @include('product_categories.table')
                    </div>
                    @include('product_categories.modal')
                    @include('product_categories.edit_modal')
                </div>
            </div>
        </div>
    </div>
    @include('product_categories.templates.templates')
</div>
@endsection
@section('page_scripts')
<script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ mix('assets/js/custom/custom-datatable.js') }}"></script>
@endsection
@section('scripts')
<script>
    let categoryCreateUrl = "{{ route('categories.store') }}";
        let categoriesUrl = "{{ url('categories') }}";
</script>
<script src="{{ mix('assets/js/product_categories/product_categories.js') }}"></script>
<script src="{{ mix('assets/js/custom/delete.js') }}"></script>
@endsection
