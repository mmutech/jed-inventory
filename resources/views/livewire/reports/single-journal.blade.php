<div>
    <div class="d-flex justify-content-between">
        <h6 class="py-1 mb-2">
            <span class="text-muted fw-light"><a href="{{url('journal-report');}}">Journal</a> /</span> Single Journal
        </h6>

        @if(!$journal->authorized_by)
            <a href="" class="btn btn-outline-primary" wire:click="authorized">Authorize</a>
        @endif
    </div>
`

    <div class="card">
        <div class="card-header text-center">
            <h4 class="text-capitalize mb-0 text-nowrap fw-bolder">
                <img src="{{ asset('assets/img/jed-pics/logo2.png') }}" style="width: 70px" />
                JOS ELECTRICITY DISTRIBUTION PLC.
            </h4>
            <span class="fw-bolder">INVENTORY JOURNAL</span>

            <div class="d-flex justify-content-between mt-3">
                <div><strong>Location: </strong> HQ</div>
                <div>
                    <strong>Date: </strong> {{ \Carbon\Carbon::parse($journal->prepared_date)->format('F, Y') }}
                </div>
            </div>
            <hr>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="fw-bolder">GL CODE</th>
                            <th class="fw-bolder">STORE ACCOUNT</th>
                            <th class="fw-bolder">LEDGER FOLIO</th>
                            <th class="fw-bolder">DEBIT(₦:K)</th>
                            <th class="fw-bolder">CREDIT(₦:K)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $row)
                        <tr>
                            <td>{{ $row->GlCode }}</td>
                            <td>{{ $row->GlName }}</td>
                            <td></td>
                            <td>{{ number_format(round($row->ValueIssue), 2) }}</td>
                            <td>{{ number_format(round($row->ValueReceive), 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Total Value</td>
                            <td>{{ number_format(round($totalValueIssue), 2) }}</td>
                            <td>{{ number_format(round($totalValueReceive), 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="card-footer">
            <div class="d-flex justify-content-between mb-2">
                <div><strong>Prepared By: </strong> {{ $journal->preparedBy->name }}</div>
                <div>
                    <strong>Date: </strong> {{ \Carbon\Carbon::parse($journal->prepared_date)->format('F, Y') }}
                </div>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <div><strong>Authorized By: </strong> {{ $journal->authorizedBy->name ?? 'N/A' }}</div>
                <div>
                    <strong>Date: </strong> {{ \Carbon\Carbon::parse($journal->authorized_date)->format('F, Y') }}
                </div>
            </div>
        </div>
    </div>
</div>
