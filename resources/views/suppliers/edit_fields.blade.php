<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {{ Form::label('name_form', __('Nama').':') }}<span class="required">*</span>
            {{ Form::text('name_form', $supplier->name, ['class' => 'form-control','required']) }}
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group mobile-overlapping">
            {{ Form::label('phone_form', __('No.Telp').':') }}<span class="required">*</span><br>
            {{ Form::tel('phone_form', $supplier->phone, ['class' => 'form-control','id' => 'phoneNumber','required', 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")']) }}
            {{ Form::hidden('prefix_code',null,['id'=>'prefix_code']) }}
            <span id="valid-msg" class="hide">✓ &nbsp; Valid</span>
            <span id="error-msg" class="hide"></span>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            {{ Form::label('address_form', __('Alamat').':') }}<span class="required">*</span>
            {{ Form::text('address_form', $supplier->address, ['class' => 'form-control','required']) }}
        </div>
    </div>

</div>
