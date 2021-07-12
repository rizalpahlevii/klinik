<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th style="width: 15%;">Kode Produk</th>

            <th>Jumlah Beli</th>
            <th>Maksimal Stok</th>
            <th>Satuan</th>
            <th>Harga Beli Produk</th>
            <th>Total Harga Beli</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @php
        $subtotal=0;
        @endphp
        @foreach ($carts as $cart)
        <tr>
            <td>{{ $cart['product_code'] }} - {{ $cart['product_name'] }}</td>
            <td class="form-qty">
                <input type="number" class="form-control qty-edit" value="{{ $cart['quantity'] }}">
            </td>
            <td></td>
            <td>{{ $cart['unit'] }}</td>
            <td>@rupiah($cart['price'])</td>
            <td>@rupiah($cart['quantity']*$cart['price'])</td>
            <td>
                <a title="Edit" data-id="{{ $cart['product_id'] }}" class="btn action-btn btn-success btn-sm btn-save">
                    <i class="fa fa-save action-icon"></i>
                </a>
                <a title="<?php echo __('messages.common.delete'); ?>" data-id="{{ $cart['product_id'] }}"
                    class="btn action-btn btn-danger btn-sm delete-btn">
                    <i class="fa fa-trash action-icon"></i>
                </a>
            </td>
        </tr>
        @php
        $subtotal += $cart['quantity']*$cart['price'];
        @endphp
        @endforeach
        <tr>
            <td>
                <select name="product_id" id="product_id" class="form-control">
                    <option disabled>Pilih Dari Kode Produk</option>
                    @foreach ($products as $product)
                    <option value="{{ $product->id }}" data-code="{{ $product->product_code }}"
                        data-id="{{ $product->id }}" data-name="{{ $product->name }}"
                        data-stock="{{ $product->current_stock }}" data-price="{{ $product->selling_price }}"
                        data-unit="{{ $product->unit }}">
                        {{ $product->product_code }} - {{ $product->name }}
                    </option>
                    @endforeach
                </select>
            </td>

            <td><input type="number" class="form-control" id="quantity" value="1" min="1"></td>
            <td><input type="number" class="form-control" id="current_stock" value="1" min="1" readonly></td>
            <td><input type="text" class="form-control" id="unit" readonly></td>
            <td><input type="number" class="form-control" id="price" readonly></td>
            <td><input type="number" class="form-control" id="subtotal" readonly></td>
            <td><button type="button" class="btn btn-success btn-sm add-cart"
                    data-loading-text="<span class='spinner-border spinner-border-sm'></span> Processing...">Tambahkan
                    Faktur</button></td>
        </tr>
    </tbody>
</table>
<div class="row">
    <div class="col-md-3 offset-md-9">
        <table>
            <tr>
                <td>Subtotal </td>
                <td>:</td>
                <td id="subtotal-view">{{ $subtotal }}</td>
            </tr>
            <tr>
                <td>Pajak </td>
                <td>:</td>
                <td id="tax-view"></td>
            </tr>
            <tr>
                <td>Diskon </td>
                <td>:</td>
                <td id="discount-view"></td>
            </tr>
            <tr>
                <td>Total Akhir </td>
                <td>:</td>
                <td id="end-total"></td>
            </tr>
        </table>
    </div>
    <input type="hidden" id="subtotal_hid">
</div>
<script>
    tax = $('#tax_hidden').val();
    discount = $('#discount_hidden').val();
    subtotal = $('#subtotal-view').html();
    endTotal = subtotal - discount - tax;
    $('#tax-view').html(formatRupiah(String(tax)));
    $('#discount-view').html(formatRupiah(String(discount)));
    $('#subtotal-view').html(formatRupiah(String(subtotal)));
    $('#subtotal_hid').val(endTotal);
    $('#end-total').html(formatRupiah(String(endTotal)));
    $(document).on('click','.btn-save',function(){
        qty=$(this).parent().parent().find('.form-qty').find('.qty-edit').val();
        let cartUpdate = `{{ route('sales.cashiers.cart_update',':id') }}`;
        cartUpdate = cartUpdate.replace(':id',$(this).data('id'));
        $.ajax({
            url: cartUpdate,
            type: "PUT",
            dataType: "json",
            data : {
                qty : qty
            },
            success: function(obj) {
                swal({
                    title: "Sukses!",
                    text:   "Produk berhasil diperbarui.",
                    type: "success",
                    timer: 2000
                });
                loadTable();
            },
            error: function(data) {
                swal({
                    title: "",
                    text: data.responseJSON.message,
                    type: "error",
                    timer: 5000
                });
            }
        });
    });
    $(document).on('click','.delete-btn',function(){
        let cartDelete = `{{ route('sales.cashiers.cart_delete',':id') }}`;
        cartDelete=cartDelete.replace(':id',$(this).data('id'));
        console.log(cartDelete);
        $.ajax({
            url: cartDelete,
            type: "DELETE",
            dataType: "json",
            success: function(obj) {
                swal({
                    title: "Terhapus!",
                    text:   "Produk telah terhapus.",
                    type: "success",
                    timer: 2000
                });
                loadTable();
            },
            error: function(data) {
                swal({
                    title: "",
                    text: data.responseJSON.message,
                    type: "error",
                    timer: 5000
                });
            }
        });
    });
    $("#product_id").select2({
        placeholder: "Select an option"
    });
    $("#product_name").select2({
        placeholder: "Select an option"
    });


    $("#product_id").change(function() {
        dataElement = $(this).find('option:selected');
        $('#quantity').attr('max',dataElement.data('stock'));
        $('#current_stock').val(dataElement.data('stock'));
        if(parseInt(dataElement.stock) < 1){
            $('#quantity').attr('disabled');
        }else{
            $('#quantity').removeAttr('disabled');
        }
        $("#unit").val(
           dataElement.data("unit")
        );
        $("#price").val(
           dataElement.data("price")
        );
        $("#subtotal").val(
           dataElement.data("price") * parseInt($("#quantity").val())
        );
    });
    $("#quantity").keyup(function() {
        qty = $(this).val();
        $("#subtotal").val(parseInt(qty) * $("#price").val());
    });

    $(".add-cart").click(function() {
        if ($("#product_id").val() == null) {
            alert("Produk Belum Terpilih");
            return;
        }
        if ($("#quantity").val() == 0) {
            alert("Quantity masih 0");
            return;
        }
        var loadingButton = jQuery(this).find(".add-cart");
        loadingButton.button("loading");
        $.ajax({
            url: addCartUrl,
            method: "post",
            data: {
                product_id: $("#product_id").val(),
                quantity: $("#quantity").val()
            },
            success: function(result) {
                if (result.success) {
                    displaySuccessMessage(result.message);
                    loadTable();
                }else{
                    displayErrorMessage(result.message);
                }
            },
            error: function(result) {
                printErrorMessage("#validationErrorsBox", result);
            },
            complete: function() {
                loadingButton.button("reset");
            }
        });
    });
    function loadTable() {
        $(".table-load").load(cartTableUrl);
    }

    function formatRupiah(angka,prefix){
        if(angka == 0 ){
            return "Rp. 0";
        }else{

            var numberString = angka.replace(/[^,\d]/g, '').toString(),
            split   		= numberString.split(','),
            sisa     		= split[0].length % 3,
            rupiah     		= split[0].substr(0, sisa),
            ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

            if(ribuan){
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return 'Rp. '+ rupiah;
        }
    }
</script>
