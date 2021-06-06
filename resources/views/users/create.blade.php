@extends('layouts.app')
@section('title')
Pengguna
@endsection
@section('page_css')
<link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/css/int-tel/css/intlTelInput.css') }}">
@endsection
@section('content')
<div class="container-fluid">
    <div class="animated fadeIn">
        @include('flash::message')
        <div class="page-header">
            <h3 class="page__heading">Pengguna</h3>
            <div class="flex-end-sm">
                <a href="{{ route('users.create') }}" class="btn btn-primary">Tambah Pengguna</a>
            </div>
        </div>
        <div class="row">

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        {{ Form::open(['route' => 'users.store', 'id' => 'createUserForm']) }}

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name_form">Nama Pengguna<span class="required">*</span></label>
                                    <input type="text" class="form-control @error('name_form') is-invalid @enderror"
                                        name="name_form" id="name_form" placeholder="Nama Pengguna"
                                        value="{{ old('name_form') }}">

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address_form">Alamat<span class="required">*</span></label>
                                    <input type="text" class="form-control @error('address_form') is-invalid @enderror"
                                        name="address_form" id="address_form" placeholder="Nama Pengguna"
                                        value="{{ old('address_form') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="role_form">Jabatan <span class="required">*</span></label>
                                    <select name="role_form" id="role_form"
                                        class="form-control @error('role_form') is-invalid @enderror">
                                        @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('phone_form', __('No.Telp Pengguna').':') !!} <br>
                                    {!! Form::tel('phone_form', null, ['class' => 'form-control','id' => 'phoneNumber',
                                    'onkeyup' => 'if (/\D/g.test(this.value)) this.value =
                                    this.value.replace(/\D/g,"")']) !!}
                                    {!! Form::hidden('prefix_code',null,['id'=>'prefix_code']) !!}
                                    <span id="valid-msg" class="hide">✓ &nbsp; Valid</span>
                                    <span id="error-msg" class="hide"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jenis Kelamin <span class="required">*</span></label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender_form"
                                            id="exampleRadios1" value="male" checked>
                                        <label class="form-check-label" for="exampleRadios1">
                                            Pria
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender_form"
                                            id="exampleRadios2" value="female">
                                        <label class="form-check-label" for="exampleRadios2">
                                            Wanita
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="start_working_date">Tanggal Masuk Kerja</label>
                                    <input type="date"
                                        class="form-control @error('start_working_date') is-invalid @enderror"
                                        name="start_working_date" id="start_working_date"
                                        value="{{ old('start_working_date') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="username_form">Username <span class="required">*</span></label>
                                    <input type="text" class="form-control @error('username') is-invalid @enderror"
                                        name="username_form" id="username_form" value="{{ old('username_form') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="password">Password <span class="required">*</span></label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        name="password" id="password">
                                </div>
                            </div>
                            <div class="col-md-4">

                                <div class="form-group">
                                    <label for="password_confirmation">Konfirmasi Password <span
                                            class="required">*</span></label>
                                    <input type="password"
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                        name="password_confirmation" id="password_confirmation">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary ">Simpan</button>
                                <button type="reset" class="btn btn-secondary ">Batal</button>
                            </div>
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
<script src="{{ asset('assets/js/int-tel/js/intlTelInput.min.js') }}"></script>
<script src="{{ asset('assets/js/int-tel/js/utils.min.js') }}"></script>
@endsection
@section('scripts')
<script>
    let utilsScript = "{{asset('assets/js/int-tel/js/utils.min.js')}}";
        let isEdit = false;
</script>

<script src="{{ mix('assets/js/custom/phone-number-country-code.js') }}"></script>
@endsection
