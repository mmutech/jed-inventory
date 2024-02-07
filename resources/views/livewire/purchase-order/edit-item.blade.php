<div>
    <h6 class="py-1 mb-2">
    <span class="text-muted fw-light"><a href="{{url('purchase-order');}}">Purchase Order</a> /</span> {{$title}}
    </h6>

    <div class="card">
        <div class="card-header">
            <h6 class="mb-0">Purchase Order Items</h6>
            <small>Modify Your Purchase Order Items.</small>
        </div>
        <hr class="my-1">
        <div class="card-body">
            <div class="row w-100 m-0 p-3">
                <div class="table-responsive text-nowrap">
                    <div class="d-flex justify-content-end">  
                    <button type="button" class="btn btn-primary" wire:click="addInput" data-repeater-create="">Add Item</button>
                    </div>
                    <form wire:submit="update">
                        <div id="dynamicFieldsContainer">
                            <table class="table" id="itemsTable">
                                <thead>
                                    <tr>
                                    <th>#</th>
                                    <th>Description</th>
                                    <th>Unit</th>
                                    <th>Quantity</th>
                                    <th>Rate (&#8358;)</th>
                                    <th>Amount (&#8358;)</th>
                                    <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <!-- Existing Fields -->
                                @foreach($descriptions as $key => $description)
                                    <tr>
                                        <td></td>
                                        
                                        <td class="col-sm-4">
                                        <input type="hidden" wire:model="itemIDs.{{ $key }}" class="form-control">
                                            <input type="text" wire:model="descriptions.{{ $key }}" class="form-control" placeholder="Item Description">
                                            @error("descriptions.$key") <span class="error">{{ $message }}</span> @enderror 
                                        </td>
                                        <td class="col-sm-2">
                                            <select class="form-select" wire:model="units.{{ $key }}">
                                                <option value="">Select ...</option>
                                                @foreach($unitOfMeasure as $unit)
                                                    <option value="{{$unit->id}}">{{$unit->description}}</option>
                                                @endforeach
                                            </select>
                                            @error("units.$key") <span class="error">{{ $message }}</span> @enderror 
                                        </td>
                                        <td class="col-sm-2">
                                            <input type="number" wire:model="quantities.{{ $key }}" class="form-control invoice-item-qty" step="1" min="1" oninput="calculateAmount(this)">
                                            @error("quantities.$key") <span class="error">{{ $message }}</span> @enderror 
                                        </td>
                                        <td class="col-sm-2">
                                            <input type="number" wire:model="rates.{{ $key }}" class="form-control invoice-item-rate" step="0.01" min="1" oninput="calculateAmount(this)">
                                            @error("rates.$key") <span class="error">{{ $message }}</span> @enderror 
                                        </td>
                                        <td class="col-sm-2 amount"><p class="mb-0"></p></td>
                                        <td>
                                        @if($key !== 0)
                                            <a href="#" wire:click="removeInput({{ $key }})"><i class="bx bx-x text-danger"></i></a>
                                        @endif
                                        </td>
                                    </tr>
                                @endforeach

                                <!-- New Fields -->
                                @foreach($inputs as $key => $value)
                                    <tr>
                                        <td></td>
                                        <td class="col-sm-4">
                                            <input type="text" wire:model="description.{{ $key }}" class="form-control" placeholder="Item Description">
                                            @error("description.$key") <span class="error">{{ $message }}</span> @enderror 
                                        </td>
                                        <td class="col-sm-2">
                                            <input type="text" wire:model="unit.{{ $key }}" class="form-control invoice-item-unit" placeholder="Unit" min="1">
                                            @error("unit.$key") <span class="error">{{ $message }}</span> @enderror 
                                        </td>
                                        <td class="col-sm-2">
                                            <input type="number" wire:model="quantity.{{ $key }}" class="form-control invoice-item-qty" step="1" min="1" oninput="calculateAmount(this)">
                                            @error("quantity.$key") <span class="error">{{ $message }}</span> @enderror 
                                        </td>
                                        <td class="col-sm-2">
                                            <input type="number" wire:model="rate.{{ $key }}" class="form-control invoice-item-rate" step="0.01" min="1" oninput="calculateAmount(this)">
                                            @error("rate.$key") <span class="error">{{ $message }}</span> @enderror 
                                        </td>
                                        <td class="col-sm-2 amount"><p class="mb-0"></p></td>
                                        <td>
                                        @if($key !== 0)
                                            <a href="#" wire:click="removeInput({{ $key }})"><i class="bx bx-x text-danger"></i></a>
                                        @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="row py-sm-3">
                                <div class="col-12 d-flex justify-content-between">
                                    <button type="submit" class="btn btn-info btn-next">
                                        <span class="align-middle d-sm-inline-block d-none me-sm-1">Modify</span>
                                        <i class="bx bx-pencil bx-sm me-sm-n2"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
