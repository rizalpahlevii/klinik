<table class="table table-responsive-sm table-striped" id="patientsTable">
    <thead>
        <tr>
            <th>Nomor</th>
            <th>Nama Pasien</th>
            <th>Alamat</th>
            <th>No. Telp</th>
            <th>Golongan Darah</th>
            <th>Kota</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
@push('script')
<style>

</style>
<script>
    $('.dataTables_length').html('<b>Tabel Daftar Pasien</b>')
    $('.dataTables_filter').prepend(`<a class="btn btn-lightgreen mr-2" href="{{ route('patients.create') }}">Input Pasien</a>`)
</script>
@endpush