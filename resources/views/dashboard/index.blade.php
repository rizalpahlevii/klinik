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
                                            {{ $shift->cashier->fullname }}
                                            @else
                                            '-'
                                            @endif
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Nama Kasir Sebelumnya</th>
                                        <th>:</th>
                                        <th>{{ $previousShift != null ? $previousShift->cashier->fullname : '-'  }}
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Kas Awal</th>
                                        <th>:</th>
                                        <th>
                                            @if ($shift)
                                            @rupiah($shift->initial_cash)
                                            @else
                                            -
                                            @endif
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Total Penjualan</th>
                                        <th>:</th>
                                        <th>
                                            @if ($shift)
                                            @rupiah( $totalSales )
                                            @else
                                            -
                                            @endif
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Kas Sekarang</th>
                                        <th>:</th>
                                        <th>
                                            @if ($shift)
                                            @rupiah($finalCash )
                                            @else
                                            -
                                            @endif
                                        </th>
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
    <div id="addModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">

                <form action="{{ route('transfer') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="alert alert-danger display-none" id="validationErrorsBox"></div>
                        <div class="row">
                            <div class="form-group col-sm-12">
                                <label for="amount">Nominal Setor</label>
                                <input type="text" class="form-control" name="amount" id="amount" required>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="transfer_prrof">Bukti Transfer (Opsional)</label>
                                    <input type="file" class="form-control" name="transfer_prrof" id="transfer_prrof">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <h5>
                                    Apakah Anda Yakin Ingin Menyetorkan Uang Sejumlah <i id="show-amount">0</i>
                                </h5>
                            </div>
                        </div>
                        <div class="text-right">
                            {{ Form::button(__('Simpan'), ['type'=>'submit','class' => 'btn btn-primary','id'=>'btnSave','data-loading-text'=>"<span class='spinner-border spinner-border-sm'></span> Processing..."]) }}
                            <button type="button" class="btn btn-light ml-1"
                                data-dismiss="modal">{{ __('Batal') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @else
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
                        <form action="{{ route('cash_add') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <h4>Penanmbahan Kas Awal</h4>
                                    <div class="from-group">
                                        <label for="amount">Total Penambahan Kas</label>
                                        <input type="text" class="form-control" name="amount" id="amount">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary">Simpan Penambahan</button>
                                </div>
                            </div>
                        </form>

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
           $('#addModal').modal('show');
        });
        $('#amount').keyup(function(){
            value = String($(this).val());
            $('#show-amount').html(formatRupiah(value));
            $(this).val(formatRupiah(value));
        });
        function formatRupiah(angka,prefix){
            if(angka == 0 ){
                return "Rp. 0";
            }else{

                var numberString = angka.replace(/[^,\d]/g, '').toString(),
                split   		= numberString.split(','),
                sisa     		= split[0].length % 3,
                rupiah     		= split[0].substr(0, sisa),
                ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

                if(ribuan){
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }
                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                return 'Rp. '+ rupiah;
            }
        }
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
