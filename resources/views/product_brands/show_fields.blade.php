<div class="row view-spacer">
    <div class="col-md-3">
        <div class="form-group">
            {{ Form::label('full_name', __('Nama Merek').':', ['class' => 'font-weight-bold']) }}
            <p>{{ $brand->brand_name }}</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            {{ Form::label('created_at', __('Waktu Input').':', ['class' => 'font-weight-bold']) }}<br>
            <span data-toggle="tooltip" data-placement="right"
                title="{{ date('jS M, Y', strtotime($brand->created_at)) }}">{{ $brand->created_at->diffForHumans() }}</span>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            {{ Form::label('updated_at', __('Terakhir Diperbarui').':', ['class' => 'font-weight-bold']) }}<br>
            <span data-toggle="tooltip" data-placement="right"
                title="{{ date('jS M, Y', strtotime($brand->updated_at)) }}">{{ $brand->updated_at->diffForHumans() }}</span>
        </div>
    </div>
</div>
<hr>


<div class="row">
    <div class="col-lg-12">
        <h4>Data Produk</h4>
    </div>
    <div class="col-lg-12">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs mt-2">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#product">{{ __('Produk') }}</a>
            </li>
        </ul>

        <div class="tab-content">
            {{--             Patient Cases --}}
            <div class="tab-pane active" id="product">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive viewList">
                            <table class="table table-striped table-bordered product-table">
                                <thead>
                                    <tr>
                                        <th>Nama Produk</th>
                                        <th>Harga Jual</th>
                                        <th>Kategori Produk</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                    <tr>
                                        <td>
                                            {{ $product->name }}
                                        </td>
                                        <td>
                                            @rupiah($product->selling_priee)
                                        </td>
                                        <td>{{ $product->category->category_name }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
