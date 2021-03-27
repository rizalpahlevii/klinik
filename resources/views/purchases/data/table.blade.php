<table class="table table-responsive-sm table-striped table-bordered" id="purchasesTable">
    <thead>
        <tr>
            <th>Kode Faktur</th>
            <th>Nama Perusahaan Supplier</th>
            <th>Nama Sales</th>
            <th>Tanggal Faktur</th>
            <th>Total Harga</th>
            @if (auth()->user()->hasRole('admin'))
            <th>Aksi</th>
            @endif
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
