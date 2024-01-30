<div>
    <h6 class="py-1 mb-2">
    <span class="text-muted fw-light"><a href="{{url('srin-index');}}">SRIN</a> /</span> {{$title}}
    </h6>

    <div class="card">
        <div class="card-header">
            <h6 class="mb-0">SRIN</h6>
            <small>Create Your SRIN.</small>
        </div>
        <hr class="my-1">
        <div class="card-body">
            <form wire:submit="store">
                <div class="row g-3">
                    <div class="col-md-12">
                        <div class="table-responsive text-nowrap">
                            <div class="d-flex justify-content-end">  
                                <button type="button" class="btn btn-primary" wire:click="addInput" data-repeater-create="">
                                    Add Item
                                    <i class="bx bx-plus bx-sm me-sm-n2"></i>
                                </button>
                            </div>
                            <div id="dynamicFieldsContainer">
                                <table class="table" id="itemsTable">
                                    <thead>
                                        <tr>
                                        <th>Stock Code</th>
                                        <th>Descriptions</th>
                                        <th>Unit</th>
                                        <th>Quantity</th>
                                        <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($inputs as $key => $value)
                                            <tr>
                                                <td class="col-md-3">
                                                    <select class="form-control" wire:model.live.debounce.100ms="stock_codes.{{ $key }}">
                                                        <option value="">Type to search...</option>
                                                        @foreach($stock_code as $stCode)
                                                            <option value="{{$stCode->id}}">{{$stCode->stock_code}} - {{$stCode->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error("stock_codes.$key") <span class="error">{{ $message }}</span> @enderror 
                                                </td>
                                                <td class="col-md-5">
                                                    <input type="text" wire:model="descriptions.{{ $key }}" class="form-control" placeholder="Description">
                                                    @error("descriptions.$key") <span class="error">{{ $message }}</span> @enderror 
                                                </td>
                                                <td>
                                                    <input type="text" wire:model="units.{{ $key }}" class="form-control invoice-item-unit" placeholder="Unit">
                                                    @error("units.$key") <span class="error">{{ $message }}</span> @enderror 
                                                </td>
                                                <td>
                                                    <input type="number" wire:model="quantities.{{ $key }}" class="form-control invoice-item-qty" step="1" min="1" oninput="calculateAmount(this)">
                                                    @error("quantities.$key") <span class="error">{{ $message }}</span> @enderror 
                                                </td>
                                                <td>
                                                @if($key !== 0)
                                                    <a href="#" wire:click="removeInput({{ $key }})"><i class="bx bx-x text-danger"></i></a>
                                                @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
            
                    <div class="col-12 d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary btn-next">
                            <span class="align-middle d-sm-inline-block d-none me-sm-1">Save</span>
                            <i class="bx bx-plus bx-sm me-sm-n2"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>