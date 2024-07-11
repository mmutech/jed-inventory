<div>
    <h6 class="py-1 mb-2">
    <span class="text-muted fw-light"><a href="{{url('srin-index');}}">SRIN</a> /</span> {{$title}}
    </h6>

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row invoice-add">
            <!-- SRIN / Item Details-->
            <div class="col-lg-9 col-12 mb-lg-0 mb-4">
                <div class="card invoice-preview-card">
                    <div class="card-body">
                        <!-- SRIN -->
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
                                <h6 class="fw-bolder text-decoration-underline">STORES REQUISITION / ISSUE NOTE (SRIN)</h6>
                            </div>

                            <div class="col-md-8">
                                <span class="fw-bolder">Location:</span>
                                <span>{{$data->locationID->name}}</span>
                                <hr class="mb-3 mt-0">
                            </div>
                            <div class="col-md-4">
                                <span class="fw-bolder">SRIN Code:</span>
                                <span>{{$data->srin_code}}</span>
                                <hr class="mb-3 mt-0">
                            </div>
                            
                            <div class="col-md-8">
                                <span class="fw-bolder">Requisition By:</span>
                                <span>{{$data->requisitionBy->name}}</span>
                                <hr class="mb-3 mt-0">
                            </div>

                            <div class="col-md-4">
                                <span class="fw-bolder">Date:</span>
                                <span>{{$data->requisition_date}}</span>
                                <hr class="mb-3 mt-0">
                            </div>   

                            <!-- Lorry Details -->
                            <div class="col-md-12 mb-4"></div>
                            @if($vehicle->count() > 0)
                                <h5>Pickup Vehicle</h5><hr>
                                @foreach($vehicle as $veh)
                                    <div class="col-md-4">
                                        <span class="fw-bolder">Lorry No:</span>
                                        <span>{{$veh->lorry_no}}</span>
                                        <hr class="mb-0 mt-0">
                                    </div>

                                    <div class="col-md-8">
                                        <span class="fw-bolder">Driver Name:</span>
                                        <span>{{$veh->driver_name}}</span>
                                        <hr class="mb-0 mt-0">
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        
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
                                                <th>Quantity Required(Unit)</th>
                                                <th>Allocated</th>
                                            </tr>
                                        </thead>
                                            @if(!empty($items))
                                                @foreach ($items as $key => $item)
                                                <tr>
                                                    <td>{{$item->stockCodeID->stock_code}}</td>
                                                    <td>{{$item->description}}</td>
                                                    <td>{{ number_format($item->required_qty)}}({{$item->unitID->description}})</td>
                                                    <td>{{ number_format($item->issued_qty)}}</td>
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

                        <!-- SRIN Remark-->
                        <h6 class="text-capitalize mb-2 text-nowrap fw-bolder">REMARKS</h6>
                        <div class="row">
                            <!--HOD Approval -->
                            @if(!empty($hod_approval->hod_approved_by))
                                <hr class="mx-n1">
                                <div class="col-sm-8">
                                    <span class="fw-bolder">{{$hod_approval->hod_approved_action}} By HOD: </span>
                                    <span>{{$hod_approval->hodApproved->name ?? '' }}</span>
                                </div>
                                <div class="col-sm-4">
                                    <span class="fw-bolder">Date: </span>
                                    <span>{{$hod_approval->hod_approved_date}}</span>
                                </div>
                            @endif

                            <!--FA Approval -->
                            @if(!empty($fa_approval->fa_approved_by))
                                <hr class="mx-n1">
                                <div class="col-sm-8">
                                    <span class="fw-bolder">{{$fa_approval->fa_approved_action}} By FA: </span>
                                    <span>{{$fa_approval->faApproved->name ?? '' }}</span>
                                </div>
                                <div class="col-sm-4">
                                    <span class="fw-bolder">Date: </span>
                                    <span>{{$fa_approval->fa_approved_date}}</span>
                                </div>
                            @endif

                             <!--Despatch -->
                             @if(!empty($despatched->despatched_by))
                                <hr class="mx-n1">
                                <div class="col-sm-8">
                                    <span class="fw-bolder">Despatched By: </span>
                                    <span>{{$despatched->despatchedBy->name ?? '' }}</span>
                                </div>
                                <div class="col-sm-4">
                                    <span class="fw-bolder">Date: </span>
                                    <span>{{$despatched->despatched_date}}</span>
                                </div>
                            @endif

                            <!--Received -->
                            @if(!empty($received->received_by))
                                <hr class="mx-n1">
                                <div class="col-sm-8">
                                    <span class="fw-bolder">Received By: </span>
                                    <span>{{$received->receivedID->name ?? '' }}</span>
                                </div>
                                <div class="col-sm-4">
                                    <span class="fw-bolder">Date: </span>
                                    <span>{{$received->received_date}}</span>
                                </div>
                            @endif
                        </div>
                        
                    </div>
                </div>
            </div>
            <!-- /SRIN / Item Details-->
            <!-- Actions -->
            <div class="col-lg-3 col-12 invoice-actions">
                <div class="card-header mb-2"> 
                    <!--Print-->
                    <button class="btn btn-label-primary d-grid w-100">
                        <span class="d-flex align-items-center justify-content-center text-nowrap">
                        <i class="bx bx-file bx-xs me-1"></i>Print</span>
                    </button>

                    @if(!empty($hod_approval->hod_approved_by))
                        @if(empty($fa_approval->fa_approved_by))
                            @can('fa-approved')
                                <button class="btn btn-label-primary d-grid w-100 mt-2" 
                                    data-bs-toggle="offcanvas" 
                                    data-bs-target="#fa_approval">
                                <span class="d-flex align-items-center justify-content-center text-nowrap">
                                    <i class="bx bx-paper-plane bx-xs me-1"></i>FA Approval</span>
                                </button>
                            @endcan
                        @endif
                    @endif
                    
                    <!--Issue-->
                    @if($issuedStoreID == $storeID && !empty($fa_approval->fa_approved_by))
                        <a class="btn btn-label-primary d-grid w-100 mt-2" 
                            href="{{ url('srin-issue/'.$data->srin_id) }}">
                            <span class="d-flex align-items-center justify-content-center text-nowrap">
                                <i class="bx bx-paper-plane bx-xs me-1"></i>Issue</span>
                        </a>
                    @endif

                    <!--Received-->
                    @if($createdBy == Auth()->user()->id && empty($received->received_by))
                        <button class="btn btn-label-primary d-grid w-100 mt-2" 
                            data-bs-toggle="offcanvas" 
                            data-bs-target="#received">
                        <span class="d-flex align-items-center justify-content-center text-nowrap">
                            <i class="bx bx-paper-plane bx-xs me-1"></i>Received</span>
                        </button>
                    @endif
                </div>

                <!-- Note -->
                <div class="card mb-4">
                    <div class="card-body">
                    <!-- HOD Approval Note -->
                    @if(!empty($hod_approval->hod_approved_by))
                        <h6 class="fw-bolder">HOD {{$hod_approval->hod_approved_action}} Note:</h6>
                        <p>{{$hod_approval->hod_approved_note}}</p>
                    @endif

                    <!-- FA Approval Note -->
                    @if(!empty($fa_approval->fa_approved_by))
                        <h6 class="fw-bolder">FA {{$fa_approval->fa_approved_action}} Note:</h6>
                        <p>{{$fa_approval->fa_approved_note}}</p>
                    @endif

                    <!-- Despatch Note -->
                    @if(!empty($despatched->despatched_by))
                        <h6 class="fw-bolder">Despatch Note:</h6>
                        <p>{{$despatched->despatched_note}}</p>
                    @endif

                    <!-- Received Note -->
                    @if(!empty($received->received_by))
                        <h6 class="fw-bolder">Receive Note:</h6>
                        <p>{{$received->received_note}}</p>
                    @endif
                    </div>
                </div>

                <!-- HOD Approval Action -->
                @if(empty($hod_approval->hod_approved_by))
                    @can('hod-approval')
                        <div class="card">
                            <div class="card-header">
                                <p class="mb-2 fw-bolder">HOD Approval</p>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <label for="payment-terms" class="mb-0">{{$data->srin_code}}</label>
                                    <label class="switch switch-primary me-0">
                                        <span class="switch-label">
                                            <a href="{{ url('srin-allocation/'.$data->srin_id) }}">
                                            <i class="bx bx-pencil bx-sm me-sm-n2"></i></a>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endcan
                @endif
            </div>
            <!-- /Actions --> 
        </div>

        <!-- Offcanvas -->

        <!-- FA Approval Sidebar -->
        <div class="offcanvas offcanvas-end" id="fa_approval" aria-hidden="true">
            <div class="offcanvas-header mb-0">
                <h5 class="offcanvas-title">Finance and Account Approval</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <hr class="mx-n1">
            <div class="offcanvas-body flex-grow-1">
                <form wire:submit="faApproval">
                    <div class="mb-3">
                        <label for="invoice-from" class="form-label">FA Approval</label>
                        <select class="form-select mb-4" wire:model="fa_approved_action" required>
                            <option value=""></option>
                            <option value="Approved">Approve</option>
                            <option value="Rejected">Reject</option>
                        </select>
                        @error("fa_approved_action") <span class="error">{{ $message }}</span> @enderror 
                    </div>
                    <div class="mb-3">
                        <label for="invoice-message" class="form-label">FA Approval Remark</label>
                        <textarea class="form-control" wire:model="fa_approved_note" id="invoice-message" cols="3" rows="3" required></textarea>
                        @error("fa_approved_note") <span class="error">{{ $message }}</span> @enderror 
                    </div>
                
                    <div class="mb-3 d-flex flex-wrap">
                        <button type="submit" class="btn btn-primary me-3" data-bs-dismiss="offcanvas">Save</button>
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /FA Approval Sidebar -->

         <!-- Despatch Sidebar -->
         <div class="offcanvas offcanvas-end" id="despatch" aria-hidden="true">
            <div class="offcanvas-header mb-0">
                <h5 class="offcanvas-title">Despatch Items</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <hr class="mx-n1">
            <div class="offcanvas-body flex-grow-1">
                <form wire:submit="despatched">
                    <div class="mb-3">
                        <label for="invoice-message" class="form-label">Despatched Note</label>
                        <textarea class="form-control" wire:model="despatched_note" id="invoice-message" cols="3" rows="3"></textarea>
                        @error("despatched_note") <span class="error">{{ $message }}</span> @enderror 
                    </div>
                
                    <div class="mb-3 d-flex flex-wrap">
                        <button type="submit" class="btn btn-primary me-3" data-bs-dismiss="offcanvas">Save</button>
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /Received Sidebar -->

        <!-- Received Sidebar -->
        <div class="offcanvas offcanvas-end" id="received" aria-hidden="true">
            <div class="offcanvas-header mb-0">
                <h5 class="offcanvas-title">Receive Items</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <hr class="mx-n1">
            <div class="offcanvas-body flex-grow-1">
                <form wire:submit="received">
                    <div class="mb-3">
                        <label for="invoice-message" class="form-label">Received Note</label>
                        <textarea class="form-control" wire:model="received_note" id="invoice-message" cols="3" rows="3"></textarea>
                        @error("received_note") <span class="error">{{ $message }}</span> @enderror 
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
