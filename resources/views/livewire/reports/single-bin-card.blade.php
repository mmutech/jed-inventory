<div>
    <h6 class="py-1 mb-2">
        <span class="text-muted fw-light"><a href="{{url('dashboard');}}">Bin Card</a> /</span> Single Bin Card
    </h6>
    <div class="card">
        <div class="card-header text-center">
            <h4 class="text-capitalize mb-0 text-nowrap fw-bolder">
                <img src="{{ asset('assets/img/jed-pics/logo2.png') }}" style="width: 70px" />
                JOS ELECTRICITY DISTRIBUTION PLC.
            </h4>
            <span class="fw-bolder">STORE BIN CARD</span>

            <div class="d-flex justify-content-between mt-3">
                <div>
                    <strong>Maximum: </strong> {{ number_format($max) }} <hr class="m-0 p-0">
                    <strong>Minimum: </strong> {{ number_format($min) }} <hr class="m-0 p-0">
                    @if($min <= 10)
                        <strong><label class="badge bg-label-danger mt-2 p-3">Reorder Now!</label></strong>
                    @endif
                </div>
                <div>
                    <strong>Stock Code: </strong> {{ $stock->stock_code }} <hr class="m-0 p-0">
                    <strong>Unit: </strong> {{ $stock->unitID->description }} <hr class="m-0 p-0">
                </div>
            </div>
            <div class="text-start mt-3">
                <strong>Description: </strong>{{ $stock->name }}
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="fw-bolder">DATE(Receive/Issue)</th>
                            <th class="fw-bolder">REFERENCE</th>
                            <th class="fw-bolder">STATION</th>
                            <th class="fw-bolder">IN</th>
                            <th class="fw-bolder">OUT</th>
                            <th class="fw-bolder">BALANCE</th>
                            <th class="fw-bolder">INITIAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stockMovements as $stock)
                        <tr>
                            <td>{{ $stock->date }}</td>
                            <td>{{ $stock->reference }}</td>
                            <td>{{ $stock->stationID->name }}</td>
                            <td>{{ number_format($stock->qty_in) }}</td>
                            <td>{{ number_format($stock->qty_out) }}</td>
                            <td>{{ number_format($stock->qty_in - $stock->qty_out) }}</td>
                            <td>{{ $stock->createdBy->name }} <strong>({{ $stock->createdBy->staff_id }})</strong></td>
                        </tr>
                        @endforeach
                    </tbody>
                    <!-- <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tfoot> -->
                </table>
            </div>
        </div>
    </div>
</div>
