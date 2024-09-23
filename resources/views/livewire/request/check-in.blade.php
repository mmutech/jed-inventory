<div>
    <h6 class="py-1 mb-2">
        <span class="text-muted fw-light"><a href="{{url('request-index');}}">Available Request</a> /</span> Receive
    </h6>

    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Received Items</h4>
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
                                    @if($title == 'SRCN')
                                    <div class="d-flex justify-content-between">
                                        <label for="allocation_store" class="mb-0"></label>
                                        <label class="switch switch-primary me-0">
                                        <input type="checkbox" wire:click="receiveItem({{ $item->stock_code_id }})" class="switch-input" name="check.{{$key}}">
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
                                    @else
                                    <div class="d-flex justify-content-between">
                                        <label for="allocation_store" class="mb-0"></label>
                                        <label class="switch switch-primary me-0">
                                        <input type="checkbox" wire:click="srinReceive({{ $item->id }})" class="switch-input" name="check.{{$key}}">
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
                                    @endif
                                </td>
                            </tbody>
                        @endforeach
                    </table>
                </div><hr>

                <div class="card-footer">
                    <form wire:submit="received">
                        <div class="col-sm-12 mb-3">
                            <label class="form-label" for="receive_note">Received Note</label>
                            <textarea class="form-control" wire:model="receive_note" id="receive_note" cols="10" rows="2"></textarea>
                            @error("receive_note") <span class="error">{{ $message }}</span> @enderror 
                        </div>

                        <div class="col-12 d-flex justify-content-between">
                            <button type="submit" class="btn btn-info btn-next">
                                <span class="align-middle d-sm-inline-block d-none me-sm-1">Save</span>
                                <i class="bx bx-pencil bx-sm me-sm-n2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>