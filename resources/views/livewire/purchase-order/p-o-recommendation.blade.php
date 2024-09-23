<div>
    <h6 class="py-1 mb-2">
        <span class="text-muted fw-light"><a href="{{url('purchase-order');}}">Purchase Order</a> /</span> {{$title}}
    </h6>

    <div class="card">
        <div class="card-header">
            <h6 class="mb-0">Purchase Order Items</h6>
            <small>Recommendation.</small>
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
                                        <td><p>{{$item->description}}</p></td>
                                        <td><p>{{$item->unitID->description}}</p></td>
                                        <td><p>{{$item->quantity}}</p></td>
                                        <td><p>&#8358; {{number_format($item->rate)}}</p></td>
                                        <td><p>&#8358; {{number_format($amount)}}</p></td>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <label for="recommend-stub" class="mb-0"></label>
                                                <label class="switch switch-primary me-0">
                                                <input type="checkbox" wire:click="recommend('{{ $item->id }}')" class="switch-input" id="recommend-stub">
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
        <form wire:submit="update">
            <div class="card-footer">
                <div class="col-sm-12 mt-4">
                    <label class="form-label" for="recommend_note">Recommendation Note</label>
                    <textarea class="form-control" wire:model="recommend_note"id="recommend_note" cols="10" rows="2"></textarea>
                    @error("recommend_note") <span class="error">{{ $message }}</span> @enderror 
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