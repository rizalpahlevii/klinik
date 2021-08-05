@extends('layouts.app')
@section('title')
Detail Dokter
@endsection
@section('page_css')
<link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="container-fluid mt-4">
    <div class="animated fadeIn">
        @include('flash::message')
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header bg-white border-0">
                        <strong>Detail Dokter</strong>
                    </div>
                    <div class="card-body">
                        @include('medics.show_fields')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="service-url"
    value="{{ route('medics.service',['medic'=>$data->id,'service'=>':service-name']) }}">
@endsection
@section('page_scripts')
<script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ mix('assets/js/custom/custom-datatable.js') }}"></script>
<script>
    $(document).ready(function(){
        $('.data-table').DataTable();
        $('#service').change(function(){
            service = $(this).val();
            url = $('#service-url').val();
            url =url.replace(':service-name',service);
            $.ajax({
                url :url,
                dataType : 'json',
                success : function(response){
                    console.log(response.data);
                    rowTable = '';
                    $('#serviceData').html('');
                    response.data.forEach((item,i)=>{
                        serviceUrl = `{{ url('/services/${service}/:service-id') }}`;
                        serviceUrl = serviceUrl.replace(':service-id',item.id);
                        patientUrl = `{{ url('/patients/:patient-id') }}`;
                        patientUrl = patientUrl.replace(':patient-id',item.patient_id);
                        rowTable += `
                            <tr>
                                <td>
                                    <a href="${serviceUrl}">${item.service_number}
                                            </a>
                                </td>
                                <td>
                                    <a href="${patientUrl}">${item.patient.name}
                                            </a>
                                </td>
                                <td>${item.notes}</td>
                                <td>${item.phone}</td>
                                <td>${item.registration_time}</td>
                                <td>${item.total_fee}</td>
                            </tr>
                        `;
                        $('#serviceData').html('');
                        $('#serviceData').html(rowTable);
                    });
                }
            });
        });
    });
</script>
@endsection