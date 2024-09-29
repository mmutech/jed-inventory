<div>
    <div class="col-xl-12 col-sm-12 col-md-10 mx-auto">
        <h4 class="py-3 mb-2">General Report</h4>
        <!-- General Store Report -->
        <div class="card">
            <div class="card-datatable table-responsive">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <div class="row mx-1 p-3">    
                        {{-- Export --}}
                        <div class="col-sm-12 col-md-12 col-lg-12 mb-4 mt-3">
                            <form wire:submit.prevent="exportReport">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                        <div class="row g-2">
                                            <div class="col-3">
                                                <label for="startDateWithTitle" class="form-label">From</label>
                                            </div>
                                            <div class="col-9">
                                                <div class="input-group input-group-merge">
                                                    <span class="input-group-text"><i class="menu-icon tf-icons bx bx-calendar"></i></span>
                                                    <input class="form-control" type="date" wire:model="startDate">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                        <div class="row g-2">
                                            <div class="col-3">
                                                <label for="endDateWithTitle" class="form-label">To</label>
                                            </div>
                                            <div class="col-9">
                                                <div class="input-group input-group-merge">
                                                    <span class="input-group-text"><i class="menu-icon tf-icons bx bx-calendar"></i></span>
                                                    <input class="form-control" type="date" wire:model="endDate">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-2 col-lg-2">
                                        <div class="row g-2">
                                            <div class="col">
                                                <button type="submit" class="btn btn-outline-primary">
                                                    <span class="tf-icons bx bx-export"></span>&nbsp; Export
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div><hr>

                        {{-- List of Headings --}}
                        <div class="col-sm-12 col-md-12 col-lg-12 mt-3">
                            <h5 class="card-title">This provides a report of the selected options with the following parameters:</h5>
                            <ul class="text-primary">
                                <li>Date(Issue/Receive)</li>
                                <li>Purchase Order Number</li>
                                <li>Reference</li>
                                <li>Store</li>
                                <li>Stock Code</li>
                                <li>Description</li>
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
