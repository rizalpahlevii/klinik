<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="name">Nama Pengeluaran <span class="required">*</span></label>
            <input type="text" class="form-control" name="name" id="name" required>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="type">Jenis Pengeluaran <span class="required"></span></label>
            <select name="type" id="type" class="form-control">
                <option disabled selected>Pilih Jenis Pengeluaran</option>
                <option value="salary">Salary</option>
                <option value="office_supplies">Keperluan Kantor</option>
                <option value="operational">Operasional</option>
                <option value="non_operational">Non Operasional</option>
            </select>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="amount">Jumlah Pengeluaran <span class="required">*</span></label>
            <input type="string" class="form-control" name="amount" id="amount" required>
        </div>
    </div>
</div>
