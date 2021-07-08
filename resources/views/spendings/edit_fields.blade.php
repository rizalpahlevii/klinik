<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="name">Nama Pengeluaran <span class="required">*</span></label>
            <input type="text" class="form-control" name="name" id="name" required value="{{ $spending->name }}">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="type">Jenis Pengeluaran <span class="required"></span></label>
            <select name="type" id="type" class="form-control">
                <option disabled selected>Pilih Jenis Pengeluaran</option>
                <option value="salary" {{ $spending->type == "salary" ? "selected" : "" }}>Salary</option>
                <option value="office_supplies" {{ $spending->type == "office_supplies" ? "selected" : "" }}>Keperluan
                    Kantor
                </option>
                <option value="operational" {{ $spending->type == "operational" ? "selected" : "" }}>Operasional
                </option>
                <option value="non_operational" {{ $spending->type == "non_operational" ? "selected" : "" }}>Non
                    Operasional
                </option>
            </select>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="amount">Jumlah Pengeluaran <span class="required">*</span></label>
            <input type="string" class="form-control" name="amount" id="amount" required value="{{ $amount }}">
        </div>
    </div>
</div>
