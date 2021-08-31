<div class="row view-spacer">
    <div class="col-md-3">
        <div class="form-group">
            {{ Form::label('full_name', __('Nama Pasien').':', ['class' => 'font-weight-bold']) }}
            <p>{{ $data->name }}</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            {{ Form::label('registration_number', __('Nomor Registrasi').':', ['class' => 'font-weight-bold']) }}
            <p>{{ $data->registration_number }}</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            {{ Form::label('phone', __('No.Telp Pasien').':', ['class' => 'font-weight-bold']) }}
            <p>{{ !empty($data->phone)?$data->phone:__('messages.common.n/a') }}</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            {{ Form::label('blood', __('Golongan Darah').':', ['class' => 'font-weight-bold']) }}
            <p>{{ !empty($data->blood_group)?$data->blood_group:__('messages.common.n/a') }}</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            {{ Form::label('gender', __('Jenis Kelamin').':', ['class' => 'font-weight-bold']) }}
            <p>{{ ($data->gender != "male") ? __('Wanita') : __('Pria') }}</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            {{ Form::label('birth_date', __('Tanggal Lahir').':', ['class' => 'font-weight-bold']) }}
            <p>{{ !empty($data->birth_date) ? Carbon\Carbon::parse($data->birth_date)->locale('id')->isoFormat('LL') : __('messages.common.n/a') }}
            </p>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            {{ Form::label('created_at', __('Waktu Input').':', ['class' => 'font-weight-bold']) }}<br>
            <span data-toggle="tooltip" data-placement="right"
                title="{{ date('jS M, Y', strtotime($data->created_at)) }}">{{ $data->created_at->isoFormat('LL') }}</span>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            {{ Form::label('updated_at', __('Terakhir Diperbarui').':', ['class' => 'font-weight-bold']) }}<br>
            <span data-toggle="tooltip" data-placement="right"
                title="{{ date('jS M, Y', strtotime($data->updated_at)) }}">{{ $data->updated_at->isoFormat('LL') }}</span>
        </div>
    </div>
</div>
<hr>

<div class="row">
    <div class="col-lg-12 mb-3">
        <b>Detail Pasien</b>
    </div>
    <div class="col-lg-12">
        <div class="row">
            <div class="col-md-5">

            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <!-- Nav tabs -->
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive viewList">
                    <table class=" table table-responsive-sm table-striped table-bordered data-table">
                        <thead>
                            <tr>
                                <th>Kode Faktur Layanan</th>
                                <th>Dokter</th>
                                <th>Deskripsi</th>
                                <th>No.Telp Pasien</th>
                                <th>Tanggal Layanan</th>
                                <th>Biaya</th>
                            </tr>
                        </thead>
                        <tbody id="serviceData">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@push('script')
<script>
    $(document).ready(function(){
        $('.dataTables_length').html(`<div class="form-group">
            <label for="service">Tipe Layanan</label>
            <select name="service" id="service" class="form-control">
                <option disabled selected>Pilih Tipe Layanan</option>
                <option value="generals">Umum</option>
                <option value="family-plannings">Keluarga Berencana</option>
                <option value="pregnancies">Kehamilan</option>
                <option value="laboratories">Laboratorium</option>
                <option value="immunizations">Imunisasi</option>
                <option value="parturitions">Partus</option>
                <option value="electrocardiograms">EKG</option>
                <option value="administrations">Administrasi</option>
            </select>
        </div>`)
    })

</script>
@endpush
