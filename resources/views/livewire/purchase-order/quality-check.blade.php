<div>
    <h6 class="py-1 mb-2">
        <span class="text-muted fw-light"><a href="{{url('purchase-order');}}">Purchase Order</a> /</span> {{$title}}
    </h6>

    <div class="card">
        <div class="card-header">
            <h6 class="mb-0">Purchase Order Items</h6>
            <small>Quality Checks.</small>
        </div>
        <hr class="my-1">
        <div class="card-body">
            <div class="row w-100 m-0 p-3">
                <div class="table-responsive text-nowrap">
                    <div id="dynamicFieldsContainer">
                        <table class="table" id="itemsTable">
                            <thead>
                                <tr>
                                <th>Description</th>
                                <th>Unit</th>
                                <th>Quantity</th>
                                <th>Rate</th>
                                <th>Total Amount</th>
                                <th>Confirm Quantity</th>
                                <th>Confirm Rate (&#8358;)</th>
                                <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $subtotal = 0;
                                @endphp
                                @foreach ($items as $key => $item)
                                @php 
                                    $amount = $item->rate * $item->quantity;
                                    $subtotal += $amount;
                                @endphp
                                    <tr class="input-container">
                                        <input type="text" wire:model="itemIDs.{{ $key }}"  value="{{$item->id}}" hidden>
                                        <td><p>{{$item->description}}</p></td>
                                        <td><p>{{$item->unitID->description}}</p></td>
                                        <td><p>{{$item->quantity}}</p></td>
                                        <td><p>&#8358; {{number_format($item->rate)}}</p></td>
                                        <td><p>&#8358; {{number_format($amount)}}</p></td>
                                        <td class="col-sm-2">
                                            <input type="number" wire:model="confirm_qtys.{{ $key }}" class="form-control invoice-item-qty" step="1" min="1">
                                            @error("confirm_qtys.$key") <span class="error">{{ $message }}</span> @enderror 
                                        </td>
                                        <td class="col-sm-2">
                                            <input type="number" wire:model="confirm_rates.{{ $key }}" class="form-control invoice-item-rate" step="0.01" min="1">
                                            @error("confirm_rates.$key") <span class="error">{{ $message }}</span> @enderror 
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <label for="quality-check-stub" class="mb-0"></label>
                                                <label class="switch switch-primary me-0">
                                                <input type="checkbox" wire:click="qualityCheck('{{ $key }}', '{{ $item->id }}', '{{ $item->quantity }}')" class="switch-input" id="quality-check-stub">
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
        </div>
        <hr class="my-1">
        <form wire:submit="qualityCheckRemark">
            <div class="card-footer">
                <div class="col-sm-12 mt-4">
                    <label class="form-label" for="quality_check_note">Quality Check Note</label>
                    <textarea class="form-control" wire:model="quality_check_note"id="quality_check_note" cols="10" rows="2"></textarea>
                    @error("quality_check_note") <span class="error">{{ $message }}</span> @enderror 
                </div>
                <div class="row py-sm-3">
                    <div class="col-12 d-flex justify-content-between">
                        <button type="submit" class="btn btn-info btn-next">
                            <span class="align-middle d-sm-inline-block d-none me-sm-1">Save</span>
                            <i class="bx bx-pencil bx-sm me-sm-n2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
