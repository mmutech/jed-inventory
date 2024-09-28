<div>
    <h6 class="py-1 mb-2">
        <span class="text-muted fw-light"><a href="{{url('purchase-order');}}">Purchase Order</a> /</span> {{$title}}
    </h6>

    <div class="card">
        <div class="card-header">
            <h6 class="mb-0">Purchase Order Items</h6>
            <small>Balance Quality Check.</small>
        </div>
        <hr class="my-1">
        <div class="card-body">
            <!-- Balance Check and Confirm -->
             @if(!empty($items))
            <div class="row w-100 m-0 p-3">
                <div class="table-responsive text-nowrap">
                    <div id="dynamicFieldsContainer">
                        <table class="table" id="dataTable">
                            <thead>
                                <tr>
                                <th>Description</th>
                                <th>Unit</th>
                                <th>Quantity</th>
                                <th>Qty Balance</th>
                                <th>Rate</th>
                                <th>Total Amount</th>
                                <th>Confirm QTY</th>
                                <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $subtotal = 0;
                                @endphp
                                @foreach ($items as $key => $item)
                                @php 
                                    $amount = $item->rate * $item->balance_qty;
                                    $subtotal += $amount;
                                @endphp
                                    <tr class="input-container">
                                        <td><p>{{$item->description}}</p></td>
                                        <td><p>{{$item->unitID->description}}</p></td>
                                        <td><p>{{$item->quantity}}</p></td>
                                        <td><p>{{$item->balance_qty}}</p></td>
                                        <td><p>&#8358; {{number_format($item->rate)}}</p></td>
                                        <td><p>&#8358; {{number_format($amount)}}</p></td>
                                        <td class="col-sm-2">
                                            <input type="number" wire:model="confirm_qtys.{{ $key }}" class="form-control invoice-item-qty" step="1" min="1">
                                            @error("confirm_qtys.$key") <span class="error">{{ $message }}</span> @enderror 
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <label for="quality-check-stub" class="mb-0"></label>
                                                <label class="switch switch-primary me-0">
                                                <input type="checkbox" wire:click="qualityCheck('{{ $key }}', '{{ $item->id }}', '{{ $item->balance_qty }}')" class="switch-input" id="quality-check-stub">
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
            @endif

            <!-- Create New SRA -->
            @can('create-sra')
            @if(!empty($bal_item))
            <div class="row g-3">
                <div class="col-sm-12 col-md-4">
                    <label class="form-label" for="purchase_order_no">Purchase Order No:</label>
                    <input type="text" wire:model="poNumber" class="form-control" disabled>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label class="form-label" for="invoice_no">Invoice Number</label>
                    <input type="text" wire:model="invoiceNo" class="form-control" disabled>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label class="form-label" for="consignment_note_no">Consignment Note No: </label>
                    <input type="text" wire:model="consignmentNo" class="form-control" disabled>
                </div><hr>
            
                <div class="col-sm-12">
                    <div class="table-responsive text-nowrap">
                        <div id="dynamicFieldsContainer">
                            <table class="table" id="dataTable">
                                <thead>
                                    <tr>
                                    <th>Stock Code</th>
                                    <th>Description</th>
                                    <th>Quantity/(Unit)</th>
                                    <th>Rate</th>
                                    <th>Job Order Amount (&#8358;)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php
                                    $subtotal = 0;
                                @endphp
                                @foreach ($bal_item as $key => $item)
                                    @php 
                                        $amount = $item->confirm_rate * $item->confirm_bal_qty;
                                        $subtotal += $amount;
                                    @endphp
                                    <tr>
                                        <td><p>{{$item->stockCodeID->stock_code}}</p></td>
                                        <td><p>{{$item->description}}</p></td>
                                        <td><p>{{$item->confirm_bal_qty}} ({{$item->unitID->description}})</p></td>
                                        <td><p>{{number_format($item->confirm_rate)}}</p></td>
                                        <td><p>{{number_format($amount)}}</p></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-12 d-flex justify-content-between">
                    <button class="btn btn-success btn-next btn-submit" wire:click="update">New SRA</button>
                    <button class="btn btn-primary btn-next btn-submit" 
                            data-bs-toggle="offcanvas" 
                            data-bs-target="#account-operation">
                            <i class="bx bx-paper-plane bx-xs me-1"></i>Account Operations
                    </button>
                </div> 
            </div>
            @endif
            @endcan
        </div>
    </div>
    

     <!-- Offcanvas -->
        <!-- Send Account Operation Sidebar -->
        <div class="offcanvas offcanvas-end" id="account-operation" aria-hidden="true">
            <div class="offcanvas-header mb-0">
                <h5 class="offcanvas-title">Account Operation Actions</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <hr class="mx-n1">
            <div class="offcanvas-body flex-grow-1">
                <form wire:submit="approved">
                    <div class="mb-3">
                        <label for="invoice-from" class="form-label">Account Operation Action</label>
                        <select class="form-select mb-4" wire:model="account_operation_action" required>
                            <option value=""></option>
                            <option value="Approved">Approve</option>
                            <option value="Rejected">Reject</option>
                        </select>
                        @error("account_operation_action") <span class="error">{{ $message }}</span> @enderror 
                    </div>
                    <div class="mb-3">
                        <label for="invoice-message" class="form-label">Account Operation Remark</label>
                        <textarea class="form-control" wire:model="account_operation_remark_note" id="invoice-message" cols="3" rows="3" required></textarea>
                    </div>
                
                    <div class="mb-3 d-flex flex-wrap">
                        <button type="submit" class="btn btn-primary me-3" data-bs-dismiss="offcanvas">Save</button>
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /Received Sidebar -->
    <!-- /Offcanvas -->
</div>