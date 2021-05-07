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
    @if (auth()->user()->hasRole(['owner','kasir']))
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
                        <div class="row mb-3">
                            <div class="col-md-10 offset-md-1">
                                @if ($shift != null)
                                <button class="btn btn-block btn-secondary btn-shift" data-status="aktif"
                                    style="padding: 10px;">Stop
                                    Shift</button>


                                @else

                                <button class="btn btn-block btn-primary btn-shift pt-2 pb-2" data-status="nonaktif" {!!
                                    checkAvailableToStartShift() ? '' : 'style="
                                    cursor:no-drop;" ' !!}" {!! checkAvailableToStartShift() ? '' : ' disabled '
                                    !!}>Start</button>

                                @endif

                            </div>
                        </div>
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
                                        <th>Kas Sekarang</th>
                                        <th>:</th>
                                        <th>
                                            @if ($shift)
                                            @rupiah($finalCash )
                                            @else
                                            @rupiah( $previousShift != null ? $previousShift->final_cash : 0 )
                                            @endif
                                        </th>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th>
                                            @if ($shift != null)
                                            @if (checkAvailableToStartShift())
                                            <button class="btn btn-block btn-primary btn-setor">
                                                <b>Setor
                                                    Uang</b>
                                            </button>
                                            @endif
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
                        @if ($shift)

                        <div class="row mt-2">
                            <div class="col-md-12">
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (auth()->user()->hasRole(['owner']))
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('cash_add') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Penambahan Kas Awal</h4>
                                <div class="from-group">
                                    <label for="cash_add">Total Penambahan Kas</label>
                                    <input type="text" class="form-control" name="cash_add" id="cash_add">
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
    <div class="row">
        <div class="col-md-12 mb-2">
            <button class="btn btn-primary btn-stock-adjusment">Tambah Penyesuaian Stok</button>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="stock-adjusment-datatable" class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tanggal Penyesuaian</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah Penyesuaian</th>
                                    <th>Catatan</th>
                                    <th>Aksi</th>
                                    <th>Info</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stockAdjusments as $stockAdjusment)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $stockAdjusment->created_at->format('[H:i:s] d F Y') }}</td>
                                    <td>{{ $stockAdjusment->product ? $stockAdjusment->product->name : '' }}</td>
                                    <td>{{ $stockAdjusment->quantity }}</td>
                                    <td>{{ $stockAdjusment->note }}</td>
                                    <td>
                                        <button data-id="{{ $stockAdjusment->id }}"
                                            data-product-id="{{ $stockAdjusment->product_id }}"
                                            data-quantity="{{ $stockAdjusment->quantity }}"
                                            data-note="{{ $stockAdjusment->note }}"
                                            class="btn btn-dark btn-sm btn-edit">Edit</button>
                                        <a class="btn btn-danger btn-sm"
                                            href="{{ route('stock_adjusment_delete',$stockAdjusment->id) }}"
                                            onclick="return confirm('Anda Yakin Ingin Menghapus Data Penyesuaian Stok Ini ? ')">Hapus</a>
                                    </td>
                                    <td>
                                        <a href="#" data-toggle="tooltip" data-html="true" title="
                                            Dibuat Oleh : {{ $stockAdjusment->user->fullname }} <br>
                                            Dibuat Pada : {{ $stockAdjusment->created_at->diffForHumans() }}<br><br>
                                            Pengubah Terakhir : {{ $stockAdjusment->updated_by == NULL ? '' : $stockAdjusment->updatedBy->fullname }} <br>
                                            Perubahan Terakhir : {{ $stockAdjusment->updated_at->diffForHumans() }}
                                            "><i class="fa fa-info"></i></a>
                                    </td>
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
    @if (auth()->user()->hasRole(['gudang','owner']))
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

<div id="stockAdjusmentModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-header">
            <h5 class="modal-title">Tambahkan Penyesuaian</h5>
            <button type="button" aria-label="Close" class="close" data-dismiss="modal">×</button>
        </div>
        <!-- Modal content-->
        <div class="modal-content">

            <form action="{{ route('stock_adjusment') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="product_id">Produk</label>
                            <select name="product_id" id="product_id" class="form-control" style="width:80%">
                                @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm-12">
                            <label for="quantity">Jumlah Penyesuaian</label>
                            <input type="number" name="quantity" id="quantity" class="form-control">
                        </div>
                        <div class="form-group col-sm-12">
                            <label for="note">Alasan Penyesuaian</label>
                            <input type="text" name="note" id="note" class="form-control">
                        </div>
                    </div>
                    <div class="text-right">
                        {{ Form::button(__('Simpan'), ['type'=>'submit','class' => 'btn btn-primary','id'=>'btnSave','data-loading-text'=>"<span class='spinner-border spinner-border-sm'></span> Processing..."]) }}
                        <button type="button" class="btn btn-light ml-1" data-dismiss="modal">{{ __('Batal') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="stockAdjusmentModalEdit" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-header">
            <h5 class="modal-title">Edit Penyesuaian Stok</h5>
            <button type="button" aria-label="Close" class="close" data-dismiss="modal">×</button>
        </div>
        <!-- Modal content-->
        <div class="modal-content">

            <form action="" id="stock-adjument-edit" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="alert alert-danger display-none" id="validationErrorsBox"></div>
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="product_id_edit">Produk</label>
                            <select name="product_id_edit" id="product_id_edit" class="form-control" style="width:80%">
                                @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm-12">
                            <label for="quantity_edit">Jumlah Penyesuaian</label>
                            <input type="number" name="quantity_edit" id="quantity_edit" class="form-control">
                        </div>
                        <div class="form-group col-sm-12">
                            <label for="note_edit">Alasan Penyesuaian</label>
                            <input type="text" name="note_edit" id="note_edit" class="form-control">
                        </div>
                    </div>
                    <div class="text-right">
                        {{ Form::button(__('Simpan'), ['type'=>'submit','class' => 'btn btn-primary','id'=>'btnSave','data-loading-text'=>"<span class='spinner-border spinner-border-sm'></span> Processing..."]) }}
                        <button type="button" class="btn btn-light ml-1" data-dismiss="modal">{{ __('Batal') }}</button>
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
    $(function(){
        $.ajax({
            url : `{{ route('chart') }}`,
            method:'get',
            dataType:'json',
            success:function(response){
                console.log(response);
                const ctx = document.getElementById('canvas').getContext('2d');
                labels = response.month;
                value = response.value
                const myChart = new Chart(ctx,{
                    type : 'line',
                    label : 'Chart',
                    data : {
                        labels : labels,
                        datasets: [
                            {
                                label : ' Grafik Pendapatan Tiap Bulan Per Tahun',
                                borderColor: 'rgba(255, 99, 132, 1)',
                                data: value
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
        $(document).on('click','.btn-edit',function(){
            $('#quantity_edit').val($(this).data('quantity'));
            $('#note_edit').val($(this).data('note'))
            $('#product_id_edit').val($(this).data('product-id'));
            let url = `{{ route('stock_adjusment_update',':id') }}`;
            url = url.replace(':id',$(this).data('id'));
            $('#stock-adjument-edit').attr('action',url);
            $('#stockAdjusmentModalEdit').modal('show');

        });
        $('.btn-generate').click(function(){
            monthStart = $('#month_start').val();
            monthEnd = $('#month_end').val();
            yearEnd = $('#year_end').val();
            yearStart = $('#year_start').val();
            let url = `{{ route('report') }}`+ `?month-start=${monthStart}&year-start=${yearStart}&month-end=${monthEnd}&year-end=${yearEnd}`;
            window.open(url);

        });
        $('.btn-stock-adjusment').click(function(){
            $('#stockAdjusmentModal').modal('show');
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
