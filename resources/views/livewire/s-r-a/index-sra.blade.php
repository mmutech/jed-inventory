<div>
    <h6 class="py-1 mb-2">
    <span class="text-muted fw-light"><a href="{{url('dashboard');}}">Dashboard</a> /</span> SRA Lists
    </h6>

    <div class="card">
        <div class="card-header mb-3">
            <h6 class="mb-0">SRA Lists</h6>
            <small>Search SRA Code, Invoice or Consignment Note Number Here.</small>
            <!--Search Filter-->
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
                            <th>SRA Code.</th>
                            <th>Consignment Note No.</th>
                            <th>Invoice No.</th>
                            <th>Received Date</th>
                        </tr>
                    </thead>

                    <tbody>
                    @if(!empty($data))
                        @foreach ($data as $key => $sra)
                        <tr>
                            <td><a href="{{ url('show-sra', $sra->purchase_order_id) }}">{{ $sra->sra_code }}</a></td>
                            <td>{{ $sra->consignment_note_no }}</td>
                            <td>{{ $sra->invoice_no }}</td>
                            <td>{{ $sra->received_date }}</td>
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
