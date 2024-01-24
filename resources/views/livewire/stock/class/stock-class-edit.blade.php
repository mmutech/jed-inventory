<div>
    <h6 class="py-1 mb-2">
    <span class="text-muted fw-light"><a href="{{url('stock-class-index');}}">Stock Class</a> /</span> {{$title}}
    </h6>

    <div class="card">
        <div class="card-header">
            <h6 class="mb-0">Stock Class</h6>
            <small>Modify Stock Class</small>
        </div>
        <hr class="my-1">
        <div class="card-body">
          <!-- Modify Stock Class -->
            <form wire:submit="update">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <label class="form-label" for="name">Stock Class:</label>
                        <input type="text" wire:model="name" class="form-control">
                        @error('name') <span class="error">{{ $message }}</span> @enderror 
                    </div>

                    <div class="col-sm-6">
                        <label class="form-label" for="stock_category_id">Stock Category</label>
                        <select class="form-select mb-4" wire:model="stock_category_id">
                            <option value="">Select ...</option>
                            @foreach($stock_category as $stocCat)
                             <option value="{{$stocCat->id}}">{{$stocCat->name}}</option>
                            @endforeach
                        </select>
                        @error('stock_category_id') <span class="error">{{ $message }}</span> @enderror 
                    </div>

                    <div class="col-sm-6">
                        <label class="form-label" for="status">Status</label>
                        <select class="form-select mb-4" wire:model="status">
                            <option value=""></option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                        @error('status') <span class="error">{{ $message }}</span> @enderror 
                    </div>
                    
                    <div class="col-12 d-flex justify-content-between">
                        <button type="submit" class="btn btn-info btn-next">
                            <span class="align-middle d-sm-inline-block d-none me-sm-1">Modify</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>