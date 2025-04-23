<div>
    <h6 class="py-1 mb-2">
        <span class="text-muted fw-light"><a href="{{url('dashboard');}}">Dashboard</a> /</span> Quality Check
    </h6>

    <div class="card">
        <div class="card-header mb-3">
            <h6 class="mb-0">Quality Check</h6>
            <small>Search Purchase Order Number Here.</small>
            <div class="col-xl-4 col-sm-4 col-md-4 justify-content-between">
                <div class="me-3"></div>
            </div>
            <hr class="my-1">
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table" id="dataTable">
                    <thead>
                        <tr>
                            <th>PURCHASE ORDER NO.</th>
                            <th>Beneficiary</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>

                    <tbody>
                    @if(!empty($data))
                        @foreach ($data as $key => $po)
                        <tr>
                            <td><a href="{{ url('quality-check-single', $po->purchase_order_id) }}">{{ $po->purchase_order_no }}</a></td>
                            <td>{{ $po->beneficiary }}</td>
                            <td>
                                @if($po->status == 'Approved')
                                    <label class="badge bg-label-success">{{ $po->status }}</label>
                                @elseif($po->status == 'Pending')
                                    <label class="badge bg-label-warning">{{ $po->status }}</label>
                                @else
                                    <label class="badge bg-label-info">{{ $po->status }}</label>
                                @endif
                            <td>{{ $po->purchase_order_date }}</td>
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
