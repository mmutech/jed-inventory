<div>
    <h6 class="py-1 mb-2">
        <span class="text-muted fw-light"><a href="{{url('scn-index');}}">SCN</a> /</span> {{$title}}
    </h6>

    <div class="card">
        <div class="card-header">
            <h6 class="mb-0">SCN</h6>
            <small>Modify Your SCN.</small>
        </div>
        <hr class="my-1">
        <div class="card-body">
            <div class="row w-100 m-0 p-3">
                <div class="table-responsive text-nowrap">
                    <form wire:submit="update">
                        <div id="dynamicFieldsContainer">
                            <div class="col-md-4 mb-2">
                                <label for="">Location</label>
                                <select class="form-control" wire:model="locations">
                                    <option value="">Select...</option>
                                    @foreach($location as $loc)
                                        <option value="{{$loc->id}}">{{$loc->name}}</option>
                                    @endforeach
                                </select>
                                @error("locations") <span class="error">{{ $message }}</span> @enderror 
                            </div>
                            <table class="table" id="itemsTable">
                                <thead>
                                    <tr>
                                    <th>Stock Code</th>
                                    <th>Unit</th>
                                    <th>Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <!-- Existing Fields -->
                                @foreach($stock_codes as $key => $stock_code)
                                    <tr>
                                        <td class="col-md-3">
                                        <input type="hidden" wire:model="itemIDs.{{ $key }}" class="form-control">
                                        <select class="form-select" wire:model="stock_codes.{{ $key }}">
                                            <option value="">Select ...</option>
                                            @foreach($stockCode as $stCode)
                                            <option value="{{$stCode->id}}">{{$stCode->stock_code}} - {{$stCode->name}}</option>
                                            @endforeach
                                        </select>
                                        @error("stock_codes.$key") <span class="error">{{ $message }}</span> @enderror 
                                        </td>
                                        <td>
                                            <select class="form-select" wire:model="units.{{ $key }}">
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
