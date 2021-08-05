<table class="table table-responsive-sm table-striped table-bordered" id="medicsTable">
    <thead>
        <tr>
            <th>Nomor</th>
            <th>Nama</th>
            <th>Spesialisasi</th>
            <th>Alamat</th>
            <th>No. Telp</th>
            <th>Jenis Kelamin</th>
            <th>Kota</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
@push('script')
<script>
    $('.dataTables_length').html('<b>Tabel Daftar Dokter</b>')
    $('.dataTables_filter').prepend(`<a class="btn btn-lightgreen mr-2" href="{{ route('medics.create') }}">Input Dokter</a>`)
</script>
@endpush