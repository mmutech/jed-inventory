<div>
    <h6 class="py-1 mb-3">
        <span class="text-muted fw-light"><a href="{{url('request-index');}}">Available Request</a> /</span> Item Request
    </h6>

    <div class="row">
        <div class="col-sm-12 col-md-5">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <button class="btn btn-outline-success" wire:click="srcnId">SRCN</button>
                    <button class="btn btn-outline-warning" wire:click="srinId">SRIN</button>
                    <!-- <button class="btn btn-outline-danger" wire:click="scnId">SCN</button> -->
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 mb-3">
                            <input type="text" class="form-control" value="{{ $referenceId }}" disabled>
                        </div>
                        <div class="col-sm-12">
                            <form wire:submit="addReqStock">
                                <div class="row">
                                    <div class="col-sm-12 mb-3">
                                        <select class="form-control" wire:model.live="selectedStockCode" id="stockCode">
                                            <option value="">Select...</option>
                                            @foreach($stock_code as $stCode)
                                                <option value="{{$stCode->id}}">{{$stCode->stock_code}} - {{$stCode->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('stockCode') <span class="error">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-sm-6 mb-3">
                                        <input type="number" class="form-control" wire:model="quantity_required" placeholder="Enter Quantity">
                                        @error('quantity_required') <span class="error">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-sm-6 mb-3">
                                        <input type="text" class="form-control" value="{{ $stockCount . ' Remain' }}" disabled>
                                    </div>
                                    @if($showInputFields)
                                    <div class="col-sm-12 mb-3">
                                        <input type="text" class="form-control" wire:model="work_location" placeholder="Location Of Work">
                                        @error('work_location') <span class="error">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-sm-12 mb-3">
                                        <textarea class="form-control" wire:model="job_description" placeholder="Job Description"></textarea>
                                        @error('job_description') <span class="error">{{ $message }}</span> @enderror
                                    </div>
                                    @endif
                                    <div class="col-sm-12 mb-3 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-outline-primary"><i class='bx bx-cart-add'></i> Add</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-7">
            <div class="card">
                <div class="card-header" style="border-bottom: 1px solid black;">
                    Selected Items
                </div>
                <div class="card-body">
                    <table class="table table-responsive text-nowrap">
                        <thead>
                            <th>Reference Number</th>
                            <th>Stock Code</th>
                            <th>Quantity</th>
                        </thead>

                        @foreach($stocks as $stock)
                        <tbody>
                            <td>{{ $stock['referenceId'] }}</td>
                            <td>{{ $stock['stockCode'] }}</td>
                            <td>{{ $stock['quantity_required'] }}</td>
                        </tbody>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>