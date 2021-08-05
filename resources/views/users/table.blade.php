<table class="table table-responsive-sm table-striped table-bordered" id="usersTbl">
    <thead>
        <tr>
            <th>{{ __('Nama Pengguna') }}</th>
            <th>{{ __('Jabatan') }}</th>
            <th>{{ __('No. Telp Pengguna') }}</th>
            <th>{{ __('Alamat') }}</th>
            <th>{{ __('Tanggal Masuk Kerja') }}</th>
            <th>{{ __('Jenis Kelamin') }}</th>
            <th>{{ __('Aksi') }}</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
@push('script')
<script>
    $('.dataTables_length').html('<b>Tabel Daftar Pengguna</b>')
    $('.dataTables_filter').prepend(`<a href="{{ route('users.create') }}" class="btn btn-primary">Tambah Pengguna</a>`)
</script>
@endpush