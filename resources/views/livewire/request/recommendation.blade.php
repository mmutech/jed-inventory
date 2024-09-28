<div>
    <h6 class="py-1 mb-2">
        <span class="text-muted fw-light"><a href="{{url('request-index');}}">Available Request</a> /</span> {{ $title }} Recommendation
    </h6>

    <div class="card">
        <div class="card-header">
            <h6 class="mb-0">Store Requisition and Consignment Note</h6>
            <small>Recommendation.</small>
        </div>
        <hr class="my-1">
        <form wire:submit="update">
            <div class="card-body">
                <h5 class="text-capitalize mb-0 text-nowrap text-center fw-bolder mt-2">
                    Requisition Items
                </h5>
                <hr class="my-1 mx-n4">
                <div class="table-responsive text-nowrap mb-0">
                    <div id="dynamicFieldsContainer">
                        <table class="table" id="dataTable">
                            <thead>
                                <tr>
                                    <th>Station</th>
                                    <th>Stock Code</th>
                                    <th>Description</th>
                                    <th>Qty Required</th>
                                    <th>Qty Recommend</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody wire:ignore>
                            @foreach ($items as $key => $item)               
                                <tr class="input-container">
                                    <td><p>{{$item->requisitionStore->name}}</p></td>
                                    <td><p>{{$item->stockCodeID->stock_code}}</p></td>
                                    <td><p>{{$item->stockCodeID->name}}</p></td>
                                    <td><p>{{$item->quantity_required}}</p></td>
                                    <td class="col-sm-2">
                                        <input type="number" wire:model="recommendQty.{{$key}}" class="form-control invoice-item-qty">
                                        @error("recommendQty") <span class="error">{{ $message }}</span> @enderror 
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-between">
                                            <label for="allocation_store" class="mb-0"></label>
                                            <label class="switch switch-primary me-0">
                                            <input type="checkbox" wire:click="recommend({{ $key }}, {{ $item->stock_code_id }})" class="switch-input" name="check.{{$key}}">
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
                <div class="col-sm-12 mb-3">
                    <label class="form-label" for="recommend_note">Recommendation Note</label>
                    <textarea class="form-control" wire:model="recommend_note" id="recommend_note" cols="10" rows="2"></textarea>
                    @error("recommend_note") <span class="error">{{ $message }}</span> @enderror 
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