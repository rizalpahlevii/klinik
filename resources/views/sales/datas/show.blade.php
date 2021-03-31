@extends('layouts.app')
@section('title')
Detail Penjualan
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
                        <strong>Detail Penjualan</strong>
                    </div>
                    <div class="card-body">
                        <div class="row view-spacer">
                            <div class="col-md-3">
                                <div class="form-group">
                                    {{ Form::label('full_name', __('Kode Faktur').':', ['class' => 'font-weight-bold']) }}
                                    <p>{{ $sale->receipt_code }}</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {{ Form::label('phone', __('Tanggal').':', ['class' => 'font-weight-bold']) }}
                                    <p>{{ \Carbon\Carbon::parse( $sale->receipt_date)->isoFormat('LL') }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {{ Form::label('blood', __('Jenis Pembeli').':', ['class' => 'font-weight-bold']) }}
                                    <p>{{ $sale->buyer_type == "member"? " Member": "Umum" }}</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {{ Form::label('gender', __('Nama Pembeli').':', ['class' => 'font-weight-bold']) }}
                                    <p>{{ $sale->buyer_name}}</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {{ Form::label('birth_date', __('Harga Normal').':', ['class' => 'font-weight-bold']) }}
                                    <p>
                                        @rupiah($sale->sub_total)
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {{ Form::label('birth_date', __('Diskon').':', ['class' => 'font-weight-bold']) }}
                                    <p>
                                        @rupiah($sale->discount)
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {{ Form::label('birth_date', __('Pajak').':', ['class' => 'font-weight-bold']) }}
                                    <p>
                                        @rupiah($sale->tax)
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {{ Form::label('birth_date', __('Total Akhir').':', ['class' => 'font-weight-bold']) }}
                                    <p>
                                        @rupiah($sale->grand_total)
                                    </p>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama Produk</th>
                                            <th>Unit</th>
                                            <th>Quatity</th>
                                            <th>Harga</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sale->saleItems as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->product->name }}</td>
                                            <td>{{ $item->product->unit }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>@rupiah($item->current_price )</td>
                                            <td>@rupiah($item->total )</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
<script src="{{ mix('assets/js/patients/patients_data_listing.js') }}"></script>
<script>
    $(document).ready(function(){
        $('.data-table').DataTable();
    });
</script>
@endsection
