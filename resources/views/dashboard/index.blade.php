@extends('layouts.app')
@section('title')
{{ __('messages.dashboard.dashboard') }}
@endsection
@section('page_css')
<link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/daterangepicker.css') }}">
<link rel="stylesheet" href="{{ asset('css/toggle.css') }}">
@endsection
@section('content')
<div class="container-fluid">
    @if (in_array('kasir',auth()->user()->roles()->pluck('name')->toArray()))
    <div class="animated fadeIn">
        <div class="row mt-3">
            <div class="col-md-12">
                @include('flash::message')
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                @if ($shift != null)

                                <input type="checkbox" data-on="Aktif" data-off="Tidak Aktif" checked
                                    data-toggle="toggle" data-onstyle="primary" id="shift-toggle" data-status="active">

                                @else
                                <input type="checkbox" data-on="Aktif" data-off="Tidak Aktif" data-toggle="toggle"
                                    data-onstyle="primary" id="shift-toggle" data-status="not_have_shift">
                                @endif

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <table style="width: 100%">
                                    <tr>
                                        <th style="width: 50%">Nama Kasir</th>
                                        <th>:</th>
                                        <th style="width: 45%">
                                            @if ($shift)
                                            {{ $shift->user->fullname }}
                                            @else
                                            '-'
                                            @endif
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Nama Kasir Sebelumnya</th>
                                        <th>:</th>
                                        <th>{{ $shift->previous_cashier_name ?? '-' }}</th>
                                    </tr>
                                    <tr>
                                        <th>Kas Awal</th>
                                        <th>:</th>
                                        <th>@rupiah($shift->initial_cash ?? '0')</th>
                                    </tr>
                                    <tr>
                                        <th>Total Penjualan</th>
                                        <th>:</th>
                                        <th>@rupiah($shift->total_sales ?? '0')</th>
                                    </tr>
                                    <tr>
                                        <th>Kas Sekarang</th>
                                        <th>:</th>
                                        <th>@rupiah($shift->cash_now ?? '0')</th>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table style="width: 100%">
                                    <tr>
                                        <th style="width: 50%">Start Shift</th>
                                        <th>:</th>
                                        <th style="width: 45%">
                                            @if ($shift)
                                            {{ \Carbon\Carbon::parse($shift->start_shift)->isoFormat('LLLL') }}
                                            @else
                                            @php
                                            '-'
                                            @endphp
                                            @endif
                                        </th>
                                    </tr>
                                    <tr>
                                        <th style="width: 50%">Akhir Shift</th>
                                        <th>:</th>
                                        <th style="width: 45%">
                                            @if ($shift)
                                            {{ $shift->previous_end_shift != NULL ? \Carbon\Carbon::parse($shift->previous_end_shift)->isoFormat('LLLL') : '-' }}
                                            @else
                                            @php
                                            '-'
                                            @endphp
                                            @endif

                                        </th>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        @if ($shift)

                        <div class="row mt-2">
                            <div class="col-md-12">
                                <button class="btn btn-block btn-primary btn-setor"><b>Setor Uang</b></button>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
@section('page_scripts')
<script src="{{ asset('assets/js/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/chart.min.js') }}"></script>
<script src="{{ asset('assets/js/daterangepicker.js') }}"></script>
<script src="{{ asset('js/toggle.js') }}"></script>
<script>
    $(function(){

        $('.btn-setor').click(function(){
            confirm = confirm('Yakin ingin mengakhiri shift dan menyetor uang ? ')
                if(confirm){
                    $.ajax({
                        url :   `{{ route('shift') }}` ,
                        method :'post',
                        dataType : 'json',
                        success:function(response){
                            if(response.status){
                                alert(response.message);
                            }
                            location.reload();
                        }
                    })
                }
        });

        $('#shift-toggle').change(function(){
            checkedStatus = $(this).prop("checked");
            shiftStatus = $(this).data('status');
            if(checkedStatus){
                confirm = confirm('Yakin Ingin Memulai Shift ? ');
                if(confirm){
                    $.ajax({
                        url :   `{{ route('shift') }}` ,
                        method :'post',
                        dataType : 'json',
                        success:function(response){
                            if(response.status){
                                alert(response.message);
                            }
                            location.reload();
                        }
                    })
                }
            }else{
                confirm = confirm('Yakin ingin mengakhiri shift dan menyetor uang ? ')
                if(confirm){
                    $.ajax({
                        url :   `{{ route('shift') }}` ,
                        method :'post',
                        dataType : 'json',
                        success:function(response){
                            if(response.status){
                                alert(response.message);
                            }
                            location.reload();
                        }
                    })
                }
            }
        });
    });

</script>
@endsection
