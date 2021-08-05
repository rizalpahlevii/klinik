<table class="table table-responsive-sm table-striped table-bordered" id="categoriesTbl">
    <thead>
        <tr>
            <th>{{ __('Nama Kategori') }}</th>
            <th>{{ __('Aksi') }}</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
@push('script')
<script>
    $('.dataTables_length').html('<b>Tabel Daftar Kategori Produk</b>')
    $('.dataTables_filter').prepend(`<a href="#" class="btn btn-lightgreen" data-toggle="modal" data-target="#addModal">Tambah Kategori</a>`)
</script>
@endpush