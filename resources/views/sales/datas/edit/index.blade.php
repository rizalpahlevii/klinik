@extends('layouts.app')
@section('title')
Penjualan Obat
@endsection
@section('page_css')
<link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/int-tel/css/intlTelInput.css') }}">
@endsection
@section('content')
<div class="container-fluid">
    <div class="animated fadeIn">
        @include('flash::message')
        @include('coreui-templates::common.errors')
        <div class="row mt-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Edit Faktur</strong>
                    </div>
                    <div class="card-body">
                        @if (session()->has('newurl'))
                        <input type="hidden" value="{{ session()->get('newurl') }}" name="newurl" id="newurl">
                        @else
                        <input type="hidden" value="no" name="newurl" id="newurl">
                        @endif

                        {{ Form::open(['route' => ['sales.datas.update',$sale->id], 'files' => 'true', 'id' => 'createProductForm']) }}
                        @csrf
                        @method('PUT')
                        @include('sales.datas.edit.fields')

                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-success btn-sm mb-2 btn-add-row">Tambahkan
                                    Baris</button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                @include('sales.datas.edit.table')
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
        newurl = $('#newurl').val()
        if(newurl!="no"){
            window.open(newurl);
        }

        productData = [];

        $.ajax({
            url : `{{ route('purchases.get_products') }}`,
            method : 'get',
            dataType : 'json',
            success: function(response){
                productData = response.data
            }
        });

    });

    $('.product-id').select2({
        placeholder: "Select an option"
    });
    $('.product-name').select2({
        placeholder: "Select an option"
    });

    function convertToAngka(param)
    {
        rupiah = String(param);
        return parseInt(rupiah.replace(/,.*|[^0-9]/g, ''), 10);
    }


    $(document).on('click','.delete-btn',function(){
        $(this).parent().parent().remove();
    });

    $('#member_buyer_name').select2({
        placeholder : 'Input Pasien',
        width :'resolve'
    });

    $('#buyer_type').change(function(){
        const generalForm = document.querySelector('.general_form');
        const memberForm = document.querySelector('.member_form');

        if($(this).val() != "general"){
            $('.member_form').css('display','block');
            $('.general_form').css('display','none');
        }else{
            $('.member_form').css('display','none');
            $('.general_form').css('display','block');
        }
    });
    $('#discount').keyup(function(){
        tax = convertToAngka($('#tax').val());
        discount = convertToAngka($('#discount').val());
        subtotal = $('#subtotal_hid').val();
        endTotal = subtotal - discount - tax;
        $('#tax-view').html(formatRupiah(String(tax)));
        $('#discount-view').html(formatRupiah(String(discount)));
        $('#subtotal-view').html(formatRupiah(String(subtotal)));
        $('#end-total').html(formatRupiah(String(endTotal)));
    });
    $('#medic_id').select2({
        placeholder: "Select an option"
    });
    $('#tax').keyup(function(){
        tax = convertToAngka($('#tax').val());
        discount = convertToAngka($('#discount').val());
        subtotal = $('#subtotal_hid').val();
        endTotal = subtotal - discount - tax;
        $('#tax-view').html(formatRupiah(String(tax)));
        $('#discount-view').html(formatRupiah(String(discount)));
        $('#subtotal-view').html(formatRupiah(String(subtotal)));
        $('#end-total').html(formatRupiah(String(endTotal)));
    });

    $('.btn-add-row').click(function(){
        html = '<tr>';
        productOption1 = '<option disabled selected>Pilih Produk</option>';
        productOption2 = '<option disabled selected>Pilih Produk</option>';
        productData.forEach((item,i)=>{
            productOption1 += `<option value="${item.id}" data-name="${item.name}" data-id="${item.id}" data-unit="${item.unit}" data-price="${item.selling_price}">${item.product_code}</option>`
            productOption2 += `<option value="${item.id}" data-name="${item.name}" data-id="${item.id}" data-unit="${item.unit}" data-price="${item.selling_price}">${item.name}</option>`
        });
        html += `<td><select name="product_id[]" class="form-control select2 product-id">${productOption1}</select></td>`;
        html += `<td><select name="product_name[]" class="form-control select2 product-name">${productOption2}</select></td>`;
        html += `<td><input name="quantity[]" type="number" class="form-control quantity" value="1"></td>`;
        html += ` <td><input type="text" class="form-control unit" readonly></td>`;
        html += `<td><input name="price[]" type="text" class="form-control price"></td>`;
        html += `<td><input type="text" class="form-control subtotal" readonly></td>`;
        html += `<td><button type="button" class="btn btn-success btn-sm add-cart"
                    data-loading-text="<span class='spinner-border spinner-border-sm'></span> Processing...">Tambahkan
                    Faktur</button></td>`;
        html += '</tr>';

        $('#table-tbody-cart').append(html);
    });


    $(document).on('change','.product-id',function(){
        $(this).parent().parent().find('.product-name').val($(this).find("option:selected").data('id'));
        $(this).parent().parent().find('.unit').val($(this).find("option:selected").data('unit'));
        $(this).parent().parent().find('.price').val(formatRupiah(String($(this).find("option:selected").data('price'))));
        $(this).parent().parent().find('.quantity').val(1);
        $(this).parent().parent().find('.subtotal').val(formatRupiah(String($(this).find("option:selected").data('price'))));
        calculate();
    });
    $(document).on('change','.product-name',function(){
        $(this).parent().parent().find('.product-id').val($(this).find("option:selected").data('id'));
        $(this).parent().parent().find('.unit').val($(this).find("option:selected").data('unit'));
        $(this).parent().parent().find('.price').val(formatRupiah(String($(this).find("option:selected").data('price'))));
        $(this).parent().parent().find('.quantity').val(1);
        $(this).parent().parent().find('.subtotal').val(formatRupiah(String($(this).find("option:selected").data('price'))));
        calculate();
    });

    $(document).on('keyup','.price',function(){
        qty = convertToAngka( $(this).parent().parent().find('.quantity').val());
        result = parseInt(qty) * parseInt($(this).val());
        $(this).parent().parent().find('.subtotal').val(formatRupiah(String(result)));
        calculate();
    });

    $(document).on('keyup','.quantity',function(){
        price =  convertToAngka($(this).parent().parent().find('.price').val());
        result = parseInt(price) * parseInt($(this).val());
        $(this).parent().parent().find('.subtotal').val(formatRupiah(String(result)));
        calculate();
    });

    function convertToAngka(param)
    {
        rupiah = String(param);
        return parseInt(rupiah.replace(/,.*|[^0-9]/g, ''), 10);
    }

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
        tax = convertToAngka($('#tax').val());
        discount = convertToAngka($('#discount').val());

        $('#tax-view').html(formatRupiah(String(tax)));
        $('#discount-view').html(formatRupiah(String(discount)));
        total = 0;
        $('.subtotal').each(function(){
            total += parseInt(convertToAngka($(this).val()));
        });
        $('#sutotal_hid').val(total);
        $('#subtotal-view').html(formatRupiah(String (total)));
        result = parseInt(total) - parseInt(tax) - parseInt(discount);
        $('#end-total').html(formatRupiah(String (result)));

    }
</script>
@endsection
