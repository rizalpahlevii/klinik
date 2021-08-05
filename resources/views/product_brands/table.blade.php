<table class="table table-responsive-sm table-striped table-bordered" id="brandsTbl">
    <thead>
        <tr>
            <th>Merek</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
@push('script')
<script>
    $('.dataTables_length').html('<b>Tabel Daftar Merek Produk</b>')
    $('.dataTables_filter').prepend(`<a href="#" class="btn btn-lightgreen" data-toggle="modal" data-target="#addModal">Tambah Merek</a>`)
</script>
@endpush