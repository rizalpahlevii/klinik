<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan</title>
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
</head>

<body>
    <div class="container">
        <div class="print-area">

            <div class="row mt-3">
                <div class="col-md-12">
                    <h4 class="text-primary">Laporan {{ convertMonthNumber2(request()->get('month-start')) }}
                        {{ request()->get('year-start') }}
                        - {{ convertMonthNumber2(request()->get('month-end')) }} {{ request()->get('year-end') }}</h4>
                </div>
                <div class="col-md-12 mt-5">
                    <h6>Pemasukan : <span class="text-success">+@rupiah($saleSum + $generalServiceSum +
                            $pregnancyServiceSum
                            + $laboratoryServiceSum + $familyPlanningServiceSum)</span></h6>
                    <h6>Pembelian Supply Barang : <span class="text-danger">-@rupiah($purchaseSum)</span></h6>
                    @php
                    $total=($saleSum + $generalServiceSum + $pregnancyServiceSum
                    + $laboratoryServiceSum + $familyPlanningServiceSum) - $purchaseSum;
                    @endphp
                    <h6>Total : <span class="text-{{ $total <= 0 ? 'danger':'success' }}">
                            @rupiah($total)</span></h6>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h6>Pemasukan</h6>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nota</th>
                                        <th>Nama Pembeli</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $no=1;
                                    $grandTotal=0;
                                    @endphp
                                    @foreach ($sale as $saleItem)
                                    <tr>
                                        <td>{{ $no }}</td>
                                        <td>{{ $saleItem->receipt_code }}</td>
                                        <td>{{ $saleItem->buyer_name }}</td>
                                        <td>@rupiah($saleItem->grand_total)</td>
                                    </tr>
                                    @php
                                    $no++;
                                    $grandTotal +=$saleItem->grand_total;
                                    @endphp
                                    @endforeach

                                    @foreach ($generalService as $generalServiceItem)
                                    <tr>
                                        <td>{{ $no }}</td>
                                        <td>{{ $generalServiceItem->service_number }}</td>
                                        <td>{{ $generalServiceItem->patient->name }}</td>
                                        <td>@rupiah($generalServiceItem->total_fee)</td>
                                    </tr>
                                    @php
                                    $no++;
                                    $grandTotal +=$generalServiceItem->total_fee;
                                    @endphp
                                    @endforeach

                                    @foreach ($pregnancyService as $pregnancyServiceItem)
                                    <tr>
                                        <td>{{ $no }}</td>
                                        <td>{{ $pregnancyServiceItem->service_number }}</td>
                                        <td>{{ $pregnancyServiceItem->patient->name }}</td>
                                        <td>@rupiah($pregnancyServiceItem->total_fee)</td>
                                    </tr>
                                    @php
                                    $no++;
                                    $grandTotal +=$pregnancyServiceItem->total_fee;
                                    @endphp
                                    @endforeach

                                    @foreach ($laboratoryService as $laboratoryServiceItem)
                                    <tr>
                                        <td>{{ $no }}</td>
                                        <td>{{ $laboratoryServiceItem->service_number }}</td>
                                        <td>{{ $laboratoryServiceItem->patient->name }}</td>
                                        <td>@rupiah($laboratoryServiceItem->total_fee)</td>
                                    </tr>
                                    @php
                                    $no++;
                                    $grandTotal +=$laboratoryServiceItem->total_fee;
                                    @endphp
                                    @endforeach

                                    @foreach ($familyPlanningService as $familyPlanningServiceItem)
                                    <tr>
                                        <td>{{ $no }}</td>
                                        <td>{{ $familyPlanningServiceItem->service_number }}</td>
                                        <td>{{ $familyPlanningServiceItem->patient->name }}</td>
                                        <td>@rupiah($familyPlanningServiceItem->total_fee)</td>
                                    </tr>
                                    @php
                                    $no++;
                                    $grandTotal +=$familyPlanningServiceItem->total_fee;
                                    @endphp
                                    @endforeach
                                </tbody>
                            </table>
                            <h5>Grand Total : <span class="text-success">+@rupiah($grandTotal)</span></h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h6>Pembelian Supply Barang</h6>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Kode Nota</th>
                                        <th>Nama Supplier</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $purchaseTotal = 0;
                                    @endphp
                                    @foreach ($purchase as $purchaseItem)
                                    <tr>
                                        <td>{{ $purchaseItem->receipt_code }}</td>
                                        <td>{{ $purchaseItem->supplier->name }}</td>
                                        <td>{{ $purchaseItem->grand_total }}</td>
                                    </tr>
                                    @php
                                    $purchaseTotal +=$purchaseItem->grand_total;
                                    @endphp
                                    @endforeach
                                </tbody>
                            </table>
                            <h5>Grand Total : <span class="text-danger">-@rupiah($purchaseTotal)</span></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-warning btn-print float-right"> Print</button>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('.btn-print').click(function(){
                $(this).attr('hidden','hidden');
                window.print();
                $(this).removeAttr('hidden');
            });
        });
    </script>
</body>

</html>
