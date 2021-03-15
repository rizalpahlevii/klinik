<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="product_code">Kode Produk <span class="required">*</span></label>
            <input type="text" class="form-control" name="product_code" id="product_code" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {{ Form::label('product_name', __('Nama Produk').':') }}<span class="required">*</span>
            {{ Form::text('product_name', null, ['class' => 'form-control','required']) }}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="category_id">Kategori Produk <span class="required"></span></label>
            <select name="category_id" id="category_id" class="form-control">
                <option disabled selected>Pilih Kategori Produk</option>
                @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="brand_id">Merek Produk <span class="required">*</span></label>
            <select name="brand_id" id="brand_id" class="form-control">
                <option disabled selected>Pilih Merek Produk</option>
                @foreach ($brands as $brand)
                <option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="unit">Satuan <span class="required">*</span></label>
            <input type="text" class="form-control" name="unit" id="unit">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="selling_price">Harga Jual <span class="required">*</span></label>
            <input type="number" class="form-control" name="selling_price" id="selling_price">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="total_minimum_stock">Jumlah Minimum Stok <span class="required">*</span></label>
            <input type="number" class="form-control" name="total_minimum_stock" id="total_minimum_stock">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="side_effects">Efek Samping <span class="required">*</span></label>
            <textarea name="side_effects" id="side_effects" cols="30" rows="5" class="form-control"></textarea>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="notes">Catatan</label>
            <textarea name="notes" id="notes" cols="30" rows="5" class="form-control"></textarea>
        </div>

    </div>
</div>
