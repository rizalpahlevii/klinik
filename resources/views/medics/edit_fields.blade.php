<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {{ Form::label('name_form', __('Nama').':') }}<span class="required">*</span>
            {{ Form::text('name_form', $medic->name, ['class' => 'form-control','required']) }}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="specialization">Spesialisasi <span class="required">*</span></label>
            <input type="text" class="form-control" name="specialization" id="specialization"
                value="{{ $medic->specialization }}">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="birth_date">Tanggal Kelahiran <span class="required">*</span></label>
            <input type="date" class="form-control" name="birth_date" id="birth_date" value="{{ $medic->birth_date }}">
        </div>

    </div>
    <div class="col-md-6">
        <div class="form-group mobile-overlapping">
            <div class="form-group">
                <label for="phone_form">No Telp. <span class="required">*</span></label>
                <input type="text" class="form-control" name="phone_form" id="phone_form" required
                    value="{{ $medic->phone }}">
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {{ Form::label('gender_form', __('Jenis Kelamin').':') }}<span class="required">*</span> &nbsp;<br>
            {{ Form::radio('gender_form', 'male', $medic->gender == "male" ? true : false) }} {{ __('Pria') }} &nbsp;
            {{ Form::radio('gender_form', 'female', $medic->gender == "female" ? true : false) }} {{ __('Wanita') }}
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            {{ Form::label('blood_group', __('Golongan Darah').':') }}
            {{ Form::select('blood_group', $bloodGroup, null, ['class' => 'form-control', 'id' => 'bloodGroup','placeholder'=>'Pilih Golongan Darah']) }}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {{ Form::label('address_form', __('Alamat').':') }}<span class="required">*</span>
            {{ Form::text('address_form', $medic->address, ['class' => 'form-control','required']) }}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {{ Form::label('city', __('Kota').':') }}<span class="required">*</span>
            {{ Form::text('city', $medic->city, ['class' => 'form-control','required']) }}
        </div>
    </div>
</div>
