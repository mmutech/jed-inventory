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
                <div class="table-responsive text-nowrap mb-4">
                    <div id="dynamicFieldsContainer">
                        <table class="table" id="itemsTable">
                            <thead>
                                <tr>
                                <th>Stock Code</th>
                                <th>Description</th>
                                <th>Quantity(Unit)</th>
                                <th>Available</th>
                                <th>Issue Quantity</th>
                                <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($items as $key => $item)               
                                <tr class="input-container">
                                    <td class="col-sm-4">
                                        <input type="hidden" wire:model="itemIDs.{{ $key }}" class="form-control">
                                        <p>{{$item->stockCodeID->stock_code}}</p>
                                    </td>
                                    <td><p>{{$item->description}}</p></td>
                                    <td><p>{{$item->required_qty}} ({{$item->unitID->description}})</p></td>
                                    <td><p>{{$item->total_balance}}</p></td>
                                    <td class="col-sm-2">
                                        <input type="number" wire:model="issued_qty.{{ $key }}" class="form-control invoice-item-qty" step="1" min="1" oninput="calculateAmount(this)">
                                        @error("issued_qty.$key") <span class="error">{{ $message }}</span> @enderror 
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <h5 class="text-capitalize mb-0 text-nowrap text-center fw-bolder mt-2">
                    ISSUING STORE
                </h5>
                <hr class="my-1 mx-n4">
                <div class="table-responsive text-nowrap mt-4">
                    <div id="dynamicFieldsContainer">
                        <table class="table" id="itemsTable">
                            <thead>
                                <tr>
                                <th>Store Name</th>
                                <th>Stock Code</th>
                                <th>Available</th>
                                <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($issueStore as $key => $item)             
                                <tr class="input-container">
                                    <td><p>{{$item->stationID->name}}</p></td>
                                    <td><p>{{$item->stockCodeID->stock_code}}</p></td>
                                    <td><p>{{$item->total_balance}}</p></td>
                                    <td>
                                        <div class="d-flex">
                                            <label for="Issuing-store-stub" class="mb-0"></label>
                                            <label class="switch switch-primary me-0">
                                            <input type="checkbox" wire:click="issuingStore('{{ $item->station_id }}')" class="switch-input" id="Issuing-store-stub">
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
                    <select class="form-select mb-4" wire:model="hod_approved_action" required>
                        <option value=""></option>
                        <option value="Approved">Approve</option>
                        <option value="Rejected">Reject</option>
                    </select>
                    @error("hod_approved_action") <span class="error">{{ $message }}</span> @enderror 
                </div>
                <div class="col-sm-12 mb-3">
                    <label class="form-label" for="hod_approved_note">HOD Note</label>
                    <textarea class="form-control" wire:model="hod_approved_note"id="hod_approved_note" cols="10" rows="2"></textarea>
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