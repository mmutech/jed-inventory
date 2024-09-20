<div>
    <h6 class="py-1 mb-2">
        <span class="text-muted fw-light"><a href="{{url('request-index');}}">Available Request</a> /</span> {{ $title }} Allocation
    </h6>

    <div class="card">
        <div class="card-header">
            <h6 class="mb-0">Store Requisition and Consignment Note</h6>
            <small>Allocation.</small>
        </div>
        <hr class="my-1">
        <form wire:submit="update">
            <div class="card-body">
                <h5 class="text-capitalize mb-0 text-nowrap text-center fw-bolder mt-2">
                    Requisition Items
                </h5>
                <hr class="my-1 mx-n4">
                <div class="table-responsive text-nowrap mb-4">
                    <div id="dynamicFieldsContainer" wire:ignore>
                        <table class="table" id="itemsTable">
                            <thead>
                                <tr>
                                <th>Stock Code</th>
                                <th>Description</th>
                                <th>Qty Recommended</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($items as $key => $item)               
                                <tr class="input-container">
                                    <td><p>{{$item->stockCodeID->stock_code}}</p></td>
                                    <td><p>{{$item->stockCodeID->name}}</p></td>
                                    <td><p>{{$item->quantity_recommend}}</p></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <h5 class="text-capitalize mb-0 text-nowrap text-center fw-bolder mt-2">
                    Allocation Store
                </h5>
                <hr class="my-1 mx-n4">
                <div class="table-responsive text-nowrap mb-0">
                    <div id="dynamicFieldsContainer">
                        <table class="table" id="itemsTable">
                            <thead>
                                <tr>
                                    <th>Station</th>
                                    <th>Stock Code</th>
                                    <th>Description</th>
                                    <th>Available</th>
                                    <th>Allocate Quantity</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody wire:ignore>
                            @foreach ($allocationStores as $key => $item)               
                                <tr class="input-container">
                                    <td><p>{{$item->stationID->name}}</p></td>
                                    <td><p>{{$item->stockCodeID->stock_code}}</p></td>
                                    <td><p>{{$item->stockCodeID->name}}</p></td>
                                    <td><p>{{$item->total_balance}}</p></td>
                                    <td class="col-sm-2">
                                        <input type="number" wire:model="allocationQty.{{$key}}" class="form-control invoice-item-qty">
                                        @error("allocationQty") <span class="error">{{ $message }}</span> @enderror 
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-between">
                                            <label for="allocation_store" class="mb-0"></label>
                                            <label class="switch switch-primary me-0">
                                            <input type="checkbox" wire:click="allocationStore('{{ $key }}', '{{ $item->station_id }}', '{{ $item->stock_code_id }}')" class="switch-input" name="check.{{$key}}">
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
                <div class="col-md-6 mb-1">
                    <label for="invoice-from" class="form-label">HOD Approval</label>
                    <select class="form-select mb-4" wire:model="hod_approved_action">
                        <option value=""></option>
                        <option value="Approved">Approve</option>
                        <option value="Rejected">Reject</option>
                    </select>
                    @error("hod_approved_action") <span class="error">{{ $message }}</span> @enderror 
                </div>
                <div class="col-sm-12 mb-3">
                    <label class="form-label" for="hod_approved_note">HOD Note</label>
                    <textarea class="form-control" wire:model="hod_approved_note" id="hod_approved_note" cols="10" rows="2"></textarea>
                    @error("hod_approved_note") <span class="error">{{ $message }}</span> @enderror 
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
