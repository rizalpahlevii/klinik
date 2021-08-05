<table class="table table-responsive-sm table-striped table-bordered" id="productsTable">
    <thead>
        <tr>
            <th>Nama Produk</th>
            <th>Merek Produk</th>
            <th>Harga Jual</th>
            <th>Kategori Produk</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
@push('script')
<script>
    $('.dataTables_length').html('<b>Tabel Daftar Produk</b>')
    $('.dataTables_filter').prepend(`<a href="{{ route('products.create') }}" class="btn btn-lightgreen">
        Input Produk
    </a>`)
</script>
@endpush