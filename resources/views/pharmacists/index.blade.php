@extends('layouts.app')
@section('title')
    {{__('messages.pharmacist.pharmacists')}}
@endsection

@section('page_css')
    <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            @include('flash::message')
            <div class="page-header">
                <h3 class="page__heading">{{__('messages.pharmacist.pharmacists')}}</h3>
                <div class="filter-container">
                    <div class="mr-2">
                        <label for="filter_status" class="lbl-block"><b>{{ __('messages.common.status') }}</b></label>
                        {{Form::select('status', $statusArr, null, ['id' => 'filter_status', 'class' => 'form-control status-filter']) }}
                    </div>
                    <div class="mr-0 actions-btn">
                        <div class="btn-group" role="group">
                            <button id="pharmacistsActions" type="button" class="btn btn-primary dropdown-toggle"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions
                            </button>
                            <div class="dropdown-menu" aria-labelledby="pharmacistsActions" x-placement="bottom-start">
                                <a href="{{ route('pharmacists.create') }}" class="dropdown-item">
                                    {{ __('messages.pharmacist.new_pharmacist') }}
                                </a>
                                <a href="{{ route('pharmacists.excel') }}" class="dropdown-item">
                                    {{ __('messages.common.export_to_excel') }}
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
                            @include('pharmacists.table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('pharmacists.templates.templates')
    </div>
@endsection

@section('page_scripts')
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ mix('assets/js/custom/custom-datatable.js') }}"></script>
@endsection

@section('scripts')
    <script>
        let pharmacistUrl = "{{url('pharmacists')}}";
    </script>
    <script src="{{ mix('assets/js/pharmacists/pharmacists.js') }}"></script>
    <script src="{{ mix('assets/js/custom/delete.js') }}"></script>
@endsection
