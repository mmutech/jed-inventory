<div>
    <h6 class="py-1 mb-2">
    <span class="text-muted fw-light"><a href="{{url('srcn-index');}}">SRCN</a> /</span> {{$title}}
    </h6>

    <div class="card">
        <div class="card-header">
            <h6 class="mb-0">SRCN</h6>
            <small>Create Your SRCN.</small>
        </div>
        <hr class="my-1">
        <div class="card-body">
            <form wire:submit="store">
                <div class="row g-3">
                    <div class="table-responsive text-nowrap">
                        <div class="d-flex justify-content-end">  
                            <button type="button" class="btn btn-primary" wire:click="addInput" data-repeater-create="">Add Item</button>
                        </div>
                        <div id="dynamicFieldsContainer">
                            <table class="table" id="itemsTable">
                                <thead>
                                    <tr>
                                    <th colspan="2">Stock Code</th>
                                    <th>Unit</th>
                                    <th>Quantity</th>
                                    <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($inputs as $key => $value)
                                        <tr>
                                            <td class="col-md-3">
                                            <input type="text" wire:model.live="search" class="form-control" placeholder="Type to Search...">
                                            </td>
                                            <td>
                                                <select class="form-control" wire:model="stock_codes.{{ $key }}">
                                                    <option value="">Select...</option>
                                                    @foreach($stock_code as $stCode)
                                                        <option value="{{$stCode->id}}">{{$stCode->stock_code}} - {{$stCode->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error("stock_codes.$key") <span class="error">{{ $message }}</span> @enderror 
                                            </td>
                                            <td class="col-md-3">
                                                <select class="form-select select2" id="drps" style="position: fixed; top: auto; left: auto; width: inherit;" wire:model="units.{{ $key }}">
                                                    <option value="">Select ...</option>
                                                    @foreach($unitOfMeasure as $unit)
                                                        <option value="{{$unit->id}}">{{$unit->description}}</option>
                                                    @endforeach
                                                </select>
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
</div>