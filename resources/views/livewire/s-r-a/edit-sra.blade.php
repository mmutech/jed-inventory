<div>
    <h6 class="py-1 mb-2">
    <span class="text-muted fw-light"><a href="{{url('sra');}}">SRA</a> /</span> {{$title}}
    </h6>

    <div class="card">
        <div class="card-header">
            <h6 class="mb-0">SRA Details</h6>
            <small>Modify Your SRA Details.</small>
        </div>
        <hr class="my-1">
        <div class="card-body">
            <form wire:submit="update">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <label class="form-label" for="purchase_order_no">Purchase Order No:</label>
                        <input type="text" wire:model="purchase_order_no" class="form-control" disabled>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label" for="invoice_no">Invoice Number</label>
                        <input type="text" wire:model="invoice_no" class="form-control">
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label" for="consignment_note_no">Consignment Note No: </label>
                        <input type="text" wire:model="consignment_note_no" class="form-control">
                    </div>
                
                    <div class="col-12 d-flex justify-content-between">
                        <button type="submit" class="btn btn-info btn-next">
                            <span class="align-middle d-sm-inline-block d-none me-sm-1">Modify</span>
                            <i class="bx bx-pencil bx-sm me-sm-n2"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
