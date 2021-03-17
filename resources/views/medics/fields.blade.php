<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {{ Form::label('name_form', __('Nama').':') }}<span class="required">*</span>
            {{ Form::text('name_form', null, ['class' => 'form-control','required']) }}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="specialization">Spesialisasi <span class="required"></span></label>
            <input type="text" class="form-control" name="specialization" id="specialization" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="birth_date">Tanggal Kelahiran <span class="required">*</span></label>
            <input type="date" class="form-control" name="birth_date" id="birth_date">
        </div>

    </div>
    <div class="col-md-6">
        <div class="form-group mobile-overlapping">
            {{ Form::label('phone_form', __('No.Telp').':') }}<span class="required">*</span><br>
            {{ Form::tel('phone_form', null, ['class' => 'form-control','id' => 'phoneNumber','required', 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")']) }}
            {{ Form::hidden('prefix_code',null,['id'=>'prefix_code']) }}
            <span id="valid-msg" class="hide">✓ &nbsp; Valid</span>
            <span id="error-msg" class="hide"></span>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {{ Form::label('gender_form', __('Jenis Kelamin').':') }}<span class="required">*</span> &nbsp;<br>
            {{ Form::radio('gender_form', 'male', true) }} {{ __('Pria') }} &nbsp;
            {{ Form::radio('gender_form', 'female') }} {{ __('Wanita') }}
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="blood_group">Golongan Darah <span class="required">*</span></label>
            <select name="blood_group" id="blood_group" required class="form-control">
                <option selected value="null">Pilih Golongan Darah</option>
                @foreach ($bloodGroup as $item)
                <option value="{{ $item }}">{{ $item }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            {{ Form::label('address_form', __('Alamat').':') }}<span class="required">*</span>
            {{ Form::text('address_form', null, ['class' => 'form-control','required']) }}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {{ Form::label('city', __('Kota').':') }}<span class="required">*</span>
            {{ Form::text('city', null, ['class' => 'form-control','required']) }}
        </div>
    </div>
</div>
