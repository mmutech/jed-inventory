<div>
    <h6 class="py-1 mb-3">
        <span class="text-muted fw-light"><a href="{{url('request-index');}}">Available Request</a> /</span> Item Request
    </h6>

    <div class="row">
        <div class="col-sm-12 col-md-5">
            <div class="card">
                <div class="card-header d-flex justify-content-center align-item-center">
                    <button class="btn btn-outline-primary" wire:click="scnId">SCN</button>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 mb-3">
                            <input type="text" class="form-control" value="{{ $referenceId }}" placeholder="Reference Number" disabled>
                        </div>
                        <div class="col-sm-12">
                            <form wire:submit="addReqStock">
                                <div class="row">
                                    <div class="col-sm-12 mb-3">
                                        <input type="text" class="form-control" wire:model="work_location" disabled>
                                    </div>
                                    <div class="col-sm-12 mb-3">
                                        <textarea class="form-control" wire:model="job_description" disabled></textarea>
                                    </div>

                                    <div class="col-sm-12 mb-3">
                                        <select class="form-control select2" wire:model="stockCode" id="drps">
                                            <option value="">Select...</option>
                                            @foreach($stock_code as $stCode)
                                                <option value="{{$stCode->id}}">{{$stCode->stock_code}} - {{$stCode->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('stockCode') <span class="error">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-sm-12 mb-3">
                                        <input type="number" class="form-control" wire:model="quantity_returned" placeholder="Enter Quantity Returned">
                                        @error('quantity_returned') <span class="error">{{ $message }}</span> @enderror
                                    </div>
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
                            <th>Quantity Returned</th>
                        </thead>

                        @foreach($stocks as $stock)
                        <tbody>
                            <td>{{ $stock['referenceId'] }}</td>
                            <td>{{ $stock['stockCode'] }}</td>
                            <td>{{ $stock['quantity_returned'] }}</td>
                        </tbody>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>