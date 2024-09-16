<div>
    <h6 class="py-1 mb-3">
        <span class="text-muted fw-light"><a href="{{url('dashboard');}}">Dashboard</a> /</span> Request Category
    </h6>

    <div class="row g-4">
        <!-- New Request -->
        <div class="col">
            <div class="card border border-info h-100">
                <div class="row h-100">
                    <div class="col-sm-5">
                        <div class="d-flex align-items-end h-100 justify-content-center mt-sm-0 mt-3">
                            <img src="{{asset('assets/img/illustrations/man-with-laptop-light.png')}}" class="img-fluid" alt="Image" width="120" >
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <div class="card-body text-sm-end text-center ps-sm-0">
                            <a href="{{url('request-item');}}" class="btn btn-primary mb-3 text-nowrap add-new-request">New Request</a>
                            <p class="mb-0">...if it does not exist</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SRCN -->
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <h6 class="fw-normal">Total <b>{{ number_format($srcnCount) }}</b> Request</h6>
                        <i class="bx bx-check-shield text-primary"></i>
                    </div>
                    <div class="d-flex justify-content-between align-items-end">
                        <div class="role-heading">
                            <h4 class="mb-1">SRCN</h4>
                            <a href="javascript:;" wire:click="srcnId" class="role-edit-modal"><small>Available SRCN</small></a>
                        </div>
                            <a href="javascript:void(0);" class="text-muted"> <b>10</b> Approved</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- SRIN -->
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <h6 class="fw-normal">Total <b>{{ number_format($srinCount) }}</b> Request</h6>
                        <i class="bx bx-check-shield text-primary"></i>
                    </div>
                    <div class="d-flex justify-content-between align-items-end">
                        <div class="role-heading">
                            <h4 class="mb-1">SRIN</h4>
                            <a href="javascript:;" wire:click="srinId" class="role-edit-modal"><small>Available SRIN</small></a>
                        </div>
                            <a href="javascript:void(0);" class="text-muted"> <b>10</b> Approved</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Request List -->
    @if($data)
    <div class="row mt-5">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header mb-3">
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
                        </div>

                        <div class="col-xl-4 col-sm-4 col-md-4 mx-auto"></div>
                        <div class="col-xl-4 col-sm-4 col-md-4 mx-auto"></div>
                    </div>
                    <hr class="my-1">
                </div>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <tr>
                                <th>Reference</th>
                                <th>Item Requested(No)</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            @if(!empty($data))
                                @foreach ($data as $item)
                                <tr>
                                    <td>{{ $item->reference }}</td>
                                    <td>{{ $item->count }}</td>
                                    <td>
                                        @if($item->status == 'Pending')
                                            <button class="btn btn-label-warning" data-bs-toggle="offcanvas" data-bs-target="#timeline">{{ $item->status }}</button>
                                        @elseif($item->status == 'Recommended')
                                            <button class="btn btn-label-info" data-bs-toggle="offcanvas" data-bs-target="#timeline">{{ $item->status }}</button>
                                        @elseif($item->status == 'Approved')
                                            <button class="btn btn-label-success" data-bs-toggle="offcanvas" data-bs-target="#timeline">{{ $item->status }}</button>
                                        @elseif($item->status == 'Allocated')
                                            <button class="btn btn-label-primary" data-bs-toggle="offcanvas" data-bs-target="#timeline">{{ $item->status }}</button>
                                        @elseif($item->status == 'Issued')
                                            <button class="btn btn-label-info" data-bs-toggle="offcanvas" data-bs-target="#timeline">{{ $item->status }}</button>
                                        @elseif($item->status == 'Received')
                                            <button class="btn btn-label-secondary" data-bs-toggle="offcanvas" data-bs-target="#timeline">{{ $item->status }}</button>
                                        @endif
                                    </td>
                                    <td>
                                            <a href="{{ url('request-view', $item->reference) }}" class="btn btn-outline-info"><i class="bx bx-show"></i></a>
                                        @if(strpos($item->reference, 'SRIN') !== false)
                                            <a href="{{ url('request-scn', $item->reference) }}" class="btn btn-outline-warning m-2">SCN</a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3" class="text-center">No Record Available</td>
                                </tr>
                            @endif
                        </table>  
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
