<div class="row view-spacer">
    <div class="col-md-3">
        <div class="form-group">
            {{ Form::label('full_name', __('Nama Supplier').':', ['class' => 'font-weight-bold']) }}
            <p>{{ $supplier->name }}</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            {{ Form::label('phone', __('No.Telp Supplier').':', ['class' => 'font-weight-bold']) }}
            <p>{{ !empty($supplier->phone)?$supplier->phone:__('messages.common.n/a') }}</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            {{ Form::label('address', __('Alamat Supplier').':', ['class' => 'font-weight-bold']) }}
            <p>{{ !empty($supplier->address)?$supplier->address:__('messages.common.n/a') }}</p>
        </div>
    </div>


    <div class="col-md-3">
        <div class="form-group">
            {{ Form::label('created_at', __('Waktu Input').':', ['class' => 'font-weight-bold']) }}<br>
            <span data-toggle="tooltip" data-placement="right"
                title="{{ date('jS M, Y', strtotime($supplier->created_at)) }}">{{ $supplier->created_at->diffForHumans() }}</span>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            {{ Form::label('updated_at', __('Terakhir Diperbarui').':', ['class' => 'font-weight-bold']) }}<br>
            <span data-toggle="tooltip" data-placement="right"
                title="{{ date('jS M, Y', strtotime($supplier->updated_at)) }}">{{ $supplier->updated_at->diffForHumans() }}</span>
        </div>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-lg-12">
        <h4>Data Salesman</h4>
    </div>
    <div class="col-lg-6 col-md-6">
        <table class="table table-bordered table-stripped" id="salesmansTbl">
            <thead>
                <tr>
                    <th>Nama Sales</th>
                    <th>No Telp. Sales</th>
                    <th>Hapus Sales</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
                <tr>
                    <td>
                        <input type="text" id="salesman_name" class="form-control">
                    </td>
                    <td>
                        <input type="text" id="salesman_phone" class="form-control">
                    </td>
                    <td>
                        <button class="btn btn-success btn-sm btn-save-salesman">Simpan</button>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
