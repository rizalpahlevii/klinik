<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label for="supplier_id">Nama Perusahaan Supplier <span class="required">*</span></label>
            <select name="supplier_id" id="supplier_id" class="form-control">
                <option disabled selected>Pilih Perusahaan Supplier</option>
                @foreach ($suppliers as $supplier)
                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="date">Tanggal Faktur <span class="required">*</span></label>
            <input type="date" class="form-control" name="date" id="date" value="{{ date('Y-m-d') }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="discount">Diskon <span class="required">*</span></label>
            <input type="text" class="form-control" name="discount" id="discount" value="0">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="file">Foto Faktur <span class="required">*</span></label>
            <input type="file" class="form-control" name="file" id="file" value="0">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="salesman_id">Nama Sales <span class="required">*</span></label>
            <select name="salesman_id" id="salesman_id" class="form-control">
                <option disabled selected>Pilih Sales</option>

            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="tax">Pajak <span class="required">*</span></label>
            <input type="text" class="form-control" name="tax" id="tax" value="0">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="receipt_code">Kode Faktur <span class="required">*</span></label>
            <input type="text" class="form-control" name="receipt_code" id="receipt_code"
                value="{{ getUniqueString() }}">
        </div>
    </div>

</div>
