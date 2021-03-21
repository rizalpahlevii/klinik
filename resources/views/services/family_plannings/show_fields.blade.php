<div class="row view-spacer">
    <div class="col-md-3">
        <div class="form-group">
            {{ Form::label('nomor', __('Nomor').':', ['class' => 'font-weight-bold']) }}
            <p>{{ $data->service_number }}</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="registration_time" class="font-weight-bold">Tanggal Registrasi</label>
            <p>{{ $data->registration_time }}</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="registration_time" class="font-weight-bold">Nama Pasien</label>
            <p>{{ $data->patient->name }}</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="registration_time" class="font-weight-bold">Nama Telp Pasien</label>
            <p>{{ $data->phone }}</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="registration_time" class="font-weight-bold">Biaya</label>
            <p>@rupiah($data->service_fee)</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="registration_time" class="font-weight-bold">Diskon</label>
            <p>@rupiah($data->dicount)</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="registration_time" class="font-weight-bold">Total Biaya</label>
            <p>@rupiah($data->total_fee)</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="registration_time" class="font-weight-bold">Catatan</label>
            <p>{{ $data->notes }}</p>
        </div>
    </div>

</div>
