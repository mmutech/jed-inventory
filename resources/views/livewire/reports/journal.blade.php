<div>
    <h6 class="py-1 mb-2">
        <span class="text-muted fw-light"><a href="{{url('dashboard');}}">Dashboard</a> /</span> Journal
    </h6>
    <div class="col-sm-12 col-md-12 col-lg-12 mb-4 mt-3">
        <form wire:submit.prevent="exportReport">
            <div class="input-group">
                <button class="btn btn-outline-primary">
                    <span class="tf-icons bx bx-calendar"></span>&nbsp; From
                </button>
                <input class="form-control" type="date" wire:model="startDate">
                <button class="btn btn-outline-primary">
                    <span class="tf-icons bx bx-calendar"></span>&nbsp; To
                </button>
                <input class="form-control" type="date" wire:model="endDate">
                <button type="submit" class="btn btn-outline-primary">
                    <span class="tf-icons bx bx-export"></span>&nbsp; Generate
                </button>
            </div>
        </form>
    </div><hr>
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
                    <strong>Date: </strong> APRIL, 2025
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
                            <th class="fw-bolder">STORE ACCOUNTS</th>
                            <th class="fw-bolder">LEDGER FOLIO</th>
                            <th class="fw-bolder">DEBIT(₦:K)</th>
                            <th class="fw-bolder">CREDIT(₦:K)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>Value</td>
                            <td>Value</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="card-footer">
            <div class="d-flex justify-content-between mb-2">
                <div><strong>Prepared By: </strong> HQ</div>
                <div>
                    <strong>Date: </strong> APRIL, 2025
                </div>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <div><strong>Authorized By: </strong> HQ</div>
                <div>
                    <strong>Date: </strong> APRIL, 2025
                </div>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <div><strong>Ledger By: </strong> HQ</div>
                <div>
                    <strong>Date: </strong> APRIL, 2025
                </div>
            </div>
        </div>
    </div>
</div>
