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
        @foreach ($purchase->purchaseItems as $item)
        <tr>
            <td>
                <select class="form-control product-id" name="product_id[]">
                    <option disabled selected>Pilih Produk</option>
                    @foreach ($products as $product)
                    <option value="{{ $product->id }}" data-name="{{ $product->name }}"
                        {{ $product->id == $item->product_id ? 'selected':'' }}
                        data-price="{{ $product->selling_price }}" data-unit="{{ $product->unit }}">
                        {{ $product->product_code }}
                    </option>
                    @endforeach
                </select>
            </td>
            <td>
                <input type="text" class="form-control product-name" value="{{ $item->product->name }}" readonly>
            </td>
            <td>
                <input type="text" name="quantity[]" class="form-control quantity" value="{{ $item->quantity }}">
            </td>
            <td>
                <input type="text" class="form-control unit" value="{{ $item->product->unit }}" readonly>
            </td>
            <td>
                <input type="text" name="price[]" class="form-control price" value="{{ $item->current_price }}">

            </td>
            <td>
                <input type="text" class="form-control subtotal" value="{{ $item->quantity*$item->current_price }}">
            </td>
            <td>
                <a title="<?php echo __('messages.common.delete'); ?>" data-id="{{ $item->product_id }}"
                    class="btn action-btn btn-danger btn-sm delete-btn">
                    <i class="fa fa-trash action-icon"></i>
                </a>
            </td>
        </tr>
        @php
        $subtotal += $item->quantity*$item->current_price;
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
                <td id="tax-view">@rupiah($purchase->tax)</td>
            </tr>
            <tr>
                <td>Diskon </td>
                <td>:</td>
                <td id="discount-view">@rupiah($purchase->discount)</td>
            </tr>
            <tr>
                <td>Total Akhir </td>
                <td>:</td>
                <td id="end-total">@rupiah($purchase->grand_total)</td>
            </tr>
        </table>
    </div>
    <input type="hidden" id="subtotal_hid">
</div>
