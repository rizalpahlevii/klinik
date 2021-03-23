<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="buyer_type">Tipe Pembeli <span class="required">*</span></label>
            <select name="buyer_type" id="buyer_type" class="form-control">
                <option value="member">Member</option>
                <option value="general">Umum</option>

            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="date">Tanggal Faktur <span class="required">*</span></label>
            <input type="date" class="form-control" name="date" id="date" value="{{ date('Y-m-d') }}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="discount">Diskon <span class="required">*</span></label>
            <input type="text" class="form-control" name="discount" id="discount" value="0">
        </div>
    </div>

    <div class="col-md-4 general_form" style="display: none;">
        <div class="form-group">
            <label for="buyer_name">Nama Pembeli</label>
            <input type="text" class="form-control" name="buyer_name" id="buyer_name">
        </div>
    </div>
    <div class="col-md-4 member_form ">
        <div class="form-group">
            <label for="member_buyer_name">Nama Pembeli</label>
            <select name="member_buyer_name" id="member_buyer_name" class="form-control">
                @foreach ($patients as $patient)
                <option value="{{ $patient->name}}">{{ $patient->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="tax">Pajak <span class="required">*</span></label>
            <input type="text" class="form-control" name="tax" id="tax" value="0">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="medic_id">Dokter (Opsional)</label>
            <select name="medic_id" id="medic_id" class="form-control">
                <option selected value=""> Pilih Dokter</option>
                @foreach ($medics as $medic)
                <option value="{{ $medic->id }}">{{ $medic->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="payment_method">Tipe Pembayaran <span class="required"></span></label>
            <select name="payment_method" id="payment_method" class="form-control">
                <option value="cash">Tunai</option>
                <option value="credit">Hutang</option>
            </select>
        </div>
    </div>
</div>
