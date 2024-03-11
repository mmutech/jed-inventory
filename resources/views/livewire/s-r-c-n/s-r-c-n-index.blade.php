<div>
    <h6 class="py-1 mb-2">
    <span class="text-muted fw-light"><a href="{{url('dashboard');}}">Dashboard</a> /</span> SRCN Lists
    </h6>

    <div class="card mb-4">
        <div class="card-widget-separator-wrapper">
            <div class="card-body card-widget-separator">
            <div class="row gy-4 gy-sm-1">
                <div class="col-sm-6 col-lg-4">
                <div class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-3 pb-sm-0">
                    <div>
                    <h3 class="mb-1">24</h3>
                    <p class="mb-0">SRCN</p>
                    </div>
                    <div class="avatar me-sm-4">
                    <span class="avatar-initial rounded bg-label-secondary">
                        <i class="bx bx-user bx-sm"></i>
                    </span>
                    </div>
                </div>
                <hr class="d-none d-sm-block d-lg-none me-4">
                </div>
                <div class="col-sm-6 col-lg-4">
                <div class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-3 pb-sm-0">
                    <div>
                    <h3 class="mb-1">165</h3>
                    <p class="mb-0">Requisitions</p>
                    </div>
                    <div class="avatar me-lg-4">
                    <span class="avatar-initial rounded bg-label-secondary">
                        <i class="bx bx-file bx-sm"></i>
                    </span>
                    </div>
                </div>
                <hr class="d-none d-sm-block d-lg-none">
                </div>
                <div class="col-sm-6 col-lg-4">
                <div class="d-flex justify-content-between align-items-start border-end pb-3 pb-sm-0 card-widget-3">
                    <div>
                    <h3 class="mb-1">2.46k</h3>
                    <p class="mb-0">Issuing</p>
                    </div>
                    <div class="avatar me-sm-4">
                    <span class="avatar-initial rounded bg-label-secondary">
                        <i class="bx bx-check-double bx-sm"></i>
                    </span>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header mb-3">
            <div class="row">
                <div class="col-xl-12 col-sm-12 col-md-12 mx-auto d-flex justify-content-between align-items-center">
                    {{-- Search --}}
                    <div class="me-3">
                        <h6 class="mb-0">SRCN Lists</h6>
                        <small>Search SRCN Code Here.</small>
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
                    <!-- Create SRCN -->
                    <a class="btn btn-primary" href="{{ url('srcn-create')}}"> Create SRCN</a>
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
                        <th>SRCN Code</th>
                        <th>Requisition Store</th>
                        <th>Date</th>
                        <th></th>
                    </tr>
                    @if(!empty($data))
                        @foreach ($data as $key => $srcn)
                        <tr>
                            <td><a href="{{ url('srcn-show', $srcn->srcn_id) }}">{{ $srcn->srcn_code }}</a></td>
                            <td>{{ $srcn->requisitionStationID->name }}</td>
                            <td>{{ $srcn->requisition_date }}</td>
                            <td><a href="{{ url('srcn-edit', $srcn->srcn_id) }}"><i class="bx bx-pencil text-primary"></i></a></td>
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