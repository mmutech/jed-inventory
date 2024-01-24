<div>
    <h6 class="py-1 mb-2">
    <span class="text-muted fw-light"><a href="{{url('stock-category-index');}}">Stock Category</a> /</span> {{$title}}
    </h6>

    <div class="card">
        <div class="card-header">
            <h6 class="mb-0">Stock Category</h6>
            <small>Create Stock Category</small>
        </div>
        <hr class="my-1">
        <div class="card-body">
          <!-- Create Stock Category -->
            <form wire:submit="store">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <label class="form-label" for="name">Stock Category:</label>
                        <input type="text" wire:model="name" class="form-control">
                        @error('name') <span class="error">{{ $message }}</span> @enderror 
                    </div>
                    
                    <div class="col-12 d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary btn-next">
                            <span class="align-middle d-sm-inline-block d-none me-sm-1">Save</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
