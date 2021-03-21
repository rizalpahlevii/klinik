@extends('layouts.app')
@section('title')
Edit Layanan KB
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
                        <strong>Edit Layanan KB</strong>
                    </div>
                    <div class="card-body">

                        {{ Form::open(['route' => ['services.family_plannings.update', $data->id], 'method' => 'put','files' => 'true']) }}

                        @include('services.family_plannings.edit_fields')
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="{{ route('services.family_plannings.index') }}"
                                    class="btn btn-secondary">Batal</a>
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
@endsection
@section('scripts')
<script>
    let utilsScript = "{{asset('assets/js/int-tel/js/utils.min.js')}}";
        let isEdit = false;

    $(document).ready(function(){
        $('#patient_id').change(function(){
            $('#phone_form').val($('#patient_id :selected').data('phone'));
        });

        $('#discount').keyup(function(){
            value = $(this).val();
            $(this).val(formatRupiah(value,'Rp. '))
        });
        $('#fee').keyup(function(){
            value = $(this).val();
            $(this).val(formatRupiah(value,'Rp. '))
        });

        function formatRupiah(angka,prefix){
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
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }
    });
</script>
@endsection
