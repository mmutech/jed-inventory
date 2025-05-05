<div>
    <h6 class="py-1 mb-2">
        <span class="text-muted fw-light"><a href="{{url('dashboard');}}">Dashboard</a> /</span> General Report
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
    <div class="col-xl-12 col-sm-12 col-md-10 mx-auto">
        <!-- General Store Report -->
        <div class="card">
            <div class="card-datatable table-responsive">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <div class="row mx-1 p-3">
                        {{-- List of Headings --}}
                        <div class="col-sm-12 col-md-12 col-lg-12 mt-3">
                            <h5 class="card-title">This provides a report of the selected options with the following parameters:</h5>
                            <ul class="text-primary">
                                <li>Date(Issue/Receive)</li>
                                <li>Purchase Order Number</li>
                                <li>Reference</li>
                                <li>Store</li>
                                <li>Stock Code</li>
                                <li>Stock Class</li>
                                <li>Stock Category</li>
                                <li>Ledger Code</li>
                                <li>Quantity Receive</li>
                                <li>Quantity Issue</li>
                                <li>Quantity Balance</li>
                                <li>Basic Price(N)</li>
                                <li>Value Receive</li>
                                <li>Value Issue</li>
                                <li>Value Balance</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Schedule Table -->
    </div>
</div>
