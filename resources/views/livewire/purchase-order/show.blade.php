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
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Description</th>
                                            <th>Unit</th>
                                            <th>Quantity</th>
                                            <th>Rate (&#8358;)</th>
                                            <th>Amount (&#8358;)</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
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
                                                <td><a href=""></a></td>
                                                <td>{{$item->description}}</td>
                                                <td>{{$item->unit}}</td>
                                                <td>{{ number_format($item->quantity)}}</td>
                                                <td>{{ number_format(round($item->rate, 2))}}</td>
                                                <td>{{ number_format(round($amount, 2)) }}</td>
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
                    @if(!empty($recommend->recommend_action))
                        <hr class="mx-n1">
                        <div class="col-sm-8">
                        <span class="fw-bolder">{{$recommend->recommend_action ?? ''}} by: </span>
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
                    </div>
                </div>
                </div>
            </div>
            <!-- /Purchase Order / Item Details-->
        
            <!-- Approval Actions -->
            <div class="col-lg-3 col-12 invoice-actions">
                @if(!empty($approval->approved_action))
                    <div class="card-header mb-2">
                        <!--Raised SRA-->
                        <a href="{{ url('confirm-item/'.$data->purchase_order_id) }}" class="btn btn-label-primary d-grid w-100 mb-2">
                        <span class="d-flex align-items-center justify-content-center text-nowrap">
                            <i class="bx bx-dock-top bx-xs me-1"></i>Raised SRA</span>
                        </a>

                        <!--Print-->
                        <button class="btn btn-label-primary d-grid w-100">
                            <span class="d-flex align-items-center justify-content-center text-nowrap">
                            <i class="bx bx-file bx-xs me-1"></i>Print</span>
                        </button>
                    </div>
                @endif
                

                <!-- Approval Note -->
                <div class="card mb-4">
                    <div class="card-body">
                    @if(!empty($recommend->recommend_by))
                        <h6 class="fw-bolder">Recommendation Note:</h6>
                        <p>{{$recommend->recommend_note}}</p>
                        <hr>
                    @endif

                    @if(!empty($approval->approved_by))
                        <h6 class="fw-bolder">Approved Note:</h6>
                        <p>{{$approval->approved_note}}</p>
                    @endif

                    @if(empty($recommend->recommend_by))
                        <button 
                            class="btn btn-primary d-grid w-100 mb-3" 
                            data-bs-toggle="offcanvas" 
                            data-bs-target="#recommendation">
                        <span class="d-flex align-items-center justify-content-center text-nowrap">
                            <i class="bx bx-paper-plane bx-xs me-1"></i>Recommendation</span>
                        </button>
                    @elseif(empty($approval->approved_by))
                        <button 
                            class="btn btn-label-primary d-grid w-100" 
                            data-bs-toggle="offcanvas" 
                            data-bs-target="#approval">
                        <span class="d-flex align-items-center justify-content-center text-nowrap">
                            <i class="bx bx-paper-plane bx-xs me-1"></i>Approval</span>
                        </button>
                    @endif
                    </div>
                </div>

                <!-- Modify Purchase Order / Item -->
                @if(empty($approval->approved_action))
                <div class="card">
                    <div class="card-header">
                        <p class="mb-2 fw-bolder">Purchase Order / Item</p>
                    </div>
                    <div class="card-body">
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
                        <div class="d-flex justify-content-between mb-2">
                        <label for="client-notes" class="mb-0">Item</label>
                        <label class="switch switch-primary me-0">
                            <span class="switch-label">
                            <a href="{{ url('purchase-order-edit-item/'.$data->purchase_order_id)}}">
                                <i class="bx bx-pencil bx-sm me-sm-n2"></i>
                            </a>
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
        <!-- Send Recommendation Sidebar -->
        <div class="offcanvas offcanvas-end" id="recommendation" aria-hidden="true">
            <div class="offcanvas-header mb-0">
                <h5 class="offcanvas-title">Recommendation</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <hr class="mx-n1">
            <div class="offcanvas-body flex-grow-1">
                <form wire:submit="recommends">
                    <div class="mb-3">
                        <label for="invoice-from" class="form-label">Recommendation Action</label>
                        <select class="form-select mb-4" wire:model="recommended_action" required>
                            <option value=""></option>
                            <option value="Recommend">Recommend</option>
                            <option value="Rejected">Reject</option>
                        </select>
                        @error("recommended_action") <span class="error">{{ $message }}</span> @enderror 
                    </div>
                    <div class="mb-3">
                        <label for="invoice-message" class="form-label">Recommendation Remark</label>
                        <textarea class="form-control" wire:model="recommend_note" id="invoice-message" cols="3" rows="3" required></textarea>
                        @error("recommend_note") <span class="error">{{ $message }}</span> @enderror 
                    </div>
                
                    <div class="mb-3 d-flex flex-wrap">
                        <button type="submit" class="btn btn-primary me-3" data-bs-dismiss="offcanvas">Save</button>
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
       
        <!-- /Send Recommendation Sidebar -->

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
