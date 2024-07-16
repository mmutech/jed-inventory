<div>
    <h6 class="py-1 mb-2">
    <span class="text-muted fw-light"><a href="{{url('srcn-index');}}">SRCN</a> /</span> {{$title}}
    </h6>

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row invoice-add">
            <!-- SRCN / Item Details-->
            <div class="col-lg-9 col-12 mb-lg-0 mb-4">
                <div class="card invoice-preview-card">
                    <div class="card-body">
                        <!-- SRCN -->
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
                                <h6 class="fw-bolder text-decoration-underline">STORES REQUISITION AND CONSIGNMENT NOTE (SRCN)</h6>
                            </div>
                            
                            <div class="col-md-6">
                                <span class="fw-bolder">Requisition Store:</span>
                                <span>{{$data->requisitionStationID->name}}</span>
                                <hr class="mb-0 mt-0">
                            </div>

                            <div class="col-md-6">
                                <span class="fw-bolder">Requisition Date:</span>
                                <span>{{$data->requisition_date}}</span>
                                <hr class="mb-0 mt-0">
                            </div>

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
                            Requisition Items
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
                                                <th>Quantity Required (Unit)</th>
                                                <th>Allocation</th>
                                            </tr>
                                        </thead>
                                            @if(!empty($items))
                                                @foreach ($items as $key => $item)
                                                <tr>
                                                    <td>{{$item->stockCodeID->stock_code}}</td>
                                                    <td>{{$item->stockCodeID->name}}</td>
                                                    <td>{{ number_format($item->required_qty)}}({{$item->unitID->description}})</td>
                                                    <td>{{ number_format($item->allocated_qty)}}</td>
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

                        <!-- SRCN Remark-->
                        <h6 class="text-capitalize mb-2 text-nowrap fw-bolder">REMARKS</h6>
                        <div class="row">
                            <!--Preparation of SRCN -->
                            @if(!empty($data->created_by))
                                <hr class="mx-n1">
                                <div class="col-sm-8">
                                    <span class="fw-bolder">Prepared by: </span>
                                    <span>{{$data->preparedBy->name ?? ''}}</span>
                                </div>
                                <div class="col-sm-4">
                                    <span class="fw-bolder">Date: </span>
                                    <span>{{$data->requisition_date}}</span>
                                </div>
                            @endif

                            <!--Recommendation -->
                            @if(!empty($recommend->recommend_by))
                                <hr class="mx-n1">
                                <div class="col-sm-8">
                                    <span class="fw-bolder">{{$recommend->recommend_action}} by: </span>
                                    <span>{{$recommend->recommendID->name ?? '' }}</span>
                                </div>
                                <div class="col-sm-4">
                                    <span class="fw-bolder">Date: </span>
                                    <span>{{$recommend->recommend_date}}</span>
                                </div>
                            @endif

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

                            <!--HAOP Approval -->
                            @if(!empty($approval->approved_by))
                                <hr class="mx-n1">
                                <div class="col-sm-8">
                                    <span class="fw-bolder">{{$approval->approved_action}} By HAOP: </span>
                                    <span>{{$approval->approvedID->name ?? '' }}</span>
                                </div>
                                <div class="col-sm-4">
                                    <span class="fw-bolder">Date: </span>
                                    <span>{{$approval->approved_date}}</span>
                                </div>
                            @endif

                            <!--Despatch -->
                            @if(!empty($despatch->despatched_by))
                                <hr class="mx-n1">
                                <div class="col-sm-8">
                                    <span class="fw-bolder">Despatched By: </span>
                                    <span>{{$despatch->despatchedBy->name ?? '' }}</span>
                                </div>
                                <div class="col-sm-4">
                                    <span class="fw-bolder">Date: </span>
                                    <span>{{$despatch->despatched_date}}</span>
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
                                    <span>{{$received->received_date ?? ''}}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- /SRCN / Item Details-->
            
            <!-- Actions -->
            <div class="col-lg-3 col-12 invoice-actions">
                <div class="card-header mb-2"> 
                    <!--Print-->
                    @if(!empty($hod_approval->hod_approved_by))
                    <button class="btn btn-label-primary d-grid w-100" onclick="window.print()">
                        <span class="d-flex align-items-center justify-content-center text-nowrap">
                        <i class="bx bx-file bx-xs me-1"></i>Print</span>
                    </button>
                    @endif

                    @if(empty($recommend->recommend_by))
                    @can('recommend')
                    <button class="btn btn-label-primary d-grid w-100 mt-2" 
                        data-bs-toggle="offcanvas" 
                        data-bs-target="#recommendation">
                    <span class="d-flex align-items-center justify-content-center text-nowrap">
                        <i class="bx bx-paper-plane bx-xs me-1"></i>Recommendation</span>
                    </button>
                    @endcan
                    @endif

                    @if(!empty($hod_approval->hod_approved_by))
                        @if(empty($approval->approved_by))
                            @can('haop-approval')
                                <button class="btn btn-label-primary d-grid w-100 mt-2" 
                                    data-bs-toggle="offcanvas" 
                                    data-bs-target="#approval">
                                <span class="d-flex align-items-center justify-content-center text-nowrap">
                                    <i class="bx bx-paper-plane bx-xs me-1"></i>HAOP Approval</span>
                                </button>
                            @endcan
                        @endif
                    @endif

                    <!--Issue-->
                    @if($issuedStoreID == $storeID)
                        <a class="btn btn-label-primary d-grid w-100 mt-2" 
                            href="{{ url('srcn-issue/'.$data->srcn_id) }}">
                            <span class="d-flex align-items-center justify-content-center text-nowrap">
                                <i class="bx bx-paper-plane bx-xs me-1"></i>Issue</span>
                        </a>
                    @endif

                    <!--Received-->
                    @if($createdBy == Auth()->user()->id && !empty($issued_store))
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
                    <!-- Recommendation Note -->
                    @if(!empty($recommend->recommend_by))
                        <h6 class="fw-bolder">{{$recommend->recommend_action ?? ''}} Note:</h6>
                        <p>{{$recommend->recommend_note ?? ''}}</p>
                    @endif

                    <!-- HOD Approval Note -->
                    @if(!empty($approval->approved_by))
                        <h6 class="fw-bolder">HOD {{$hod_approval->hod_approved_action ?? ''}} Note:</h6>
                        <p>{{$hod_approval->hod_approved_note ?? ''}}</p>
                    @endif

                    <!-- HAOP Approval Note -->
                    @if(!empty($approval->approved_by))
                        <h6 class="fw-bolder">HAOP {{$approval->approved_action ?? ''}} Note:</h6>
                        <p>{{$approval->approved_note ?? ''}}</p>
                    @endif

                    <!-- Despatch Note -->
                    @if(!empty($despatch->despatched_by))
                        <h6 class="fw-bolder">Despatch Note:</h6>
                        <p>{{$despatch->despatched_note}}</p>
                    @endif

                    <!-- Received Note -->
                    @if(!empty($received->received_by))
                        <h6 class="fw-bolder">Receive Note:</h6>
                        <p>{{$received->received_note}}</p>
                    @endif
                    </div>
                </div>

                <!-- HOD Approval Action -->
                @if(!empty($recommend->recommend_by))
                    @if(empty($hod_approval->hod_approved_by))
                        @can('hod-approval')
                            <div class="card">
                                <div class="card-header">
                                    <p class="mb-2 fw-bolder">HOD Approval</p>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-2">
                                        <label for="payment-terms" class="mb-0">{{$data->srcn_code}}</label>
                                        <label class="switch switch-primary me-0">
                                            <span class="switch-label">
                                                <a href="{{ url('srcn-allocation/'.$data->srcn_id) }}">
                                                <i class="bx bx-pencil bx-sm me-sm-n2"></i></a>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        @endcan
                    @endif
                @endif
            </div>
            <!-- /Actions -->
        </div>

        <!-- Offcanvas -->
        <!-- Recommendation Sidebar -->
        <div class="offcanvas offcanvas-end" id="recommendation" aria-hidden="true">
            <div class="offcanvas-header mb-0">
                <h5 class="offcanvas-title">Recommendation Actions</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <hr class="mx-n1">
            <div class="offcanvas-body flex-grow-1">
                <form wire:submit="recommend">
                    <div class="mb-3">
                        <label for="invoice-from" class="form-label">Recommendation Action</label>
                        <select class="form-select mb-4" wire:model="recommend_action" required>
                            <option value=""></option>
                            <option value="Recommend">Recommend</option>
                            <option value="Rejected">Reject</option>
                        </select>
                        @error("recommend_action") <span class="error">{{ $message }}</span> @enderror 
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
        <!-- /Recommendation Sidebar -->

        <!-- HAOP Approval Sidebar -->
        <div class="offcanvas offcanvas-end" id="approval" aria-hidden="true">
            <div class="offcanvas-header mb-0">
                <h5 class="offcanvas-title">Head of Account Operation Approval</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <hr class="mx-n1">
            <div class="offcanvas-body flex-grow-1">
                <form wire:submit="haopApproval">
                    <div class="mb-3">
                        <label for="invoice-from" class="form-label">HAOP Approval</label>
                        <select class="form-select mb-4" wire:model="approved_action" required>
                            <option value=""></option>
                            <option value="Approved">Approve</option>
                            <option value="Rejected">Reject</option>
                        </select>
                        @error("approved_action") <span class="error">{{ $message }}</span> @enderror 
                    </div>
                    <div class="mb-3">
                        <label for="invoice-message" class="form-label">HAOP Approval Remark</label>
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
        <!-- /HOD Approval Sidebar -->

         <!-- Despatched Sidebar -->
         <div class="offcanvas offcanvas-end" id="despatch" aria-hidden="true">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title">Despatch</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <hr class="mx-n1">
            <div class="offcanvas-body flex-grow-1">
                <form wire:submit="despatched">
                    <div class="mb-3">
                        <label for="invoice-message" class="form-label">Despatch Note</label>
                        <textarea class="form-control" wire:model="despatched_note" id="invoice-message" cols="3" rows="3"></textarea>
                        @error("despatched_note") <span class="error">{{ $message }}</span> @enderror 
                    </div>
                    <hr>
                    
                
                    <div class="mb-3 d-flex flex-wrap">
                        <button type="submit" class="btn btn-primary me-3" data-bs-dismiss="offcanvas">Save</button>
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /Despatched Sidebar -->

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
