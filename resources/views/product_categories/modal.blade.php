<div id="addModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Tambah Kategori') }}</h5>
                <button type="button" aria-label="Close" class="close" data-dismiss="modal">×</button>
            </div>
            {{ Form::open(['id'=>'addNewForm']) }}
            <div class="modal-body">
                <div class="alert alert-danger display-none" id="validationErrorsBox"></div>
                <div class="row">
                    <div class="form-group col-sm-12">
                        {{ Form::label('category_name', __('Nama Kategori').(':')) }}<span class="required">*</span>
                        {{ Form::text('category_name', '', ['id'=>'category_name','class' => 'form-control','required']) }}
                    </div>
                </div>
                <div class="text-right">
                    {{ Form::button(__('Simpan'), ['type'=>'submit','class' => 'btn btn-primary','id'=>'btnSave','data-loading-text'=>"<span class='spinner-border spinner-border-sm'></span> Processing..."]) }}
                    <button type="button" class="btn btn-light ml-1" data-dismiss="modal">{{ __('Batal') }}</button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
