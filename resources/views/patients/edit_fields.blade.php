<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {{ Form::label('name_form', __('Nama').':') }}<span class="required">*</span>
            {{ Form::text('name_form', $patient->name, ['class' => 'form-control','required']) }}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="registration_number">Nomor Registrasi <span class="required">*</span></label>
            <input type="text" class="form-control" name="registration_number" id="registration_number" required
                value="{{ $patient->registration_number }}">
        </div>

    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="birth_date">Tanggal Kelahiran <span class="required">*</span></label>
            <input type="date" class="form-control" name="birth_date" id="birth_date"
                value="{{ $patient->birth_date }}">
        </div>

    </div>

    <div class="col-md-6">
        <div class="form-group mobile-overlapping">
            {{ Form::label('phone_form', __('No.Telp').':') }}<span class="required">*</span><br>
            {{ Form::tel('phone_form', $patient->phone, ['class' => 'form-control','id' => 'phone_form','required', 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")']) }}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {{ Form::label('gender_form', __('Jenis Kelamin').':') }}<span class="required">*</span> &nbsp;<br>
            {{ Form::radio('gender_form', 'male', $patient->gender == "male" ? true : false) }} {{ __('Pria') }} &nbsp;
            {{ Form::radio('gender_form', 'female', $patient->gender == "female" ? true : false) }} {{ __('Wanita') }}
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="blood_group">Golongan Darah</label>
            <select name="blood_group" id="blood_group" required class="form-control">
                <option selected value="null">Pilih Golongan Darah</option>
                @foreach ($bloodGroup as $item)
                <option value="{{ $item }}" {{ $item == $patient->blood_group ? 'selected' : '' }}>{{ $item }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            {{ Form::label('address_form', __('Alamat').':') }}<span class="required">*</span>
            {{ Form::text('address_form', $patient->address, ['class' => 'form-control','required']) }}
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            {{ Form::label('city', __('Kota').':') }}<span class="required">*</span>
            {{ Form::text('city', $patient->city, ['class' => 'form-control','required']) }}
        </div>
    </div>
</div>
