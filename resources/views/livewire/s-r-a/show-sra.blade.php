<div>
    <h6 class="py-1 mb-2">
    <span class="text-muted fw-light"><a href="{{url('sra');}}">Store Received Advice</a> /</span> {{$title}}
    </h6>

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row invoice-add">
            <!-- SRA / Item Details-->
            <div class="col-lg-9 col-12 mb-lg-0 mb-4">
                <div class="card invoice-preview-card">
                    <div class="card-body">
                        <!-- SRA -->
                        <div class="row p-sm-3 p-0">
                            <div class="col-md-6 mb-md-0 mb-4">
                                <div class="d-flex svg-illustration mb-2 gap-5">
                                <span class="app-brand-logo demo">
                                    <img src="{{ asset('assets/img/jed-pics/logo2.png') }}" style="width: 70px" />
                                </span>
                                <h4 class="text-capitalize mb-0 text-nowrap fw-bolder text-center">
                                    JOS ELECTRICITY DISTRIBUTION PLC.
                                </h4>
                                </div>
                            </div>

                            <div class="col-md-12 mb-3 text-center">
                                <h5 class="fw-bolder text-decoration-underline">STORES RECEIVED ADVICE (SRA)</h5>
                            </div>
                            
                            <div class="col-md-6">
                                <span class="fw-bolder">Invoice Number:</span>
                                <span>{{$data->invoice_no}}</span>
                                <hr class="mb-0 mt-0">
                            </div>

                            <div class="col-md-6">
                                <span class="fw-bolder">Date:</span>
                                <span>{{$data->received_date}}</span>
                                <hr class="mb-0 mt-0">
                            </div>
                            
                            <div class="col-md-6">
                                <span class="fw-bolder">Purchase Order No:</span>
                                <span>{{$data->purchaseOrderID->purchase_order_no}}</span>
                                <hr class="mb-0 mt-0">
                            </div>

                            <div class="col-md-6">
                                <span class="fw-bolder">Consign Note No:</span>
                                <span>{{$data->consignment_note_no}}</span>
                                <hr class="mb-0 mt-0">
                            </div>

                            <div class="col-md-12">
                                <span class="fw-bolder">Vendor Name:</span>
                                <span>{{$data->purchaseOrderID->vendor_name}}</span>
                                <hr class="mb-0 mt-0">
                            </div>

                            <div class="col-md-12">
                                <span class="fw-bolder">Project Name:</span>
                                <span>{{$data->purchaseOrderID->purchase_order_name}}</span>
                            </div>
                        </div>

                        <hr class="my-1 mx-n4">
                        <!-- Item Details-->
                        <h5 class="text-capitalize mb-0 text-nowrap text-center fw-bolder mt-2">
                            ITEMS
                        </h5>
                        <hr class="my-1 mx-n4">
                        <div class="mb-3 mt-0" data-repeater-list="group-a">
                            <div class="repeater-wrapper pt-0 pt-md-4" data-repeater-item="">
                                <div class="table-responsive text-nowrap">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Stock Code</th>
                                                <th>Description</th>
                                                <th>Quantity (Unit)</th>
                                                <th>Price (&#8358;)</th>
                                                <th>Value (&#8358;)</th>
                                                <th>Quality Check</th>
                                            </tr>
                                        </thead>
                                            @if(!empty($items))
                                                @php
                                                    $subtotal = 0;
                                                @endphp

                                                @foreach ($items as $key => $item)
                                                @php 
                                                    $amount = $item->confirm_rate * $item->confirm_qty;
                                                    $subtotal += $amount;
                                                @endphp
                                                <tr>
                                                    <td>{{$item->stockCodeID->stock_code}}</td>
                                                    <td>{{$item->stockCodeID->name}}</td>
                                                    <td>{{ number_format($item->confirm_qty)}} ({{$item->unitID->description}})</td>
                                                    <td>{{ number_format(round($item->confirm_rate, 2))}}</td>
                                                    <td>{{ number_format(round($amount, 2)) }}</td>
                                                    <td>
                                                    @if($item->quality_check == 1)
                                                        <span class="text-success"><i class="bx bx-check"></i></span>
                                                        <span>Approved</span>
                                                    @else
                                                        <span class="text-danger"><i class="bx bx-x"></i></span>
                                                        <span>Not Approve</span>
                                                    @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="5" class="text-center">No Record Available</td>
                                                </tr>
                                            @endif
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Summary and vat calculations -->
                        <div class="row py-sm-1">
                            <div class="col-md-6 mb-md-0 mb-1"></div>
                            @php
                                $vat = 7.5;
                                $vatAmount = ($subtotal * $vat) / 100;
                                $totalAmount = $subtotal + $vatAmount;
                            @endphp
                            <div class="col-md-6 d-flex justify-content-end">
                                <div class="invoice-calculations">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="w-px-100">Subtotal:</span>
                                    <span class="fw-medium">&#8358; {{ number_format(round($subtotal, 2)) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="w-px-100">VAT:</span>
                                    <!-- <span class="fw-medium">{{$vat}}%</span> -->
                                    <span class="fw-medium">&#8358; {{number_format(round($vatAmount, 2))}}</span>
                                </div>
                                <hr class="mb-1 mt-1">
                                <div class="d-flex justify-content-between mb-3">
                                    <span class="w-px-100">Total:</span>
                                    <span class="fw-medium">&#8358; {{ number_format(round($totalAmount, 2)) }}</span>
                                </div>
                                </div>
                            </div>
                        </div>

                        <!-- Approval of SRA Actions-->
                        <h6 class="text-capitalize mb-2 text-nowrap fw-bolder">REMARKS</h6>
                        <div class="row">
                            <!--Received of SRA -->
                            @if(!empty($data->created_by))
                                <hr class="mx-n1">
                                <div class="col-sm-8">
                                    <span class="fw-bolder">Received by: </span>
                                    <span>{{$data->createdBy->name ?? ''}}</span>
                                </div>
                                <div class="col-sm-4">
                                    <span class="fw-bolder">Date: </span>
                                    <span>{{$data->received_date}}</span>
                                </div>
                            @endif

                            <!--Quality Checks -->
                            @if(!empty($qualityCheck->quality_check_by))
                                <hr class="mx-n1">
                                <div class="col-sm-8">
                                    <span class="fw-bolder">Checked by: </span>
                                    <span>{{$qualityCheck->QualityCheckBy->name ?? '' }}</span>
                                </div>
                                <div class="col-sm-4">
                                    <span class="fw-bolder">Date: </span>
                                    <span>{{$qualityCheck->quality_check_date}}</span>
                                </div>
                            @endif

                            <!--Account Remarks -->
                            @if(!empty($approval->approved_by))
                                <hr class="mx-n1">
                                <div class="col-sm-8">
                                    <span class="fw-bolder">{{$approval->approved_action}} by: </span>
                                    <span>{{$approval->approvedID->name ?? '' }}</span>
                                </div>
                                <div class="col-sm-4">
                                    <span class="fw-bolder">Date: </span>
                                    <span>{{$approval->approved_date}}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- /SRA / Item Details-->
            
            <!-- Approval Actions -->
            <div class="col-lg-3 col-12 invoice-actions">
                <div class="card-header mb-2"> 
                    <!--Print-->
                    @if(!empty($approval->approved_by))
                    <button class="btn btn-label-primary d-grid w-100">
                        <span class="d-flex align-items-center justify-content-center text-nowrap">
                        <i class="bx bx-file bx-xs me-1"></i>Print</span>
                    </button>
                    @endif

                    @if(!empty($qualityCheck->quality_check_by))
                        @if(empty($approval->approved_by))
                        <button class="btn btn-label-primary d-grid w-100 mt-2" 
                            data-bs-toggle="offcanvas" 
                            data-bs-target="#account-operation">
                        <span class="d-flex align-items-center justify-content-center text-nowrap">
                            <i class="bx bx-paper-plane bx-xs me-1"></i>Account Operations</span>
                        </button>
                        
                        @endif
                    @endif
                </div>

                <!-- Approval Note -->
                <div class="card mb-4">
                    <div class="card-body">
                    @if(!empty($qualityCheck->quality_check_by))
                        <h6 class="fw-bolder">Quality Check Note:</h6>
                        <p>{{$qualityCheck->quality_check_note}}</p>
                    @endif

                    @if(!empty($approval->approved_by))
                        <h6 class="fw-bolder">Account Operation Remark:</h6>
                        <p>{{$approval->approved_note}}</p>
                    @endif
                    </div>
                </div>

                    <!-- Modify SRA / Quality Check -->
                    @if(empty($approval->approved_by))
                    <div class="card">
                        <div class="card-header">
                            <p class="mb-2 fw-bolder">Modify SRA / Item</p>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                            <label for="payment-terms" class="mb-0">SRA</label>
                            <label class="switch switch-primary me-0">
                                <span class="switch-label">
                                    <a href="{{ url('edit-sra/'.$data->id) }}">
                                    <i class="bx bx-pencil bx-sm me-sm-n2"></i></a>
                                </span>
                            </label>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                            <label for="client-notes" class="mb-0">Quality Check</label>
                            <label class="switch switch-primary me-0">
                                <span class="switch-label">
                                <a href="{{ url('quality-check/'.$item->purchase_order_id) }}">
                                    <i class="bx bx-pencil bx-sm me-sm-n2"></i></a>
                                </span>
                            </label>
                            </div>
                        </div>
                    </div>
                    @endif
            </div>
            <!-- /Approval Actions -->
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
</div>
