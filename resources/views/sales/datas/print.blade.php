<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rincian Obat dan Alkes</title>
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('favicon.ico') }}">
</head>

<body>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12 text-center" style="font-family: 'Times New Roman', Times, serif">
                <h4>
                    <b> KLINIK PRATAMA RAWAT INAP DAN PERSALINAN</b>
                </h4>
                <h2 class="mb-4">
                    <b>
                        “GANESHA HUSADA“
                    </b>
                </h2>
                <p style="margin-top: -20px;">Jl. Hayam Wuruk No.53 Purwodadi</p>
                <p style="margin-top: -20px;">Telp (0292) 421697</p>
                <h5 style="margin-top: -10px;"><b> Grobogan</b></h5>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <h4>Rincian Obat dan Alkes</h4>
            </div>
            <div class="col-md-10 offset-md-1 mt-3">
                <div class="row">
                    <div class="col-md-6">
                        <table>
                            <tr>
                                <td>Tanggal Pembelian</td>
                                <td>:</td>
                                <td>{{ $sale->receipt_date }}</td>
                            </tr>
                            <tr>
                                <td>Tipe Pembeli</td>
                                <td>:</td>
                                <td>{{ $sale->buyer_type == "general" ? "Umum" : "Member" }}</td>
                            </tr>
                            <tr>
                                <td>Nama Pasien</td>
                                <td>:</td>
                                <td>{{ $sale->buyer_name}}</td>
                            </tr>

                        </table>
                    </div>
                    <div class="col-md-6">
                        <table>
                            <tr>
                                <td>Nama Dokter</td>
                                <td>:</td>
                                <td>{{ $sale->medic ? $sale->medic->name : '-' }}</td>
                            </tr>
                            <tr>
                                <td>Kode Nota</td>
                                <td>:</td>
                                <td>{{ $sale->receipt_code }}</td>
                            </tr>
                            <tr>
                                <td>Tipe Pembayaran</td>
                                <td>:</td>
                                <td>{{ $sale->payment_method == "cash"?"Tunai" :"Hutang" }}</td>
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
                        @foreach ($sale->saleItems as $item)
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
