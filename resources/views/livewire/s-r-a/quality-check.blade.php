<div>
    <h6 class="py-1 mb-2">
    <span class="text-muted fw-light"><a href="{{url('sra');}}">Store Receive Advice</a> /</span> {{$title}}
    </h6>

    <div class="card">
        <div class="card-header">
            <h6 class="mb-0">SRA Items</h6>
            <small>Quality Checks SRA Items.</small>
        </div>
        <hr class="my-1">
        <div class="card-body">
            <div class="row w-100 m-0 p-3">
                <div class="table-responsive text-nowrap">
                    <div id="dynamicFieldsContainer">
                        <table class="table" id="itemsTable">
                            <thead>
                                <tr>
                                <th rowspan="3">Stock Code</th>
                                <th>Description</th>
                                <th>Quantity/Unit</th>
                                <th>Current Amount</th>
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
                                        <td><p>{{$item->stockCodeID->stock_code}}</p></td>
                                        <td><p>{{$item->stockCodeID->name}}</p></td>
                                        <td><p>{{$item->confirm_qty}} ({{$item->confirm_rate}})</p></td>
                                        <td><p class="mb-0 ">{{number_format($amount)}}</p></td>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <label for="quality-check-stub" class="mb-0"></label>
                                                <label class="switch switch-primary me-0">
                                                <input type="checkbox" wire:click="qualityCheck('{{ $item->id }}')" class="switch-input" id="quality-check-stub">
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
                            <span class="align-middle d-sm-inline-block d-none me-sm-1">Modify</span>
                            <i class="bx bx-pencil bx-sm me-sm-n2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
