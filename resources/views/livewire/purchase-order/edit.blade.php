<div>
    <h6 class="py-1 mb-2">
    <span class="text-muted fw-light"><a href="{{url('purchase-order');}}">Purchase Order</a> /</span> {{$title}}
    </h6>

    <div class="card">
        <div class="card-header">
            <h6 class="mb-0">Purchase Order Details</h6>
            <small>Modify Your Purchase Order Details.</small>
        </div>
        <hr class="my-1">
        <div class="card-body">
          <!-- Purchase Order Details -->
            <form wire:submit="update">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <label class="form-label" for="purchase_order_no">Purchase Order No:</label>
                        <input type="text" wire:model="purchase_order_no" class="form-control" disabled>
                        @error('purchase_order_no') <span class="error">{{ $message }}</span> @enderror 
                    </div>

                    <div class="col-sm-6">
                        <label class="form-label" for="purchase_order_name">Purchase Order Name</label>
                        <input type="text" wire:model="purchase_order_name" class="form-control">
                        @error('purchase_order_name') <span class="error">{{ $message }}</span> @enderror 
                    </div>

                    <div class="col-sm-6">
                        <label class="form-label" for="beneficiary">Beneficiary</label>
                        <input type="text" wire:model="beneficiary" class="form-control">
                        @error('beneficiary') <span class="error">{{ $message }}</span> @enderror 
                    </div>

                    <div class="col-sm-6">
                        <label class="form-label" for="vendor_name">Vendor Name</label>
                        <input type="text" wire:model="vendor_name" class="form-control">
                        @error('vendor_name') <span class="error">{{ $message }}</span> @enderror 
                    </div>

                    <div class="col-sm-6">
                        <label class="form-label" for="delivery_address">Delivery Address</label>
                        <select class="form-select mb-4" wire:model="delivery_address">
                            <option value="">Select ...</option>
                            @foreach($stations as $station)
                                <option value="{{$station->id}}">{{$station->name}}</option>
                            @endforeach
                        </select>
                        @error('delivery_address') <span class="error">{{ $message }}</span> @enderror 
                    </div>
                    
                    <div class="col-12 d-flex justify-content-between">
                        <button type="submit" class="btn btn-info btn-next">
                            <span class="align-middle d-sm-inline-block d-none me-sm-1">Modify</span>
                            <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
