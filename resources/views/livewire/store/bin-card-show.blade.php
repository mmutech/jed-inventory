<div>
    <h6 class="py-1 mb-2">
    <span class="text-muted fw-light"><a href="{{url('bin-card-index');}}">Store Bin Card</a> /</span> {{$title}}
    </h6>

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row invoice-add">
            <!-- Bin Card / Item Details-->
            <div class="col-lg-10 col-12 mb-lg-0 mb-4">
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

                            <div class="col-md-12 mb-2 text-center">
                                <h5 class="fw-bolder text-decoration-underline">STORES BIN CARD</h5>
                            </div>
                            
                            <div class="col-md-6">
                                <span class="fw-bolder">Maximum:</span>
                                <span>{{number_format($max)}}</span>
                                <hr class="mb-0 mt-0">
                            </div>

                            <div class="col-md-6">
                                <span class="fw-bolder">Vocab No:</span>
                                <span>{{ $data->stockCodeID->stock_code }}</span>
                                <hr class="mb-0 mt-0">
                            </div>
                            
                            <div class="col-md-6">
                                <span class="fw-bolder">Minimum:</span>
                                <span>{{number_format($min)}}</span>
                                <hr class="mb-0 mt-0">
                            </div>

                            <div class="col-md-6">
                                <span class="fw-bolder">Unit of Issue:</span>
                                <span>{{$data->unit}}</span>
                                <hr class="mb-0 mt-0">
                            </div>

                            <!--Re-Order-->
                            <div class="col-md-6">
                                @if($max < 10)
                                <span class="fw-bolder badge bg-label-danger">Re-order</span>
                                <hr class="mb-0 mt-0">
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12">
                            <span class="fw-bolder">DESCRIPTION:</span>
                            <span>{{ $data->stockCodeID->name }} </span>
                            <hr class="mb-0 mt-0">
                        </div>
                       
                        <div class="mb-3 mt-0" data-repeater-list="group-a">
                            <div class="repeater-wrapper pt-0 pt-md-4" data-repeater-item="">
                                <div class="table-responsive text-nowrap">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Date Receipt/Issue</th>
                                                <th>Reference</th>
                                                <th>Vendor Name</th>
                                                <th>station</th>
                                                <th>In</th>
                                                <th>Out</th>
                                                <th>Balance</th>
                                                <th>Initial</th>
                                            </tr>
                                        </thead>
                                            @if(!empty($items))
                                                @foreach ($items as $key => $item)
                                                <tr>
                                                    <td>{{ $item->date_receipt }} {{ $item->date_issue }}</td>
                                                    <td>{{ $item->reference }}</td>
                                                    <td>{{ $item->purchaseOrderID->vendor_name ?? '' }}</td>
                                                    <td>{{ $item->stationID->name }}</td>
                                                    <td>{{ $item->in }}</td>
                                                    <td>{{ $item->out }}</td>
                                                    <td>{{ $item->balance }}</td>
                                                    <td>{{ $item->storeOfficerID->name }}</td>
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
                    </div>
                </div>
            </div>
            <!-- /Bin Card / Item Details-->

             <!-- Print Actions -->
             <div class="col-lg-2 col-12 invoice-actions">
                <div class="card-header mb-2"> 
                    <!--Print-->
                    <button class="btn btn-label-primary d-grid w-100">
                        <span class="d-flex align-items-center justify-content-center text-nowrap">
                        <i class="bx bx-file bx-xs me-1"></i>Print</span>
                    </button>
                </div>
            </div>
            <!-- /Print Actions --> 
        </div>      
    </div>
</div>
