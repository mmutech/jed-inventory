<div>
    <h6 class="py-1 mb-2">
        <span class="text-muted fw-light"><a href="{{url('request-index');}}">Available Request</a> /</span> Check Out
    </h6>

    <div class="row">
        <div class="col-sm-12 col-md-5">
            <div class="card">
                <div class="card-header">
                    <h4>Scan Barcode/Enter Stock Code</h4>
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
                            <form wire:submit="addReqStock">
                                <div class="row">
                                    <div class="col-sm-12 col-md-8 mb-3">
                                        <input type="text" class="form-control" wire:model="stock_code('{{$stock_code->id}}')" placeholder="Enter Stock Code" value="{{ $stock_code->stock_code }}" hidden>
                                        <input type="number" class="form-control" wire:model="quantity_allocated('{{$item->quantity}}')" placeholder="Enter Quantity" value="{{ $item->quantity }}" disabled>
                                    </div>
                                    <div class="col-sm-12 col-md-4 mb-3">
                                        <button type="submit" class="btn btn-outline-primary">Add</button>
                                    </div>
                                </div>
                            </form>
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
                    <h4>Check In Items</h4>
                </div>
                <div class="card-body">
                    <table class="table table-responsive text-nowrap">
                        <thead>
                            <th>Reference Number</th>
                            <th>Stock Code</th>
                            <th>Quantity</th>
                        </thead>

                        @if($stocks)
                            @foreach($stocks as $stock)
                            <tbody>
                                <td>{{ $stock['referenceId'] }}</td>
                                <td>{{ $stock['stock_code'] }}</td>
                                <td>{{ $stock['quantity_allocated'] }}</td>
                            </tbody>
                            @endforeach
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>