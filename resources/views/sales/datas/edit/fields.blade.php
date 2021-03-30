<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="buyer_type">Tipe Pembeli <span class="required">*</span></label>
            <select name="buyer_type" id="buyer_type" class="form-control">
                <option value="member" {{ $sale->buyer_type == "member" ? "selected":"" }}>Member</option>
                <option value="general" {{ $sale->buyer_type != "member" ? "selected" :"" }}>Umum</option>

            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="date">Tanggal Faktur <span class="required">*</span></label>
            <input type="date" class="form-control" name="date" id="date" value="{{ $sale->receipt_date }}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <input type="hidden" name="discount_hidden" id="discount_hidden" value="{{ $sale->discount }}">
            <label for="discount">Diskon <span class="required">*</span></label>
            <input type="text" class="form-control" name="discount" id="discount" value="@rupiah($sale->discount)">
        </div>
    </div>

    @if ($sale->buyer_type == "member")
    @php
    $generalForm = "display:none;";
    $memberForm = "";
    @endphp
    @else
    @php
    $generalForm = "";
    $memberForm = "display:none;";
    @endphp

    @endif

    <div class="col-md-4 general_form" style="{{ $generalForm }}">
        <div class="form-group">
            <label for="buyer_name">Nama Pembeli</label>
            <input type="text" class="form-control" name="buyer_name" id="buyer_name" value="{{ $sale->buyer_name }}">
        </div>
    </div>
    <div class="col-md-4 member_form " style="{{ $memberForm }}">
        <div class="form-group">
            <label for="member_buyer_name">Nama Pembeli</label>
            <select name="member_buyer_name" id="member_buyer_name" class="form-control">
                @foreach ($patients as $patient)
                <option value="{{ $patient->name}}" {{ $sale->buyer_name == $patient->name ? "selected" : "" }}>
                    {{ $patient->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <input type="hidden" name="tax_hidden" id="tax_hidden" value="{{ $sale->tax }}">
            <label for="tax">Pajak <span class="required">*</span></label>
            <input type="text" class="form-control" name="tax" id="tax" value="@rupiah($sale->tax)">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="medic_id">Dokter (Opsional)</label>
            <select name="medic_id" id="medic_id" class="form-control">
                <option value=""> Pilih Dokter</option>
                @foreach ($medics as $medic)
                <option value="{{ $medic->id }}" {{ $sale->doctor_id == $medic->id ? "selected" : "" }}>
                    {{ $medic->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="payment_method">Tipe Pembayaran <span class="required"></span></label>
            <select name="payment_method" id="payment_method" class="form-control">
                <option value="cash" {{ $sale->payment_method == "cash" ? "selected" : ""}}>Tunai</option>
                <option value="debit" {{ $sale->payment_method != "cash" ? "selected" : "" }}>Debit</option>
            </select>
        </div>
    </div>
</div>
