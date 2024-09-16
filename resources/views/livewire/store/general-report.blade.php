<div>
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Report</h5>
            <div class="d-flex justify-content-between align-items-center row pt-4 gap-6 gap-md-0 g-md-6">
                <div class="col-md-3">
                    <select class="form-select text-capitalize">
                        <option value="">Select Stock Code ...</option>
                        <option value="">-- All --</option>
                        <option value="Scheduled">Scheduled</option>
                        <option value="Publish">Publish</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <select class="form-select text-capitalize">
                        <option value="">Select Store ...</option>
                        <option value="">-- All --</option>
                        <option value="Scheduled">Scheduled</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <select class="form-select text-capitalize">
                        <option value="">Select Category ...</option>
                        <option value="">-- All --</option>
                        <option value="SRA">SRA</option>
                        <option value="SRCN">SRCN</option>
                        <option value="SRIN">SRIN</option>
                        <option value="SCN">SCN</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <button class="btn btn-outline-primary"><i class='bx bx-export'></i> Export</button>
                </div>
            </div>
        </div><hr>
        <div class="card-body">
            <h5 class="card-title">This provides a report of the selected options with the following parameters:</h5>
            <ul class="text-primary">
                <li>Date(Issue/Received)</li>
                <li>Purchase Order Number</li>
                <li>Reference</li>
                <li>Store</li>
                <li>Stock Code</li>
                <li>Quantity (In)</li>
                <li>Quantity (Out)</li>
                <li>Basic Price(N)</li>
            </ul>
        </div>
    </div>
</div>
