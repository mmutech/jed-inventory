<div>
    <h6 class="py-1 mb-2">
    <span class="text-muted fw-light"><a href="{{url('srin-index');}}">SRIN</a> /</span> {{$title}}
    </h6>

    <div class="card">
        <div class="card-header">
            <h6 class="mb-0">Store Requisition / Issue Note</h6>
            <small>Quantity Issue.</small>
        </div>
        <hr class="my-1">
        <form wire:submit="update">
            <div class="card-body">
                <h5 class="text-capitalize mb-0 text-nowrap text-center fw-bolder mt-2">
                    Allocated Items
                </h5>
                <hr class="my-1 mx-n4">
                <div class="table-responsive text-nowrap mb-4">
                    <div id="dynamicFieldsContainer" wire:ignore>
                        <table class="table" id="itemsTable">
                            <thead>
                                <tr>
                                <th>Stock Code</th>
                                <th>Description</th>
                                <th>Allocated</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($items as $key => $item)               
                                <tr class="input-container">
                                    <td><p>{{$item->stockCodeID->stock_code}}</p></td>
                                    <td><p>{{$item->stockCodeID->name}}</p></td>
                                    <td><p>{{$item->quantity}}</p></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <h5 class="text-capitalize mb-0 text-nowrap text-center fw-bolder mt-2">
                    ISSUE
                </h5>
                <hr class="my-1 mx-n4">
                <div class="table-responsive text-nowrap mb-0">
                    <div id="dynamicFieldsContainer">
                        <table class="table" id="itemsTable">
                            <thead>
                                <tr>
                                    <th>Stock Code</th>
                                    <th>Description</th>
                                    <th>Available</th>
                                    <th>Issue Quantity</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody wire:ignore>
                            @foreach ($issueStore as $key => $item)               
                                <tr class="input-container">
                                    <td><p>{{$item->stockCodeID->stock_code}}</p></td>
                                    <td><p>{{$item->stockCodeID->name}}</p></td>
                                    <td><p>{{$item->total_balance}}</p></td>
                                    <td class="col-sm-2">
                                        <input type="number" wire:model="issuedQty.{{$key}}" class="form-control invoice-item-qty">
                                        @error("issuedQty") <span class="error">{{ $message }}</span> @enderror 
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-between">
                                            <label for="issuing_store" class="mb-0"></label>
                                            <label class="switch switch-primary me-0">
                                            <input type="checkbox" wire:click="issuingStore('{{ $key }}', '{{ $item->station_id }}', '{{ $item->stock_code_id }}')" class="switch-input" name="check.{{$key}}">
                                            <span class="switch-toggle-slider">
                                                <span class="switch-on">
                                                    <i class="bx bx-check"></i>
                                                </span>
                                                <span class="switch-off">
                                                    <i class="bx bx-x"></i>
                                                </span>
                                            </span>
                                            <span class="switch-label"></span>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>    
            </div>
            <div class="card-footer">
                <div class="row mb-2">
                    <div class="col-sm-4 mb-2">
                        <label class="form-label" for="lorry_no">Lorry Number</label>
                        <input type="text" wire:model="lorry_no" class="form-control" placeholder="lorry number">
                        @error('lorry_no') <span class="error">{{ $message }}</span> @enderror 
                    </div>
                        
                    <div class="col-sm-4 mb-2">
                        <label class="form-label" for="driver_name">Driver Name</label>
                        <input type="text" wire:model="driver_name" class="form-control" placeholder="Drivers Name">
                        @error('driver_name') <span class="error">{{ $message }}</span> @enderror 
                    </div>

                    <div class="col-sm-4 mb-2">
                        <label class="form-label" for="location">Location</label>
                        <select class="form-control" wire:model="location">
                            <option value="">Select...</option>
                            @foreach($locations as $loc)
                                <option value="{{$loc->id}}">{{$loc->name}}</option>
                            @endforeach
                        </select>
                        @error('location') <span class="error">{{ $message }}</span> @enderror 
                    </div>
                </div>

                <div class="col-sm-12 mb-3">
                    <label class="form-label" for="hod_approved_note">Issue Note</label>
                    <textarea class="form-control" wire:model="despatched_note" id="invoice-message" cols="3" rows="3"></textarea>
                    @error("despatched_note") <span class="error">{{ $message }}</span> @enderror 
                </div>

                <div class="col-12 d-flex justify-content-between">
                    <button type="submit" class="btn btn-info btn-next">
                        <span class="align-middle d-sm-inline-block d-none me-sm-1">Save</span>
                        <i class="bx bx-pencil bx-sm me-sm-n2"></i>
                    </button>
                </div>
            </div>
        </form> 
       
    </div>
</div>