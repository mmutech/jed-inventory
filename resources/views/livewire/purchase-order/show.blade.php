<div>
    <h6 class="py-1 mb-2">
    <span class="text-muted fw-light"><a href="{{url('purchase-order');}}">Purchase Order</a> /</span> {{$title}}
    </h6>

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row invoice-add">
            <!-- Purchase Order / Item Details-->
            <div class="col-lg-9 col-12 mb-lg-0 mb-4">
                <div class="card invoice-preview-card">
                <div class="card-body">
                    <!-- Purchase Order -->
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
                            <h5 class="fw-bolder text-decoration-underline">PURCHASE ORDER</h5>
                        </div>
                        <div class="col-md-6">
                            <hr class="mb-0 mt-0">
                            <span class="fw-bolder">Project Name:</span>
                            <span>{{$data->purchase_order_name}}</span>
                            <hr class="mb-0 mt-0">
                            <span class="fw-bolder">Vendor Name:</span>
                            <span>{{$data->vendor_name}}</span>
                            <hr class="mb-0 mt-0">
                            <span class="fw-bolder">Beneficiary:</span>
                            <span>{{$data->beneficiary}}</span>
                            <hr class="mb-0 mt-0">
                            <span class="fw-bolder">Delivery Address:</span>
                            <span>{{$data->storeID->name}}</span>
                        </div>

                        <div class="col-md-6">
                            <hr class="mb-0 mt-0">
                            <span class="fw-bolder">P.O.N:</span>
                            <span>{{$data->purchase_order_no}}</span>
                            <hr class="mb-0 mt-0">
                            <span class="fw-bolder">DATE:</span>
                            <span>{{$data->purchase_order_date}}</span>
                            <hr class="mb-0 mt-0">
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
                                <table class="table" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>Description</th>
                                            <th>Unit</th>
                                            <th>Quantity</th>
                                            <th>Balance</th>
                                            <th>Rate (&#8358;)</th>
                                            <th>Amount (&#8358;)</th>
                                            <th>Quality Check</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(!empty($items))
                                            @php
                                                $subtotal = 0;
                                            @endphp

                                            @foreach ($items as $key => $item)
                                            @php 
                                            $amount = $item->rate * $item->quantity;
                                            $subtotal += $amount;
                                            @endphp
                                            <tr>
                                                <td>{{$item->description}}</td>
                                                <td>{{$item->unitID->description}}</td>
                                                <td>{{ number_format($item->quantity)}}</td>
                                                <td>{{ number_format($item->balance_qty ?? '0')}}</td>
                                                <td>{{ number_format(round($item->rate, 2))}}</td>
                                                <td>{{ number_format(round($amount, 2)) }}</td>
                                                <td>
                                                    @if($item->quality_check == 1)
                                                        <span class="text-success"><i class="bx bx-check"></i></span>
                                                        <span>Checked</span>
                                                    @else
                                                        <span class="text-danger"><i class="bx bx-x"></i></span>
                                                        <span>Checked</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5" class="text-center">No Record Available</td>
                                            </tr>
                                        @endif
                                    </tbody>
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
                    
                    <!-- Approval of Purchase Order Actions-->
                    <h6 class="text-capitalize mb-2 text-nowrap fw-bolder">Approval of Purchase Order</h6>
                    <div class="row">
                    <!--Initiation of purchase order -->
                    <hr class="mx-n1">
                    <div class="col-sm-8">
                        <span class="fw-bolder">Initiated by: </span>
                        <span>{{$data->createdBy->name ?? ''}}</span>
                    </div>
                    <div class="col-sm-4">
                        <span class="fw-bolder">Date: </span>
                        <span>{{$data->purchase_order_date}}</span>
                    </div>

                    <!--Recommendation of purchase order -->
                    @if(!empty($recommend->recommend_by))
                        <hr class="mx-n1">
                        <div class="col-sm-8">
                        <span class="fw-bolder">Recommend by: </span>
                        <span>{{$recommend->recommendID->name ?? ''}}</span>
                        </div>
                        <div class="col-sm-4">
                        <span class="fw-bolder">Date: </span>
                        <span>{{$recommend->recommend_date}}</span>
                        </div>
                    @endif

                    <!--Approval of purchase order -->
                    @if(!empty($approval->approved_action))
                        <hr class="mx-n1">
                        <div class="col-sm-8">
                        <span class="fw-bolder">{{$approval->approved_action ?? ''}} by: </span>
                        <span>{{$approval->approvedID->name ?? '' }}</span>
                        </div>
                        <div class="col-sm-4">
                        <span class="fw-bolder">Date: </span>
                        <span>{{$approval->approved_date}}</span>
                        </div>
                    @endif

                    <!--Quality Check-->
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
                    </div>
                </div>
                </div>
            </div>
            <!-- /Purchase Order / Item Details-->
        
            <!-- Approval Actions -->
            <div class="col-lg-3 col-12 invoice-actions">
                @if(empty($recommend->recommend_by))
                    @can('recommend')
                        <a href="{{ url('po-recommend/'.$data->purchase_order_id) }}" class="btn btn-label-primary d-grid w-100 mb-2">
                        <span class="d-flex align-items-center justify-content-center text-nowrap">
                            <i class="bx bx-paper-plane bx-xs me-1"></i>Recommendation</span>
                        </a> 
                    @endcan
                @elseif(empty($approval->approved_by))
                    @can('mds-approval')
                        <button class="btn btn-label-primary d-grid w-100 mb-2" 
                            data-bs-toggle="offcanvas" 
                            data-bs-target="#approval">
                        <span class="d-flex align-items-center justify-content-center text-nowrap">
                            <i class="bx bx-paper-plane bx-xs me-1"></i>MDs Approval</span>
                        </button>
                    @endcan
                @endif
                @if(!empty($approval->approved_action))
                    <div class="card-header mb-2">
                        <!--Quality Check-->
                        @can('quality-check')
                            @if(empty($qualityCheck->quality_check_by))
                                <a href="{{ url('quality-check/'.$data->purchase_order_id) }}" class="btn btn-label-primary d-grid w-100 mb-2">
                                <span class="d-flex align-items-center justify-content-center text-nowrap">
                                    <i class="bx bx-check bx-xs me-1"></i>Quality Check</span>
                                </a>
                            @endif
                        @endcan

                        <!--Raised SRA-->
                        @can('index-sra')
                            @if(!empty($qualityCheck->quality_check_by))
                                <a href="{{ url('confirm-item/'.$data->purchase_order_id) }}" class="btn btn-label-primary d-grid w-100 mb-2">
                                <span class="d-flex align-items-center justify-content-center text-nowrap">
                                    <i class="bx bx-dock-top bx-xs me-1"></i>Raised SRA</span>
                                </a>
                            @endif
                            @if($data->status == 'Incomplete')
                            <a href="{{ url('po-balance/'.$data->purchase_order_id)}}" class="btn btn-label-primary d-grid w-100 mb-2">
                                <span class="d-flex align-items-center justify-content-center text-nowrap">
                                <i class="bx bx-dock-top bx-xs me-1"></i>Order Balance</span>
                            </a>
                            @endif
                        @endcan

                        <!--Print-->
                        <button class="btn btn-label-primary d-grid w-100" onclick="window.print()">
                            <span class="d-flex align-items-center justify-content-center text-nowrap">
                            <i class="bx bx-file bx-xs me-1"></i>Print</span>
                        </button>
                    </div>
                @endif
                
                <!-- Approval Note -->
                @if(!empty($recommend->recommend_by))
                <div class="card mb-4">
                    <div class="card-body">
                        <h6 class="fw-bolder">Recommendation Note:</h6>
                        <p>{{$recommend->recommend_note}}</p>
                        <hr>
                   

                        @if(!empty($approval->approved_by))
                            <h6 class="fw-bolder">MDs Approved Note:</h6>
                            <p>{{$approval->approved_note}}</p>
                        @endif

                        @if(!empty($qualityCheck->quality_check_by))
                            <h6 class="fw-bolder">Quality Check Note:</h6>
                            <p>{{$qualityCheck->quality_check_note}}</p>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Modify Purchase Order / Item -->
                @can('modify-po')
                <div class="card">
                    <div class="card-header">
                        <p class="mb-2 fw-bolder">Purchase Order / Item</p>
                    </div>
                    <div class="card-body">
                        @if(empty($approval->approved_action))
                            <div class="d-flex justify-content-between mb-2">
                                <label for="payment-terms" class="mb-0">Purchase Order</label>
                                <label class="switch switch-primary me-0">
                                    <span class="switch-label">
                                    <a href="{{ url('purchase-order-edit/'.$data->purchase_order_id)}}">
                                        <i class="bx bx-pencil bx-sm me-sm-n2"></i>
                                    </a> 
                                    </span>
                                </label>
                            </div>
                        @endif
                    </div>
                </div>
                @endcan
            </div>
            <!-- /Approval Actions -->
        </div>
        
        <!-- Offcanvas -->
        <!-- Send Approval Sidebar -->
        <div class="offcanvas offcanvas-end" id="approval" aria-hidden="true">
            <div class="offcanvas-header mb-3">
                <h5 class="offcanvas-title">Approval Action</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body flex-grow-1">
                <form wire:submit="approval">
                    <input type="hidden" wire:model="approvedID">
                    <div class="mb-3">
                        <label for="invoice-from" class="form-label">Action</label>
                        <select class="form-select mb-4" wire:model="approved_action" required>
                            <option value=""></option>
                            <option value="Approved">Approve</option>
                            <option value="Rejected">Reject</option>
                        </select>
                        @error("approved_action") <span class="error">{{ $message }}</span> @enderror 
                    </div>
                    
                    <div class="mb-3">
                        <label for="invoice-message" class="form-label">Message</label>
                        <textarea class="form-control" wire:model="approved_note" id="invoice-message" cols="3" rows="3" required></textarea>
                        @error("approved_note") <span class="error">{{ $message }}</span> @enderror 
                    </div>
                    <div class="mb-3 d-flex flex-wrap">
                        <button type="submit" class="btn btn-primary me-3" data-bs-dismiss="offcanvas">Save</button>
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /Send Approval Sidebar -->
        
        <!-- /Offcanvas -->
                
                
    </div>
</div>
