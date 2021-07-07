@extends('layouts.app')
@section('title')
Edit Pembelian Obat
@endsection
@section('page_css')
<link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/int-tel/css/intlTelInput.css') }}">
@endsection
@section('content')
<div class="container-fluid">
    <div class="animated fadeIn">
        @include('flash::message')

        <div class="row mt-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Edit Faktur</strong>
                    </div>
                    <div class="card-body">
                        <input type="hidden" id="purchase_id" value="{{ $purchase->id }}">
                        @if (session()->has('newurl'))
                        <input type="hidden" value="{{ session()->get('newurl') }}" name="newurl" id="newurl">
                        @else
                        <input type="hidden" value="no" name="newurl" id="newurl">
                        @endif

                        {{ Form::open(['route' => ['purchases.update',$purchase->id], 'files' => 'true', 'id' => 'createProductForm']) }}
                        @csrf
                        @method('PUT')
                        @include('purchases.edit.fields')

                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-success btn-sm mb-2 btn-add-row">Tambahkan
                                    Baris</button>
                                <div class="table-load">
                                    @include('purchases.edit.table')
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 float-right">
                                <input type="submit" name="submit" class="btn btn-primary" value="Simpan">
                            </div>
                        </div>
                        {{ Form::close() }}

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('page_scripts')
<script src="{{ asset('assets/js/moment.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('assets/js/int-tel/js/intlTelInput.min.js') }}"></script>
<script src="{{ asset('assets/js/int-tel/js/utils.min.js') }}"></script>
<script>
    $(document).ready(function(){

        productData = [];

        $.ajax({
            url : `{{ route('purchases.get_products') }}`,
            method : 'get',
            dataType : 'json',
            success: function(response){
                productData = response.data
            }
        });

        newurl = $('#newurl').val();


        $('.product-id').select2({
            placeholder: "Select an option"
        });
        if(newurl!="no"){
            window.open(newurl);
        }

        $(document).on('click','.delete-btn',function(){
            $(this).parent().parent().remove();
        });

        $(document).on('change','.product-id',function(){
            $(this).parent().parent().find('.product-name').val($(this).find("option:selected").data('name'));
            $(this).parent().parent().find('.unit').val($(this).find("option:selected").data('unit'));
            $(this).parent().parent().find('.price').val(0);
            $(this).parent().parent().find('.quantity').val(1);
            $(this).parent().parent().find('.subtotal').val(0);
        });

        $(document).on('keyup','.price',function(){
            qty =  $(this).parent().parent().find('.quantity').val();
            result = parseInt(qty) * parseInt($(this).val());
            $(this).parent().parent().find('.subtotal').val(result);
            calculate();
        });

        $(document).on('keyup','.quantity',function(){
            price =  $(this).parent().parent().find('.price').val();
            result = parseInt(price) * parseInt($(this).val());
            $(this).parent().parent().find('.subtotal').val(result);
            calculate();
        });

        $('#supplier_id').select2({
            placeholder: "Select an option"
        });
        $('#salesman_id').select2({
            placeholder: "Select an option"
        });

        $('#supplier_id').change(function(){
            let url = `{{ route('purchases.get_salesman',':id') }}`;
            url = url.replace(':id',$(this).val());
            $.ajax({
                url : url,
                method : 'get',
                success:function(response){
                    html = '<option disabled selected>Pilih Salesman</option>';
                    response.data.forEach((item,i)=>{
                        html += `<option value="${item.id}">${item.salesman_name}</option>`
                    });
                    $('#salesman_id').html(html);
                }
            });
        });
    });

    $('#discount').keyup(function(){
        calculate();
    });

    $('#tax').keyup(function(){
        calculate();
    });

    $('.btn-add-row').click(function(){
        html = '<tr>';
        productOption = '<option disabled selected>Pilih Produk</option>';
        productData.forEach((item,i)=>{
            productOption += `<option value="${item.product_code}" data-name="${item.name}" data-unit="${item.unit}" data-price="${item.current_price}">${item.name}</option>`
        });
        html += `<td><select name="product_id[]" class="form-control product-id">${productOption}</select></td>`;
        html += ` <td><input type="text" class="form-control product-name" readonly></td>`;
        html += `<td><input name="quantity[]" type="number" class="form-control quantity" value="1"></td>`;
        html += ` <td><input type="text" class="form-control unit" readonly></td>`;
        html += `<td><input name="price[]" type="number" class="form-control price"></td>`;
        html += `<td><input type="number" class="form-control subtotal" readonly></td>`;
        html += `<td><button type="button" class="btn btn-success btn-sm add-cart"
                    data-loading-text="<span class='spinner-border spinner-border-sm'></span> Processing...">Tambahkan
                    Faktur</button></td>`;
        html += '</tr>';

        $('#table-tbody-cart').append(html);
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
    function calculate(){
        tax = $('#tax').val();
        discount = $('#discount').val();

        $('#tax-view').html(formatRupiah(tax));
        $('#discount-view').html(formatRupiah(discount));
        total = 0;
        $('.subtotal').each(function(){
            total += parseInt($(this).val());
        });
        $('#subtotal-view').html(formatRupiah(String (total)));
        result = parseInt(total) - parseInt(tax) - parseInt(discount);
        $('#end-total').html(formatRupiah(String (result)));

    }
</script>
@endsection
