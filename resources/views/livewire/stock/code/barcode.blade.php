<div>
    <h6 class="py-1 mb-2">
        <span class="text-muted fw-light"><a href="{{url('dashboard');}}">Dashboard</a> /</span> Barcode Scanner
    </h6>

    <div class="row">
        <div class="col-sm-12 col-md-5">
            <div class="card">
                <div class="card-header">
                    <h4>Scan Barcode</h4>
                </div>
                <div class="card-body">
                    <input type="text" class="form-control" id="barcodeInput" wire:model="barcode" wire:keydown.enter="searchStockCode" placeholder="Enter Stock Code" autofocus>
                    @if ($stock_code)
                    <hr>
                    <div class="row">
                        <div class="col-sm-12">
                            <label class="form-label">Stock Code Details</label>
                            <ul>
                                <li><p>Code: {{ $stock_code->stock_code }}</p></li>
                                <li><p>Name: {{ $stock_code->name }}</p></li>
                                <li><p>Category: {{ $stock_code->stockCategoryID->name ?? '-' }}</p></li>
                                <li><p>Class: {{ $stock_code->stockClassID->name ?? '-' }}</p></li>
                            </ul>
                        </div>
                        <div class="col-sm-12">
                            <label class="form-label">Barcode</label>
                            <p><img src="{{ Storage::url($stock_code->barcode) }}" style="width: 250px; height:200%"></p>
                        </div>
                        <div class="col-sm-12">
                            <label class="form-label">Item Status</label><br>
                            <ul>
                                
                                @foreach($items as $item)
                                    <li><p>Status: {{ $item->status }}</p></li>
                                    <li><p>Quantity: {{ number_format($item->confirm_qty) }}</p></li>
                                    <li><p>Rate: {{ number_format($item->confirm_rate) }}</p></li>
                                    <li><p>Value: {{ number_format($item->confirm_rate * $item->confirm_qty) }}</p></li>
                                @endforeach
                            </ul>
                        </div>
                        <hr>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-7">
            <div class="card">
                <div class="card-header">
                    <h4>Selected Items</h4>
                </div>
                <div class="card-body"></div>
                <div class="card-footer justify-item-center">
                    <a href="#" class="btn btn-outline-success m-3">SRCN</a>
                    <a href="#" class="btn btn-outline-warning m-3">SRIN</a>
                    <a href="#" class="btn btn-outline-danger m-3">SCN</a>
                </div>
            </div>
        </div>
    </div>
</div>
