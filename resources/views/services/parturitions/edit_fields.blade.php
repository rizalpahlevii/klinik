<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="patient_id">Nama Pasien <span class="required">*</span></label>
            <select name="patient_id" id="patient_id" class="form-control">
                <option disabled selected>Pilih Pasien</option>
                @foreach ($patients as $patient)
                <option value="{{ $patient->id }}" data-phone="{{ $patient->phone }}"
                    {{ $data->patient_id == $patient->id ? 'selected' : '' }}>{{ $patient->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="medic_id">Nama Dokter <span class="required">*</span></label>
            <select name="medic_id" id="medic_id" class="form-control">
                <option disabled selected>Pilih Pasien</option>
                @foreach ($medics as $medic)
                <option value="{{ $medic->id }}" {{ $data->medic_id == $medic->id ? 'selected' : '' }}>
                    {{ $medic->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="registration_time">Tanggal Masuk <span class="required">*</span></label>
            <input type="datetime-local" class="form-control" name="registration_time" id="registration_time"
                value="{{ date('Y-m-d\TH:i',strtotime($data->registration_time)) }}">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="discount">Diskon </label>
            <input type="text" class="form-control" name="discount" id="discount" value="{{ $data->discount }}">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="fee">Biaya <span class="required">*</span></label>
            <input type="text" class="form-control" name="fee" id="fee" value="{{ $data->service_fee }}">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="phone_form">No.Telp</label>
            <input type="text" class="form-control" name="phone_form" id="phone_form" value="{{ $data->phone }}">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="notes">Catatan</label>
            <textarea name="notes" id="notes" cols="30" rows="5" class="form-control">{{ $data->notes }}</textarea>
        </div>
    </div>
</div>
