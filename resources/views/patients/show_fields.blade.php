<div class="row view-spacer">
    <div class="col-md-3">
        <div class="form-group">
            {{ Form::label('full_name', __('Nama Pasien').':', ['class' => 'font-weight-bold']) }}
            <p>{{ $data->name }}</p>
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
            <p>{{ !empty($data->birth_date) ? $data->birth_date : __('messages.common.n/a') }}</p>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            {{ Form::label('created_at', __('Waktu Input').':', ['class' => 'font-weight-bold']) }}<br>
            <span data-toggle="tooltip" data-placement="right"
                title="{{ date('jS M, Y', strtotime($data->created_at)) }}">{{ $data->created_at->diffForHumans() }}</span>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            {{ Form::label('updated_at', __('Terakhir Diperbarui').':', ['class' => 'font-weight-bold']) }}<br>
            <span data-toggle="tooltip" data-placement="right"
                title="{{ date('jS M, Y', strtotime($data->updated_at)) }}">{{ $data->updated_at->diffForHumans() }}</span>
        </div>
    </div>
</div>
<hr>

<div class="row">
    <div class="col-lg-12">
        <h4>Detail Pasien</h4>
    </div>
    <div class="col-lg-12">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs mt-2">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#general-service">{{ __('Layanan Umum') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#family-planning-service">{{ __('Layanan KB') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#pregnancy-service">{{ __('Layanan Kehamilan') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#laboratory-service">{{ __('Layanan Laboratorium') }}</a>
            </li>
        </ul>

        <div class="tab-content">
            {{--             Patient Cases --}}
            <div class="tab-pane active" id="general-service">
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
                                <tbody>
                                    @foreach ($data->generalServices as $service)
                                    <tr>
                                        <td>
                                            <a href="{{ route('services.generals.show',$service->id) }}">{{ $service->service_number }}
                                            </a>
                                        </td>
                                        <td>
                                            <a
                                                href="{{ route('medics.show',$service->medic->id) }}">{{ $service->medic->name }}</a>
                                        </td>
                                        <td>{{ $service->notes }}</td>
                                        <td>{{ $service->phone }}</td>
                                        <td>{{ $service->registration_time }}</td>
                                        <td>{{  $service->total_fee  }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="family-planning-service">
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
                                <tbody>
                                    @foreach ($data->familyPlanningServices as $service)
                                    <tr>
                                        <td>
                                            <a href="{{ route('services.family_plannings.show',$service->id) }}">{{ $service->service_number }}
                                            </a>
                                        </td>
                                        <td>
                                            <a
                                                href="{{ route('medics.show',$service->medic->id) }}">{{ $service->medic->name }}</a>
                                        </td>
                                        <td>{{ $service->notes }}</td>
                                        <td>{{ $service->phone }}</td>
                                        <td>{{ $service->registration_time }}</td>
                                        <td>{{  $service->total_fee  }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="pregnancy-service">
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
                                <tbody>
                                    @foreach ($data->pregnancyServices as $service)
                                    <tr>
                                        <td>
                                            <a href="{{ route('services.pregnancies.show',$service->id) }}">{{ $service->service_number }}
                                            </a></td>
                                        <td>
                                            <a
                                                href="{{ route('medics.show',$service->medic->id) }}">{{ $service->medic->name }}</a>
                                        </td>
                                        <td>{{ $service->notes }}</td>
                                        <td>{{ $service->phone }}</td>
                                        <td>{{ $service->registration_time }}</td>
                                        <td>{{  $service->total_fee  }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="laboratory-service">
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
                                <tbody>
                                    @foreach ($data->laboratoryServices as $service)
                                    <tr>
                                        <td>
                                            <a href="{{ route('services.laboratories.show',$service->id) }}">{{ $service->service_number }}
                                            </a>
                                        </td>
                                        <td>
                                            <a
                                                href="{{ route('medics.show',$service->medic->id) }}">{{ $service->medic->name }}</a>
                                        </td>
                                        <td>{{ $service->notes }}</td>
                                        <td>{{ $service->phone }}</td>
                                        <td>{{ $service->registration_time }}</td>
                                        <td>{{  $service->total_fee  }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
