<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th style="width: 15%;">Kode Produk</th>
            <th>Nama Produk</th>
            <th>Jumlah Beli</th>
            <th>Satuan</th>
            <th>Harga Beli Produk</th>
            <th>Total Harga Beli</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody id="table-tbody-cart">
        @php
        $subtotal=0;
        @endphp
        @foreach ($sale->saleItems as $saleItem)
        <tr>
            <td>
                <select name="product_id[]" class="form-control select2 product-id">
                    <option disabled>Pilih Dari Kode Produk</option>
                    @foreach ($products as $product)
                    <option {{ $product->id == $saleItem->product_id ? 'selected':'' }} value="{{ $product->id }}"
                        data-name="{{ $product->name }}" data-id="{{ $product->id }}"
                        data-price="{{ $product->selling_price }}" data-unit="{{ $product->unit }}">
                        {{ $product->product_code }}
                    </option>
                    @endforeach
                </select>
            </td>
            <td>
                <select name="product_name[]" class="form-control select2 product-name">
                    <option disabled>Pilih Dari Nama Produk</option>
                    @foreach ($products as $product)
                    <option value="{{ $product->name }}" {{ $product->id == $saleItem->product_id ? 'selected':'' }}
                        data-id="{{ $product->id }}" data-name="{{ $product->name }}"
                        data-price="{{ $product->selling_price }}" data-unit="{{ $product->unit }}">
                        {{ $product->name }}
                    </option>
                    @endforeach
                </select>
            </td>
            <td>
                <input type="number" class="form-control quantity" name="quantity[]" value="{{ $saleItem->quantity }}">
            </td>
            <td>
                <input type="text" class="form-control" name="unit[]" readonly value="{{ $saleItem->product->unit }}">
            </td>
            <td>
                <input type="text" class="form-control price" name="price[]" readonly
                    value="@rupiah($saleItem->current_price)">
            </td>
            <td>
                <input type="text" class="form-control subtotal" name="subtotal[]" readonly
                    value="@rupiah($saleItem->total)">
            </td>
            <td>
                <a title="<?php echo __('messages.common.delete'); ?>" data-id="{{ $saleItem->id }}"
                    class="btn action-btn btn-danger btn-sm delete-btn">
                    <i class="fa fa-trash action-icon"></i>
                </a>
            </td>
        </tr>
        @php
        $subtotal += $saleItem->quantity*$saleItem['current_price'];
        @endphp
        @endforeach

    </tbody>
</table>
<div class="row">
    <div class="col-md-3 offset-md-9">
        <table>
            <tr>
                <td>Subtotal </td>
                <td>:</td>
                <td id="subtotal-view">@rupiah($subtotal)</td>
            </tr>
            <tr>
                <td>Pajak </td>
                <td>:</td>
                <td id="tax-view">@rupiah($sale->tax)</td>
            </tr>
            <tr>
                <td>Diskon </td>
                <td>:</td>
                <td id="discount-view">@rupiah($sale->discount)</td>
            </tr>
            <tr>
                <td>Total Akhir </td>
                <td>:</td>
                <td id="end-total">@rupiah($sale->grand_total)</td>
            </tr>
        </table>
    </div>
    <input type="hidden" id="subtotal_hid" value="{{ $subtotal }}">
</div>
