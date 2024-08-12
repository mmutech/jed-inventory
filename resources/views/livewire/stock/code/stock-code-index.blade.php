<div>
    <h6 class="py-1 mb-2">
    <span class="text-muted fw-light"><a href="{{url('dashboard');}}">Dashboard</a> /</span> Stock Code Lists
    </h6>

    <div class="card mb-4">
        <div class="card-widget-separator-wrapper">
            <div class="card-body card-widget-separator">
            <div class="row gy-4 gy-sm-1">
                <div class="col-sm-6 col-lg-4">
                <div class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-3 pb-sm-0">
                    <div>
                    <h3 class="mb-1">24</h3>
                    <p class="mb-0">Total</p>
                    </div>
                    <div class="avatar me-sm-4">
                    <span class="avatar-initial rounded bg-label-info">
                        <i class="bx bx-leaf bx-sm"></i>
                    </span>
                    </div>
                </div>
                <hr class="d-none d-sm-block d-lg-none me-4">
                </div>
                <div class="col-sm-6 col-lg-4">
                <div class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-3 pb-sm-0">
                    <div>
                    <h3 class="mb-1">165</h3>
                    <p class="mb-0">Active</p>
                    </div>
                    <div class="avatar me-lg-4">
                    <span class="avatar-initial rounded bg-label-success">
                        <i class="bx bx-check-double bx-sm"></i>
                    </span>
                    </div>
                </div>
                <hr class="d-none d-sm-block d-lg-none">
                </div>
                <div class="col-sm-6 col-lg-4">
                <div class="d-flex justify-content-between align-items-start border-end pb-3 pb-sm-0 card-widget-3">
                    <div>
                    <h3 class="mb-1">2.46k</h3>
                    <p class="mb-0">Inactive</p>
                    </div>
                    <div class="avatar me-sm-4">
                    <span class="avatar-initial rounded bg-label-danger">
                        <i class="bx bx-x bx-sm"></i>
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
                    @can('create-codes')
                    <a class="btn btn-primary" href="{{ url('stock-code-create')}}"><i class="bx bx-plus"></i>  Create Stock Class</a>
                    @endcan
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
                        <th>Barcode</th>
                        <th>Stock Code(Unit)</th>
                        <th>Description</th>
                        <th>Stock Category</th>
                        <th>Stock Class</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    @if(!empty($data))
                        @foreach ($data as $key => $stockCode)
                        <tr>
                            <td> <a href="#" data-bs-toggle="modal" data-bs-target="#barcode" class="btn btn-label-primary d-grid w-100" wire:click="generateBarcode('{{ $stockCode->stock_code }}')">Generate</a></td>
                            <td>{{ $stockCode->stock_code }}({{ $stockCode->unitID->name ?? '-' }})</td>
                            <td>{{ $stockCode->name }}</td>
                            <td>{{ $stockCode->stockCategoryID->name ?? '-' }}</td>
                            <td>{{ $stockCode->stockClassID->name ?? '' }}</td>
                            <td>
                            @if($stockCode->status == 'Active')
                                <label class="badge bg-label-success">{{ $stockCode->status }}</label>
                            @else
                                <label class="badge bg-label-danger">{{ $stockCode->status }}</label>
                            @endif
                        <td>
                            @can('modify-codes')
                                <a href="{{ url('stock-code-edit', $stockCode->id) }}"><i class="bx bx-pencil text-info"></i></a>
                            @endcan
                        </td>
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

    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="barcode" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-center align-items-center">
                    <h5 class="modal-title">Generated Barcode</strong></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> 
                </div><hr>
                <div class="modal-body d-flex justify-content-center align-items-center" id="printSection">
                    <div class="text-center">
                        <p>{{$stockCodeName}}</p>
                        <h1>{!! $barcodeHtml !!}</h1>
                        <p>Stock Code: {{$stockCodeId}}</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                        <i class="bx bx-x bx-xs me-1"></i>Close</button>
                    <button class="btn btn-label-primary" onclick="printSection()">
                        <i class="bx bx-printer bx-xs me-1"></i>Print</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function printSection() {
        var printContents = document.getElementById('printSection').innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>

@media print {
    body * {
        visibility: hidden;
    }
    #printSection, #printSection * {
        visibility: visible;
    }
    #printSection {
        position: absolute;
        left: 0;
        top: 0;
    }
}

