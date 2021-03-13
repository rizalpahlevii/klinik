@extends('layouts.app')
@section('title')
Detail Supplier
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
                <a href="{{ url()->previous() }}" class="btn btn-primary pull-right">{{ 'Kembali' }}</a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Detail Supplier</strong>
                    </div>
                    <input type="hidden" id="supplier_id" value="{{ $supplier->id }}">
                    <div class="card-body">
                        @include('suppliers.show_fields')
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
@endsection

@section('scripts')
<script>
    let salesmanUrl = "{{url('suppliers/')}}"+'/'+$('#supplier_id').val();
</script>
<script src="{{ mix('assets/js/suppliers/suppliers_data_listing.js') }}"></script>
<script src="{{ mix('assets/js/custom/delete.js') }}"></script>
@endsection
