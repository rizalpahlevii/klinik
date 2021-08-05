<table class="table table-responsive-sm table-striped table-bordered" id="suppliersTable">
    <thead>
        <tr>
            <th>Nomor</th>
            <th>Nama Supplier</th>
            <th>No. Telp</th>
            <th>Alamat</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
@push('script')
<script>
    $('.dataTables_length').html('<b>Tabel Daftar Kategori Supplier</b>')
    $('.dataTables_filter').prepend(`<a href="{{ route('suppliers.create') }}" class="btn btn-lightgreen">
        Input Supplier
    </a>`)
</script>
@endpush