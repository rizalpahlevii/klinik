@extends('layouts.app')
@section('title')
Penyesuaian Stok
@endsection
@section('page_css')
<link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="container-fluid">
    <div class="animated fadeIn">
        @include('flash::message')
        <div class="page-header">
            <h3 class="page__heading">Penyesuaian Stok</h3>
            <div class="flex-end-sm">
                <a href="#" class="btn btn-primary btn-stock-adjusment">Tambah Penyesuaian
                    Stok</a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
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
                                        <td>{{ $stockAdjusment->product ? $stockAdjusment->product->name : '' }}
                                        </td>
                                        <td>{{ $stockAdjusment->quantity }}</td>
                                        <td>{{ $stockAdjusment->note }}</td>
                                        <td>
                                            <button data-id="{{ $stockAdjusment->id }}"
                                                data-product-id="{{ $stockAdjusment->product_id }}"
                                                data-quantity="{{ $stockAdjusment->quantity }}"
                                                data-note="{{ $stockAdjusment->note }}"
                                                class="btn btn-dark btn-sm btn-edit">Edit</button>
                                            <a class="btn btn-danger btn-sm btn-delete" href="#"
                                                onclick="return confirm('Anda Yakin Ingin Menghapus Data Penyesuaian Stok Ini ? ')">Hapus</a>

                                            <form action="{{ route('stock_adjusments.destroy',$stockAdjusment->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')

                                            </form>
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
    </div>

</div>

<div id="stockAdjusmentModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-header">
            <h5 class="modal-title">Tambahkan Penyesuaian</h5>
            <button type="button" aria-label="Close" class="close" data-dismiss="modal">×</button>
        </div>
        <!-- Modal content-->
        <div class="modal-content">

            <form action="{{ route('stock_adjusments.store') }}" method="POST" enctype="multipart/form-data">
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
@section('page_scripts')
<script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ mix('assets/js/custom/custom-datatable.js') }}"></script>
@endsection
@section('scripts')
<script>
    $('#stock-adjusment-datatable').dataTable();
    $('.btn-delete').click(function (e) {
                $(this).siblings('form').submit();

        });
    $(document).on('click','.btn-edit',function(){
            $('#quantity_edit').val($(this).data('quantity'));
            $('#note_edit').val($(this).data('note'))
            $('#product_id_edit').val($(this).data('product-id'));
            let url = `{{ route('stock_adjusments.update',':id') }}`;
            url = url.replace(':id',$(this).data('id'));
            $('#stock-adjument-edit').attr('action',url);
            $('#stockAdjusmentModalEdit').modal('show');

        });
        $('.btn-stock-adjusment').click(function(){
            $('#stockAdjusmentModal').modal('show');
        });
</script>
@endsection
