<div>
    <h6 class="py-1 mb-2">
    <span class="text-muted fw-light"><a href="{{url('bin-card-index');}}">Store Bin Card</a> /</span> {{$title}}
    </h6>

    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- <div class="row mb-3">
            <div class="col-sm-4">
                <div class="input-group input-group-merge">
                    <input type="text" class="form-control" wire:model="search" wire:keydown.enter="stockCode" placeholder="Search Stock Code..." />
                    <button class="input-group-text btn btn-outline-primary" wire:click="stockCode" id="basic-addon-search31"><i class="bx bx-search"></i></button>
                </div>
            </div>
        </div> -->
        <div class="row invoice-add">
            <!-- Bin Card / Item Details-->
            <div class="col-lg-12 col-12 mb-lg-0 mb-4">
                <div class="card invoice-preview-card">
                    <div class="card-body">
                        <!-- Bin Card -->
                        <div class="row p-sm-3 p-0">
                            <div class="col-12 mb-md-0 mb-4">
                                <div class="d-flex svg-illustration mb-2 gap-2 justify-content-center">
                                    <span class="app-brand-logo demo align-items-left">
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
                                <span>{{$data->unitID->description ?? ''}}</span>
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

                        <div class="row p-sm-3 p-0">
                            <div class="col-md-8">
                                <span class="fw-bolder">DESCRIPTION:</span>
                                <span>{{ $data->stockCodeID->name }} </span>
                                <hr class="mb-0 mt-0">
                            </div>
                            <div class="col-md-4">
                                <span class="fw-bolder">Basic Price:</span>
                                <span>&#8358; {{number_format($data->basic_price) ?? ''}}</span>
                                <hr class="mb-0 mt-0">
                            </div>
                        
                            <div class="mb-3 mt-0" data-repeater-list="group-a">
                                <div class="repeater-wrapper pt-0 pt-md-4" data-repeater-item="">
                                    <div class="table-responsive text-nowrap">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th colspan="3"></th>
                                                    <th colspan="3" class="text-center fw-bolder">QUANTITY</th>
                                                    <th colspan="4" class="text-center fw-bolder">VALUE</th>
                                                </tr>
                                                <tr>
                                                    <th class="text-nowrap">Date</th>
                                                    <th>Reference</th>
                                                    <th>Station</th>
                                                    <th>Received</th>
                                                    <th>Issued</th>
                                                    <th>Balance</th>
                                                    <th>Basic Price</th>
                                                    <th>Current(IN)</th>
                                                    <th>Current(OUT)</th>
                                                    <th>Current Balance</th>
                                                </tr>
                                            </thead>
                                                @if(!empty($items))
                                                    @foreach ($items as $key => $item)
                                                    <tr>
                                                        <td>{{ $item->date }}</td>
                                                        <td>{{ $item->reference }}</td>
                                                        <td>{{ $item->stationID->name }}</td>
                                                        <td>{{ number_format(round($item->qty_in, 2)) ?? '-' }}</td>
                                                        <td>{{ number_format(round($item->qty_out, 2)) ?? '-' }}</td>
                                                        <td>{{ number_format(round($item->qty_balance, 2)) ?? '-' }}</td>
                                                        <td>{{ number_format(round($item->basic_price, 2)) ?? '-' }}</td>
                                                        <td>{{ number_format(round($item->value_in, 2)) ?? '-' }}</td>
                                                        <td>{{ number_format(round($item->value_out, 2)) ?? '-' }}</td>
                                                        <td>{{ number_format(round($item->value_balance, 2)) ?? '-' }}</td>
                                                    </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="5" class="text-center">No Record Available</td>
                                                    </tr>
                                                @endif
                                        </table>
                                    </div>

                                     <!-- Summary -->
                                    <div class="row py-sm-1 mt-3">
                                        <div class="col-md-4">
                                            <p class="mb-0 fw-semibold">Cumulative Received</p><hr>
                                            <span class="d-block">Quantity: {{number_format($qty_in)}}</span>
                                            <span class="d-block">Value: &#8358; {{ number_format(round($value_in, 2)) }}</span>
                                        </div>
                                        <div class="col-md-4">
                                            <p class="mb-0 fw-semibold">Cumulative Issued</p><hr>
                                            <span class="d-block">Quantity: {{number_format($qty_out)}}</span>
                                            <span class="d-block">Value: &#8358; {{ number_format(round($value_out, 2)) }}</span>
                                        </div>

                                        <div class="col-md-4"> 
                                            <p class="mb-0 fw-semibold">Cumulative Balance</p><hr>
                                            <span class="d-block">Quantity: {{number_format($qty_in - $qty_out)}}</span>
                                            <span class="d-block">Value: &#8358; {{ number_format(round($value_in, 2)) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!--Print-->
                    <div class="card-footer col-2 align-items-right mb-2"> 
                        <button class="btn btn-label-primary align-items-right d-grid w-100" onclick="window.print()">
                            <span class="d-flex align-items-center justify-content-center text-nowrap">
                            <i class="bx bx-file bx-xs me-1"></i>Print</span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- /Bin Card / Item Details-->

             <!-- Print Actions -->
             <div class="col-lg-2 col-12 invoice-actions">
                
            </div>
            <!-- /Print Actions --> 
        </div>     
    </div>
</div>
