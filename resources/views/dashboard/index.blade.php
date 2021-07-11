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
    @if (auth()->user()->hasRole(['owner','cashier']))
    <div class="animated fadeIn">
        <div class="row mt-3">
            <div class="col-md-12">
                @include('flash::message')
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

            </div>
        </div>


        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">

                        <div class="row" style="font-size: 20px;">
                            <div class="col-md-6">
                                <table style="width: 100%;">
                                    <tr>
                                        <th style="width: 50%">Nama Kasir</th>
                                        <th>:</th>
                                        <th style="width: 45%">
                                            @if ($shift)
                                            {{ $shift->cashier->fullname }}
                                            @else
                                            ' -' @endif </th>
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
                                            @rupiah( $previousShift != null ? $previousShift->final_cash : 0 )
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
                                        <th>Pengeluaran</th>
                                        <th>:</th>
                                        <th>
                                            @if ($shift)
                                            @rupiah($spending )
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
                                            @rupiah($finalCash - $spending)
                                            @else
                                            @rupiah( $previousShift != null ? $previousShift->final_cash : 0 )
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
                                            -
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
                                            {{ $previousShift != null ? \Carbon\Carbon::parse($previousShift->end_shift)->isoFormat('LLLL') : '-' }}
                                            @endif

                                        </th>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-4 ">
                                @if ($shift != null)
                                <button class="btn btn-block btn-secondary btn-shift" data-status="aktif"
                                    style="padding: 10px;">Stop Shift</button>


                                @else

                                <button class="btn btn-block btn-primary btn-shift pt-2 pb-2" data-status="nonaktif" {!!
                                    checkAvailableToStartShift() ? '' : 'style="
                                    cursor:no-drop;" ' !!}" {!! checkAvailableToStartShift() ? '' : ' disabled '
                                    !!}>Start</button>

                                @endif
                            </div>
                            @if ($shift != null)
                            @if (checkAvailableToStartShift())
                            <div class="col-md-4">
                                <button class="btn btn-block btn-primary btn-setor">
                                    <b>Setor Uang</b>
                                </button>
                            </div>
                            @endif
                            @endif
                            @if (auth()->user()->hasRole(['owner']))
                            <div class="col-md-4">
                                <button class="btn btn-block btn-primary btn-cash-add">
                                    <b>Input Kas Awal</b>
                                </button>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (auth()->user()->hasRole(['owner']))

    <div class="row">
        <div class="col-md-8">
            <div class="card">

                <div class="card-body">
                    <canvas id="canvas" height="280" width="600">
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="text-center">Top 5 Produk Terlaris</h4>
                    <p class="text-center">(Berdasarkan Omzet)</p>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Omzet</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($highProducts as $highProduct)
                            <tr>
                                <td>{{ $highProduct->name }}</td>
                                <td>@rupiah($highProduct->total)</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <canvas id="general" height="280" width="600">
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <canvas id="family_planning" height="280" width="600">
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <canvas id="pregnancy" height="280" width="600">
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <canvas id="laboratory" height="280" width="600">
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <canvas id="immunization" height="280" width="600">
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <canvas id="parturition" height="280" width="600">
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <canvas id="inpatient" height="280" width="600">
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <canvas id="ekg" height="280" width="600">
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <canvas id="administration" height="280" width="600">
                </div>
            </div>
        </div>


    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5>Laporan Perbulan</h5>
                    <p>Generate Laporan Bulanan</p>
                    <div class="row">
                        <div class="col-md-2">
                            <select name="month_start" id="month_start" class="form-control">
                                <option value="01">Januari</option>
                                <option value="02">Februari</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                                <option value="07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>
                        <div class="col-md-2">

                            <select name="year_start" id="year_start" class="form-control">
                                @foreach (getYears() as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                        -
                        <div class="col-md-2">
                            <select name="month_end" id="month_end" class="form-control">
                                <option value="01">Januari</option>
                                <option value="02">Februari</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                                <option value="07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>

                        </div>
                        <div class="col-md-2">
                            <select name="year_end" id="year_end" class="form-control">
                                @foreach (getYears() as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary btn-sm btn-generate">Generate</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @endif

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
    @endif
    @if (auth()->user()->hasRole(['inventory','owner']))
    <div class="animated fadeIn">
        <div class="row mt-3">
            <div class="col-md-12">
                @include('flash::message')
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

            </div>
        </div>


        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4>Tabel Produk</h4>
                        <table class="table table-hover table-bordered table-stripped" id="product-table">
                            <thead>
                                <tr>
                                    <th>Nama Produk</th>
                                    <th>Kategori</th>
                                    <th>Satuan</th>
                                    <th>Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                <tr>

                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->category->category_name }}</td>
                                    <td>{{ $product->unit }}</td>
                                    <td>{{ $product->current_stock }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<div id="initialCashModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-header">
            <h5 class="modal-title">Input Kas Awal</h5>
            <button type="button" aria-label="Close" class="close" data-dismiss="modal">×</button>
        </div>
        <!-- Modal content-->
        <div class="modal-content">

            <form action="{{ route('cash_add') }}" method="POST">
                @csrf
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-12">

                            <div class="from-group">
                                <label for="cash_add">Total Penambahan Kas</label>
                                <input type="text" class="form-control" name="cash_add" id="cash_add">
                            </div>
                        </div>
                    </div>


                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="text-right">
                                {{ Form::button(__('Simpan'), ['type'=>'submit','class' => 'btn btn-primary','id'=>'btnSave','data-loading-text'=>"<span class='spinner-border spinner-border-sm'></span> Processing..."]) }}
                                <button type="button" class="btn btn-light ml-1"
                                    data-dismiss="modal">{{ __('Batal') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('page_css')
<link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('page_scripts')
<script src="{{ asset('assets/js/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/chart.min.js') }}"></script>
<script src="{{ asset('assets/js/daterangepicker.js') }}"></script>
<script src="{{ asset('js/toggle.js') }}"></script>
<script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ mix('assets/js/custom/custom-datatable.js') }}"></script>
<script>
    $('#stock-adjusment-datatable').dataTable();
    $('#product-table').dataTable();
    $('#product_id').select2({
        placeholder: "Select an option"
    });
    $('.btn-cash-add').click(function(){
        $('#initialCashModal').modal('show');
    });
    $(function(){
        $.ajax({
            url : `{{ route('chart') }}`,
            method:'get',
            dataType:'json',
            success:function(response){
                console.log(response);
                const ctx = document.getElementById('canvas').getContext('2d');
                labels = response.income.month;

                const myChart = new Chart(ctx,{
                    type : 'bar',
                    label : 'Chart',
                    data : {
                        labels : labels,
                        datasets: [
                            {
                                label : ' Pendapatan',
                                backgroundColor: 'rgba(54, 162, 235, 1)',
                                data: response.income.value
                            },
                            {
                                label : ' Pengeluaran',
                                backgroundColor: 'rgba(255, 99, 132, 1)',
                                data: response.spending.value
                            },
                            {
                                label : ' Pembelian',
                                backgroundColor: 'rgba(201, 203, 207, 1)',
                                data: response.purchase.value
                            },
                            {
                                label : ' Penyesuaian',
                                backgroundColor: 'rgba(255, 205, 86, 1)',
                                data: response.stock_adjusment.value
                            },
                        ]
                    },
                    options : {
                        tooltips : {
                            mode: 'index'
                        },
                        responsive: true, // Instruct chart js to respond nicely.
                        maintainAspectRatio: false,
                    }
                })
            }
        });

        $('.btn-generate').click(function(){
            monthStart = $('#month_start').val();
            monthEnd = $('#month_end').val();
            yearEnd = $('#year_end').val();
            yearStart = $('#year_start').val();
            let url = `{{ route('report') }}`+ `?month-start=${monthStart}&year-start=${yearStart}&month-end=${monthEnd}&year-end=${yearEnd}`;
            window.open(url);

        });

        $('.btn-setor').click(function(){
           $('#addModal').modal('show');
        });
        $('#amount').keyup(function(){
            value = String($(this).val());
            $('#show-amount').html(formatRupiah(value));
            $(this).val(formatRupiah(value));
        });
        $('#cash_add').keyup(function(){
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
        $('.btn-shift').click(function(){
            shiftStatus = $(this).data('status');
            if(shiftStatus != "aktif"){
                confirm = confirm('Yakin Ingin Memulai Shift ? ');
                if(confirm){
                    $.ajax({
                        url :   `{{ route('shift') }}` ,
                        method :'post',
                        dataType : 'json',
                        success:function(response){
                            alert(response.message);
                            location.reload();
                        }
                    })
                }
            }else{
                confirm = confirm('Yakin ingin mengakhiri shift  ? ')
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
    $(function(){
        $.ajax({
            url : `{{ route('service_chart') }}`,
            method:'get',
            dataType:'json',
            success:function(response){
                new Chart(document.getElementById('general').getContext('2d'),{
                    type : 'line',
                    label : 'Chart',
                    data : {
                        labels : response.general.month,
                        datasets: [
                            {
                                label : 'Grafik Pendapatan Layanan Umum',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                data: response.general.value
                            }
                        ]
                    },
                    options : {
                        tooltips : {
                            mode: 'index'
                        },
                        responsive: true, // Instruct chart js to respond nicely.
                        maintainAspectRatio: false,
                    }
                })
                new Chart(document.getElementById('family_planning').getContext('2d'),{
                    type : 'line',
                    label : 'Chart',
                    data : {
                        labels : response.family_planning.month,
                        datasets: [
                            {
                                label : 'Grafik Pendapatan Layanan KB',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                data: response.family_planning.value
                            }
                        ]
                    },
                    options : {
                        tooltips : {
                            mode: 'index'
                        },
                        responsive: true, // Instruct chart js to respond nicely.
                        maintainAspectRatio: false,
                    }
                })
                new Chart(document.getElementById('pregnancy').getContext('2d'),{
                    type : 'line',
                    label : 'Chart',
                    data : {
                        labels : response.pregnancy.month,
                        datasets: [
                            {
                                label : 'Grafik Pendapatan Layanan Kehamilan',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                data: response.pregnancy.value
                            }
                        ]
                    },
                    options : {
                        tooltips : {
                            mode: 'index'
                        },
                        responsive: true, // Instruct chart js to respond nicely.
                        maintainAspectRatio: false,
                    }
                })
                new Chart(document.getElementById('laboratory').getContext('2d'),{
                    type : 'line',
                    label : 'Chart',
                    data : {
                        labels : response.laboratory.month,
                        datasets: [
                            {
                                label : 'Grafik Pendapatan Layanan Laboratorium',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                data: response.laboratory.value
                            }
                        ]
                    },
                    options : {
                        tooltips : {
                            mode: 'index'
                        },
                        responsive: true, // Instruct chart js to respond nicely.
                        maintainAspectRatio: false,
                    }
                })
                new Chart(document.getElementById('immunization').getContext('2d'),{
                    type : 'line',
                    label : 'Chart',
                    data : {
                        labels : response.immunization.month,
                        datasets: [
                            {
                                label : 'Grafik Pendapatan Layanan Imunisasi',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                data: response.immunization.value
                            }
                        ]
                    },
                    options : {
                        tooltips : {
                            mode: 'index'
                        },
                        responsive: true, // Instruct chart js to respond nicely.
                        maintainAspectRatio: false,
                    }
                })
                new Chart(document.getElementById('parturition').getContext('2d'),{
                    type : 'line',
                    label : 'Chart',
                    data : {
                        labels : response.parturition.month,
                        datasets: [
                            {
                                label : 'Grafik Pendapatan Layanan Partus',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                data: response.parturition.value
                            }
                        ]
                    },
                    options : {
                        tooltips : {
                            mode: 'index'
                        },
                        responsive: true, // Instruct chart js to respond nicely.
                        maintainAspectRatio: false,
                    }
                })
                new Chart(document.getElementById('inpatient').getContext('2d'),{
                    type : 'line',
                    label : 'Chart',
                    data : {
                        labels : response.inpatient.month,
                        datasets: [
                            {
                                label : 'Grafik Pendapatan Layanan Rawat Inap',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                data: response.inpatient.value
                            }
                        ]
                    },
                    options : {
                        tooltips : {
                            mode: 'index'
                        },
                        responsive: true, // Instruct chart js to respond nicely.
                        maintainAspectRatio: false,
                    }
                })
                new Chart(document.getElementById('ekg').getContext('2d'),{
                    type : 'line',
                    label : 'Chart',
                    data : {
                        labels : response.ekg.month,
                        datasets: [
                            {
                                label : 'Grafik Pendapatan Layanan EKG',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                data: response.ekg.value
                            }
                        ]
                    },
                    options : {
                        tooltips : {
                            mode: 'index'
                        },
                        responsive: true, // Instruct chart js to respond nicely.
                        maintainAspectRatio: false,
                    }
                })
                new Chart(document.getElementById('administration').getContext('2d'),{
                    type : 'line',
                    label : 'Chart',
                    data : {
                        labels : response.administration.month,
                        datasets: [
                            {
                                label : 'Grafik Pendapatan Layanan Administrasi',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                data: response.administration.value
                            }
                        ]
                    },
                    options : {
                        tooltips : {
                            mode: 'index'
                        },
                        responsive: true, // Instruct chart js to respond nicely.
                        maintainAspectRatio: false,
                    }
                })
            }
        });

        $('.btn-generate').click(function(){
            monthStart = $('#month_start').val();
            monthEnd = $('#month_end').val();
            yearEnd = $('#year_end').val();
            yearStart = $('#year_start').val();
            let url = `{{ route('report') }}`+ `?month-start=${monthStart}&year-start=${yearStart}&month-end=${monthEnd}&year-end=${yearEnd}`;
            window.open(url);

        });

        $('.btn-setor').click(function(){
           $('#addModal').modal('show');
        });
        $('#amount').keyup(function(){
            value = String($(this).val());
            $('#show-amount').html(formatRupiah(value));
            $(this).val(formatRupiah(value));
        });
        $('#cash_add').keyup(function(){
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
        $('.btn-shift').click(function(){
            shiftStatus = $(this).data('status');
            if(shiftStatus != "aktif"){
                confirm = confirm('Yakin Ingin Memulai Shift ? ');
                if(confirm){
                    $.ajax({
                        url :   `{{ route('shift') }}` ,
                        method :'post',
                        dataType : 'json',
                        success:function(response){
                            alert(response.message);
                            location.reload();
                        }
                    })
                }
            }else{
                confirm = confirm('Yakin ingin mengakhiri shift  ? ')
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
