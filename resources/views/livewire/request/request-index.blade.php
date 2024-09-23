<div>
    <h6 class="py-1 mb-3">
        <span class="text-muted fw-light"><a href="{{url('dashboard');}}">Dashboard</a> /</span> Request Category
    </h6>

    <div class="row g-4">
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
                            <a href="{{url('srcn-request');}}" class="text-info btn btn-outline-primary"><i class="bx bx-plus"></i> New Request</a>
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
                        <a href="{{url('srin-request');}}" class="text-info btn btn-outline-primary"><i class="bx bx-plus"></i> New Request</a>
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
                            </div>
                        </div>

                        <div class="col-xl-4 col-sm-4 col-md-4 mx-auto"></div>
                        <div class="col-xl-4 col-sm-4 col-md-4 mx-auto"></div>
                    </div>
                    <hr class="my-1">
                </div>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table" id="dataTable">
                            <thead>
                                <tr>
                                    <th>Reference</th>
                                    <th>Item Requested(No)</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($data))
                                    @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $item->reference }}</td>
                                        <td>{{ $item->count }}</td>
                                        <td>
                                            @if($item->status == 'Pending')
                                                <button class="btn btn-label-warning" data-bs-toggle="modal" data-bs-target="#timeline">{{ $item->status }}</button>
                                            @elseif($item->status == 'Recommended')
                                                <button class="btn btn-label-info" data-bs-toggle="modal" data-bs-target="#timeline">{{ $item->status }}</button>
                                            @elseif($item->status == 'Approved')
                                                <button class="btn btn-label-success" data-bs-toggle="modal" data-bs-target="#timeline">{{ $item->status }}</button>
                                            @elseif($item->status == 'Allocated')
                                                <button class="btn btn-label-primary" data-bs-toggle="modal" data-bs-target="#timeline">{{ $item->status }}</button>
                                            @elseif($item->status == 'Issued')
                                                <button class="btn btn-label-info" data-bs-toggle="modal" data-bs-target="#timeline">{{ $item->status }}</button>
                                            @elseif($item->status == 'Received')
                                                <button class="btn btn-label-secondary" data-bs-toggle="modal" data-bs-target="#timeline">{{ $item->status }}</button>
                                            @endif
                                        </td>
                                        <td>
                                                <a href="{{ url('request-view', $item->reference) }}" class="btn btn-outline-info"><i class="bx bx-show"></i></a>
                                            @if(strpos($item->reference, 'SRIN') !== false AND $item->status == 'Received')
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
                            </tbody>
                        </table>  
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="timeline" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-center align-items-center">
                    <h5 class="modal-title">Request Timeline</strong></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> 
                </div><hr>
                <div class="modal-body" id="printSection">
                    <ul class="timeline ms-2">
                        <li class="timeline-item timeline-item-transparent">
                            <span class="timeline-point-wrapper"><span class="timeline-point timeline-point-success"></span></span>
                            <div class="timeline-event">
                                <div class="timeline-header mb-1">
                                    <h6 class="mb-0">Initiated</h6>
                                </div>
                                <span class="mb-0"></span>  
                            </div>
                        </li>
                        <li class="timeline-item timeline-item-transparent">
                            <span class="timeline-point-wrapper"><span class="timeline-point timeline-point-success"></span></span>
                            <div class="timeline-event">
                                <div class="timeline-header mb-1">
                                    <h6 class="mb-0">Line Supervisor</h6>
                                </div>
                                <span class="mb-0">Recommended</span>
                            </div>
                        </li>
                        <li class="timeline-item timeline-item-transparent">
                            <span class="timeline-point-wrapper"><span class="timeline-point timeline-point-secondary"></span></span>
                            <div class="timeline-event">
                                <div class="timeline-header mb-1">
                                    <h6 class="mb-0">Head of Department</h6>
                                </div>
                                <span class="mb-0">Approved and Allocated</span>
                            </div>
                        </li>
                        <li class="timeline-item timeline-item-transparent">
                            <span class="timeline-point-wrapper"><span class="timeline-point timeline-point-secondary"></span></span>
                            <div class="timeline-event">
                                <div class="timeline-header mb-1">
                                    <h6 class="mb-0">Head Account Operation</h6>
                                </div>
                                <span class="mb-0">Approved</span>  
                            </div>
                        </li>

                        <li class="timeline-item timeline-item-transparent">
                            <span class="timeline-point-wrapper"><span class="timeline-point timeline-point-secondary"></span></span>
                            <div class="timeline-event">
                                <div class="timeline-header mb-1">
                                    <h6 class="mb-0">Issuing Store</h6>
                                </div>
                                    <span class="mb-0">Issued and Despatch</span>
                            </div>
                        </li>

                        <li class="timeline-item timeline-item-transparent">
                            <span class="timeline-point-wrapper"><span class="timeline-point timeline-point-secondary"></span></span>
                            <div class="timeline-header mb-1">
                                <h6 class="mb-0">Received</h6>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-bs-dismiss="modal">
                        <i class="bx bx-x bx-xs me-1"></i>Close</button>
                </div>
            </div>
        </div>
    </div>
</div>