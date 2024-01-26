<div>
    <h6 class="py-1 mb-2">
    <span class="text-muted fw-light"><a href="{{url('srcn-index');}}">SRCN</a> /</span> {{$title}}
    </h6>

    <div class="card">
        <div class="card-header">
            <h6 class="mb-0">Store Requisition and Consignment Note</h6>
            <small>Quantity Issue.</small>
        </div>
        <hr class="my-1">
        <form wire:submit="update">
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <div id="dynamicFieldsContainer">
                        <table class="table" id="itemsTable">
                            <thead>
                                <tr>
                                <th>Stock Code</th>
                                <th>Description</th>
                                <th>Quantity(Unit)</th>
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
                                    <td><p>{{$item->stockCodeID->name}}</p></td>
                                    <td><p>{{$item->required_qty}} ({{$item->unit}})</p></td>
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
            </div>
            <div class="card-footer">
                <div class="col-md-6 mb-1">
                    <label for="invoice-from" class="form-label">HAOP Approval</label>
                    <select class="form-select mb-4" wire:model="approved_action" required>
                        <option value=""></option>
                        <option value="Approved">Approve</option>
                        <option value="Rejected">Reject</option>
                    </select>
                    @error("approved_action") <span class="error">{{ $message }}</span> @enderror 
                </div>
                <div class="col-sm-12 mb-3">
                    <label class="form-label" for="approved_note">HAOP Note</label>
                    <textarea class="form-control" wire:model="approved_note"id="approved_note" cols="10" rows="2"></textarea>
                    @error("approved_note") <span class="error">{{ $message }}</span> @enderror 
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
