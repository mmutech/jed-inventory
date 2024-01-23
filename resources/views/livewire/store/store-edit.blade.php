<div>
    <h6 class="py-1 mb-2">
    <span class="text-muted fw-light"><a href="{{url('store-index');}}">Store</a> /</span> {{$title}}
    </h6>

    <div class="card">
        <div class="card-header">
            <h6 class="mb-0">Store</h6>
            <small>Modify Store</small>
        </div>
        <hr class="my-1">
        <div class="card-body">
          <!-- Modify Store -->
            <form wire:submit="update">
                <div class="row g-3">
                    <input type="hidden" wire:model="storeID" class="form-control">
                    <div class="col-sm-6">
                        <label class="form-label" for="name">Store Name:</label>
                        <input type="text" wire:model="name" class="form-control">
                        @error('name') <span class="error">{{ $message }}</span> @enderror 
                    </div>

                    <div class="col-sm-6">
                        <label class="form-label" for="location">Location Name</label>
                        <select class="form-select mb-4" wire:model="location">
                            <option value="">Select ...</option>
                            @foreach($locations as $location)
                             <option value="{{$location->id}}">{{$location->name}}</option>
                            @endforeach
                        </select>
                        @error('location') <span class="error">{{ $message }}</span> @enderror 
                    </div>

                    <div class="col-sm-6">
                        <label class="form-label" for="store_officer">Store Officer</label>
                        <select class="form-select mb-4" wire:model="store_officer">
                            <option value="">Select ...</option>
                            @foreach($users as $user)
                                <option value="{{$user->id}}">{{$user->name}}</option>
                            @endforeach
                        </select>
                        @error('store_officer') <span class="error">{{ $message }}</span> @enderror 
                    </div>

                    <div class="col-sm-6">
                        <label class="form-label" for="status">Store Officer</label>
                        <select class="form-select mb-4" wire:model="status">
                            <option value=""></option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                        @error('status') <span class="error">{{ $message }}</span> @enderror 
                    </div>
                    
                    <div class="col-12 d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary btn-next">
                            <span class="align-middle d-sm-inline-block d-none me-sm-1">Modify</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>