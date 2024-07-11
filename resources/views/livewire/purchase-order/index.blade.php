<div>
    <h6 class="py-1 mb-2">
        <span class="text-muted fw-light"><a href="{{url('/home');}}">Purchase Order</a> /</span> List
    </h6>

    <div class="card mb-4">
        <div class="card-widget-separator-wrapper">
            <div class="card-body card-widget-separator">
            <div class="row gy-4 gy-sm-1">
                <div class="col-sm-6 col-lg-3">
                <div class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-3 pb-sm-0">
                    <div>
                    <h3 class="mb-1">24</h3>
                    <p class="mb-0">Total PO</p>
                    </div>
                    <div class="avatar me-sm-4">
                    <span class="avatar-initial rounded bg-label-secondary">
                        <i class="bx bx-user bx-sm"></i>
                    </span>
                    </div>
                </div>
                <hr class="d-none d-sm-block d-lg-none me-4">
                </div>
                <div class="col-sm-6 col-lg-3">
                <div class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-3 pb-sm-0">
                    <div>
                    <h3 class="mb-1">165</h3>
                    <p class="mb-0">Initiated</p>
                    </div>
                    <div class="avatar me-lg-4">
                    <span class="avatar-initial rounded bg-label-secondary">
                        <i class="bx bx-file bx-sm"></i>
                    </span>
                    </div>
                </div>
                <hr class="d-none d-sm-block d-lg-none">
                </div>
                <div class="col-sm-6 col-lg-3">
                <div class="d-flex justify-content-between align-items-start border-end pb-3 pb-sm-0 card-widget-3">
                    <div>
                    <h3 class="mb-1">$2.46k</h3>
                    <p class="mb-0">Recommended</p>
                    </div>
                    <div class="avatar me-sm-4">
                    <span class="avatar-initial rounded bg-label-secondary">
                        <i class="bx bx-check-double bx-sm"></i>
                    </span>
                    </div>
                </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                    <h3 class="mb-1">$876</h3>
                    <p class="mb-0">Approved</p>
                    </div>
                    <div class="avatar">
                    <span class="avatar-initial rounded bg-label-secondary">
                        <i class="bx bx-error-circle bx-sm"></i>
                    </span>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
    </div>
    <!-- Responsive Table -->
    <div class="card">
        <h5 class="card-header">Purchase Order Lists</h5>
        <div class="card-header">
            <div class="row">
                <div class="col-xl-12 col-sm-12 col-md-12 mx-auto d-flex justify-content-between align-items-center">
                    {{-- Search --}}
                    <div class="me-3">
                        <div id="DataTables_Table_0_filter" class="dataTables_filter mb-3">
                            <label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text" id="basic-addon-search31"><i class="bx bx-search"></i></span>
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Search..."
                                        aria-label="Search..."
                                        aria-describedby="basic-addon-search31"
                                        wire:model.live.debounce.100ms="search" />
                                </div>
                            </label>
                        </div>
                    </div>
                    <!-- Create user -->
                    @can('create-po')
                    <a class="btn btn-primary" href="{{ url('purchase-order-create')}}"> New Purchase Order</a>
                    @endcan
                </div>

                <div class="col-xl-4 col-sm-4 col-md-4 mx-auto"></div>
                <div class="col-xl-4 col-sm-4 col-md-4 mx-auto"></div>
            </div>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                <tr>
                    <th>PURCHASE ORDER NO.</th>
                    <th>Beneficiary</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
                @if(!empty($data))
                    @foreach ($data as $key => $po)
                    <tr>
                        <td><a href="{{ url('purchase-order-show/'.$po->purchase_order_id)}}">{{ $po->purchase_order_no }}</a></td>
                        <td>{{ $po->beneficiary }}</td>
                        <td>
                            @if($po->status == 'Approved')
                                <label class="badge bg-label-success">{{ $po->status }}</label>
                            @elseif($po->status == 'Pending')
                                <label class="badge bg-label-warning">{{ $po->status }}</label>
                            @elseif($po->status == 'Completed')
                                <label class="badge bg-label-primary">{{ $po->status }}</label>
                            @else
                                <label class="badge bg-label-danger">{{ $po->status }}</label>
                            @endif
                        <td>{{ $po->purchase_order_date }}</td>
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
    <!--/ Responsive Table -->
</div>
