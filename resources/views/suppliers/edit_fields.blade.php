<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {{ Form::label('name_form', __('Nama').':') }}<span class="required">*</span>
            {{ Form::text('name_form', $supplier->name, ['class' => 'form-control','required']) }}
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group mobile-overlapping">
            <div class="form-group">
                <label for="phone_form">No Telp. <span class="required">*</span></label>
                <input type="text" class="form-control" name="phone_form" id="phone_form" required
                    value="{{ $supplier->phone }}">
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            {{ Form::label('address_form', __('Alamat').':') }}<span class="required">*</span>
            {{ Form::text('address_form', $supplier->address, ['class' => 'form-control','required']) }}
        </div>
    </div>

</div>
