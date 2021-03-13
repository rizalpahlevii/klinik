@extends('layouts.app')
@section('title')
{{ __('messages.dashboard.dashboard') }}
@endsection
@section('page_css')
<link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/daterangepicker.css') }}">
@endsection
@section('content')
<div class="container-fluid">

</div>
@endsection
@section('page_scripts')
<script src="{{ asset('assets/js/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/chart.min.js') }}"></script>
<script src="{{ asset('assets/js/daterangepicker.js') }}"></script>
@endsection
@section('scripts')
{{-- <script>
    let incomeExpenseReportUrl = "{{route('income-expense-report')}}";
let currentCurrencyName = "{{ getCurrencySymbol()}}";
let curencies = JSON.parse('@json($data['currency'])');
</script>
<script src="{{mix('assets/js/dashboard/dashboard.js')}}"></script>
<script src="{{mix('assets/js/custom/input_price_format.js')}}"></script> --}}

@endsection
