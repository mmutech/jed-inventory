<div>
    <h6 class="py-1 mb-2">
        <span class="text-muted fw-light"><a href="{{url('scn-index');}}">SCN</a> /</span> {{$title}}
    </h6>

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row invoice-add">
            <!-- SCN / Item Details-->
            <div class="col-lg-9 col-12 mb-lg-0 mb-4">
                <div class="card invoice-preview-card">
                    <div class="card-body">
                        <!-- SCN -->
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
                                <h6 class="fw-bolder text-decoration-underline">STORES CREDIT NOTE (SCN)</h6>
                            </div>

                            <div class="col-md-8">
                                <span class="fw-bolder">JOB FROM:</span>
                                <span>{{$data->jobFrom->name}}</span>
                                <hr class="mb-3 mt-0">
                            </div>
                            <div class="col-md-4">
                                <span class="fw-bolder">SCN Code:</span>
                                <span>{{$data->scn_code}}</span>
                                <hr class="mb-3 mt-0">
                            </div>
                            
                            <div class="col-md-8">
                                <span class="fw-bolder">Returned By:</span>
                                <span>{{$data->createdBy->name}}</span>
                                <hr class="mb-3 mt-0">
                            </div>

                            <div class="col-md-4">
                                <span class="fw-bolder">Date:</span>
                                <span>{{$data->created_at->format('Y-m-d')}}</span>
                                <hr class="mb-3 mt-0">
                            </div>   
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
                                                <th>Quantity (Unit)</th>
                                            </tr>
                                        </thead>
                                            @if(!empty($items))
                                                @foreach ($items as $key => $item)
                                                <tr>
                                                    <td>{{$item->stockCodeID->stock_code}}</td>
                                                    <td>{{$item->stockCodeID->name}}</td>
                                                    <td>{{ number_format($item->quantity)}}({{$item->unitID->description}})</td>
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

                        <!-- SCN Remark-->
                        <h6 class="text-capitalize mb-2 text-nowrap fw-bolder">REMARKS</h6>
                        <div class="row">
                            <!--Received -->
                            @if(!empty($data->received_by))
                                <hr class="mx-n1">
                                <div class="col-sm-8">
                                    <span class="fw-bolder">Received By: </span>
                                    <span>{{$data->receivedBy->name ?? '' }}</span>
                                </div>
                                <div class="col-sm-4">
                                    <span class="fw-bolder">Date: </span>
                                    <span>{{$data->returned_date}}</span>
                                </div>
                            @endif
                        </div>   
                    </div>
                </div>
            </div>
            <!-- /SCN / Item Details-->
            
            <!-- Actions -->
            <div class="col-lg-3 col-12 invoice-actions">
                <div class="card-header mb-2"> 
                    <!--Print-->
                    <button class="btn btn-label-primary d-grid w-100" onclick="window.print()">
                        <span class="d-flex align-items-center justify-content-center text-nowrap">
                        <i class="bx bx-file bx-xs me-1"></i>Print</span>
                    </button>
                 
                    <!--Received-->
                    @if(empty($received->received_by))
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
                    <!-- Received Note -->
                    @if(!empty($received->received_by))
                        <h6 class="fw-bolder">Receive Note:</h6>
                        <p>{{$received->received_note}}</p>
                    @endif
                    </div>
                </div>
            </div>
            <!-- /Actions --> 
        </div>

        <!-- Offcanvas -->

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
