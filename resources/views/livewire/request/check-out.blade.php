<div>
    <h6 class="py-1 mb-2">
        <span class="text-muted fw-light"><a href="{{url('request-index');}}">Available Request</a> /</span> Issue
    </h6>

    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Issue Items</h4>
                </div>
                <div class="card-body">
                    <table class="table table-responsive text-nowrap">
                        <thead>
                            <th>Stock Code</th>
                            <th>Description</th>
                            <th>Quantity Issued</th>
                            <th>Action</th>
                        </thead>

                        @foreach($items as $item)
                            <tbody>
                                <td>{{ $item->stockCodeID->stock_code }}</td>
                                <td>{{ $item->stockCodeID->name }}</td>
                                <td>{{ $item->quantity_issued }}</td>
                                <td>
                                    <div class="d-flex justify-content-between">
                                        <label for="allocation_store" class="mb-0"></label>
                                        <label class="switch switch-primary me-0">
                                        <input type="checkbox" wire:click="issueItem({{ $item->stock_code_id }})" class="switch-input" name="check.{{$key}}">
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
                            </tbody>
                        @endforeach
                    </table>
                </div>
            </div>
           <hr>
        </div>
        <div class="col-sm-12 col-md-5 mt-3">
            <div class="card">
                <div class="card-header">
                    <h4>Lorry Details</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <form wire:submit="addLorryDetails">
                                <div class="row">
                                    <div class="col-sm-12 mb-3">
                                        <label class="form-label">Lorry Number:</label>
                                        <input type="text" class="form-control" wire:model="lorry_no" placeholder="XXX-XXX">
                                    </div>
                                    <div class="col-sm-12 mb-3">
                                        <label class="form-label">Driver Name:</label>
                                        <input type="text" class="form-control" wire:model="driver_name" placeholder="Mr. John Doe">
                                    </div>
                                    <div class="col-sm-12 mb-3">
                                        <label class="form-label">Despatch Note:</label>
                                        <textarea class="form-control" wire:model="despatched_note" id="despatched_note" cols="10" rows="2"></textarea>
                                        @error("despatched_note") <span class="error">{{ $message }}</span> @enderror 
                                    </div>
                                    <div class="col-sm-12 col-md-4 mb-3">
                                        <button type="submit" class="btn btn-outline-primary">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>