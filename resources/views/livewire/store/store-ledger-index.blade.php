<div>
    <h6 class="py-1 mb-2">
    <span class="text-muted fw-light"><a href="{{url('dashboard');}}">Dashboard</a> /</span> Stores Ledger
    </h6>

    <div class="card mb-4">
        <div class="card-widget-separator-wrapper">
            <div class="card-body card-widget-separator">
            <div class="row gy-4 gy-sm-1">
                <div class="col-sm-6 col-lg-4">
                <div class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-3 pb-sm-0">
                    <div>
                    <h3 class="mb-1">&#8358; {{number_format(round($value_in, 2))}}</h3>
                    <p class="mb-0">Cumulative Value In</p>
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
                    <h3 class="mb-1">&#8358; {{number_format(round($value_out, 2))}}</h3>
                    <p class="mb-0">Cumulative Value Out</p>
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
                    <h3 class="mb-1">&#8358; {{number_format(round($value_in - $value_out, 2))}}</h3>
                    <p class="mb-0">Cumulative Balance</p>
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
        <div class="card-header mb-3">
            <div class="d-flex justify-content-between align-items-center row pt-4 gap-6 gap-md-0 g-md-6">
                <div class="col-md-4">
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
                </div>

                <div class="col-md-3">
                    <button class="btn btn-secondary"><i class='bx bx-export'></i> Export</button>
                </div>
            </div>
            <hr class="my-1">
        </div>

        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <tr>
                        <th>Vocab No.</th>
                        <th>Description</th>
                        <th>Value In</th>
                        <th>Value Out</th>
                        <th>Value Balance</th>
                    </tr>
                    @if(!empty($data))
                        @foreach ($data as $key => $ledger)
                        <tr>
                            <td><a href="{{ url('store-ledger-show', $ledger->stock_code_id) }}">{{ $ledger->stock_code }}</a></td>
                            <td>{{ $ledger->stockCodeID->name }}</td>
                            <td>&#8358; {{ number_format($ledger->value_in) }}</td>
                            <td>&#8358; {{ number_format($ledger->value_out) }}</td>
                            <td>&#8358; {{ number_format($ledger->value_in - $ledger->value_out) }}</td>
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