<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Faktur</title>
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('favicon.ico') }}">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <p>www.klinikpratamaganeshautama.com</p>
                <p style="margin-top: -20px;">Jl. Kolonel Sugiono. 285</p>
                <p style="margin-top: -20px;">Purwodadi</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <h4>Data Faktur</h4>
            </div>
            <div class="col-md-10 offset-md-1 mt-3">
                <div class="row">
                    <div class="col-md-6">
                        <table>

                            <tr>
                                <td>Nama Supplier</td>
                                <td>:</td>
                                <td>{{ $sale->supplier->name }}</td>
                            </tr>
                            <tr>
                                <td>Nama Sales</td>
                                <td>:</td>
                                <td>{{ $sale->salesman->salesman_name}}</td>
                            </tr>

                        </table>
                    </div>
                    <div class="col-md-6">
                        <table>
                            <tr>
                                <td>Tanggal Pembelian</td>
                                <td>:</td>
                                <td>{{ $sale->receipt_date }}</td>
                            </tr>
                            <tr>
                                <td>Kode Nota</td>
                                <td>:</td>
                                <td>{{ $sale->receipt_code }}</td>
                            </tr>

                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <p>
                ........................................................................................................................................................................................................................................................................................................................................
            </p>
            <div class="col-md-12">
                <table style="width: 100%;" class="text-center">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Total</th>
                        </tr>

                    </thead>
                    <tbody>
                        @foreach ($sale->purchaseItems as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>@rupiah($item->current_price)</td>
                            <td>@rupiah($item->total)</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <hr style="border: 1px solid black;">
        <div class="row">
            <div class="col-md-8"></div>
            <div class="col-md-4">
                <table style="width: 100%;">
                    <tr style="width: 70%;">
                        <td>Sub Total</td>
                        <td>@rupiah($sale->sub_total)</td>
                    </tr>
                    <tr>
                        <td>Pajak</td>
                        <td>@rupiah($sale->tax)</td>
                    </tr>
                    <tr>
                        <td>Diskon</td>
                        <td>@rupiah($sale->discount)</td>
                    </tr>
                    <tr>
                        <td>Harus Bayar</td>
                        <td>@rupiah($sale->grand_total)</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
</body>

</html>
