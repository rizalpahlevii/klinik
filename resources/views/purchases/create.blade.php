@extends('layouts.app')
@section('title')
Pembelian Obat
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
                        <strong>Faktur Baru</strong>
                    </div>
                    <div class="card-body">
                        @if (session()->has('newurl'))
                        <input type="hidden" value="{{ session()->get('newurl') }}" name="newurl" id="newurl">
                        @else
                        <input type="hidden" value="no" name="newurl" id="newurl">
                        @endif

                        {{ Form::open(['route' => 'purchases.store', 'files' => 'true', 'id' => 'createProductForm']) }}

                        @include('purchases.fields')

                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-load">

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
        newurl = $('#newurl').val();

        if(newurl!="no"){
            window.open(newurl);
        }

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



    let cartTableUrl = `{{ route('purchases.cart_table') }}`;
    let cartDelete = `{{ route('purchases.cart_delete',':key') }}`;
    let addCartUrl = `{{ route('purchases.cart_add') }}`;

    $('#discount').keyup(function(){
        tax = $('#tax').val();
        discount = $('#discount').val();
        subtotal = $('#subtotal_hid').val();
        endTotal = subtotal - discount - tax;
        console.log(endTotal);
        $('#tax-view').html(formatRupiah(tax));
        $('#discount-view').html(formatRupiah(discount));
        $('#subtotal-view').html(formatRupiah(subtotal));
        $('#end-total').html(formatRupiah(String(endTotal)));
    });

    $('#tax').keyup(function(){
        tax = $('#tax').val();
        discount = $('#discount').val();
        subtotal = $('#subtotal_hid').val();
        endTotal = subtotal - discount - tax;
        console.log(endTotal);
        $('#tax-view').html(formatRupiah(tax));
        $('#discount-view').html(formatRupiah(discount));
        $('#subtotal-view').html(formatRupiah(subtotal));
        $('#end-total').html(formatRupiah(String(endTotal)));
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
</script>
<script src="{{ asset('assets/js/sales/cashiers/cashiers.js') }}"></script>
@endsection
