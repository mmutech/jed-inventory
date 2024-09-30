<div>
    <h6 class="py-1 mb-2">
    <span class="text-muted fw-light"><a href="{{url('dashboard');}}">Dashboard</a> /</span> Stores Bin Card
    </h6>

    <div class="card mb-4">
        <div class="card-widget-separator-wrapper">
            <div class="card-body card-widget-separator">
            <div class="row gy-4 gy-sm-1">
                <div class="col-sm-6 col-lg-4">
                <div class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-3 pb-sm-0">
                    <div>
                        <p class="mb-0 fw-semibold">Cumulative Received</p><hr>
                        <span class="d-block">Quantity: {{number_format($qty_in)}}</span>
                        <span class="d-block">Value: &#8358; {{ number_format(round($value_in, 2)) }}</span>
                    </div>
                    <div class="avatar me-sm-4">
                    <span class="avatar-initial rounded bg-label-success">
                        <i class="bx bx-plus bx-sm"></i>
                    </span>
                    </div>
                </div>
                <hr class="d-none d-sm-block d-lg-none me-4">
                </div>
                <div class="col-sm-6 col-lg-4">
                <div class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-3 pb-sm-0">
                    <div>
                        <p class="mb-0 fw-semibold">Cumulative Issued</p><hr>
                        <span class="d-block">Quantity: {{number_format($qty_out)}}</span>
                        <span class="d-block">Value: &#8358; {{ number_format(round($value_out, 2)) }}</span>
                    </div>
                    <div class="avatar me-lg-4">
                    <span class="avatar-initial rounded bg-label-danger">
                        <i class="bx bx-minus bx-sm"></i>
                    </span>
                    </div>
                </div>
                <hr class="d-none d-sm-block d-lg-none">
                </div>
                <div class="col-sm-6 col-lg-4">
                <div class="d-flex justify-content-between align-items-start border-end pb-3 pb-sm-0 card-widget-3">
                    <div>
                        <p class="mb-0 fw-semibold">Cumulative Balance</p><hr>
                        <span class="d-block">Quantity: {{number_format($qty_in - $qty_out)}}</span>
                        <span class="d-block">Value: &#8358; {{ number_format(round($value_in - $value_out, 2)) }}</span>
                    </div>
                    <div class="avatar me-sm-4">
                    <span class="avatar-initial rounded bg-label-info">
                        <i class="bx bx-leaf bx-sm"></i>
                    </span>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table" id="dataTable">
                <thead>
                    <tr>
                        <th>Description (Vocab No.)</th>
                        <th>Received</th>
                        <th>Issued</th>
                        <th>Balance</th>
                        <th>Ledger</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($data))
                        @foreach ($data as $key => $bin)
                        <tr>
                            <td><a href="{{ url('bin-card-show', $bin->stock_code_id) }}">
                                <span class="fw-semibold d-block">{{ $bin->stockCodeID->stock_code }}</span>
                                <small class="">{{ $bin->stockCodeID->name }}</small></a>
                            </td>
                            <td>{{ number_format($bin->qty_in) }}</td>
                            <td>{{ number_format($bin->qty_out) }}</td>
                            <td>{{ number_format($bin->qty_in - $bin->qty_out) }}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle text-primary" data-bs-toggle="dropdown">
                                        <i class="bx bx-money"></i>
                                    </button>
                                    <div class="dropdown-menu p-4">
                                        <span class="fw-semibold d-block">Value In:</span>
                                        <small>&#8358; {{ number_format($bin->value_in) }}</small><hr>
                                        <span class="fw-semibold d-block">Value Out: </span>
                                        <small>&#8358; {{ number_format($bin->value_out) }}</small><hr>
                                        <span class="fw-semibold d-block">Balance: </span>
                                        <small>&#8358; {{ number_format($bin->value_in - $bin->value_out) }}</small>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="text-center">No Record Available</td>
                        </tr>
                    @endif
                </tbody>
                </table>  
            </div>
        </div>
    </div>
</div>