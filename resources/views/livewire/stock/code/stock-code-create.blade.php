<div>
    <h6 class="py-1 mb-2">
    <span class="text-muted fw-light"><a href="{{url('stock-code-index');}}">Stock Code</a> /</span> {{$title}}
    </h6>

    <div class="card">
        <div class="card-header">
            <h6 class="mb-0">Stock Code</h6>
            <small>Create Stock Code</small>
        </div>
        <hr class="my-1">
        <div class="card-body">
          <!-- Create Stock Code -->
            <form wire:submit="store">
                <div class="row g-3">
                    <div class="col-sm-3">
                        <label class="form-label" for="stock_code">Stock Code:</label>
                        <input type="text" wire:model="stock_code" class="form-control">
                        @error('stock_code') <span class="error">{{ $message }}</span> @enderror 
                    </div>
                    <div class="col-sm-3">
                        <label class="form-label" for="unit">Unit:</label>
                        <select class="form-select" wire:model="unit">
                            <option value="">Select ...</option>
                            @foreach($unitOfMeasure as $unit)
                                <option value="{{$unit->id}}">{{$unit->description}}</option>
                            @endforeach
                        </select>
                        @error('unit') <span class="error">{{ $message }}</span> @enderror 
                    </div>

                    <div class="col-sm-6">
                        <label class="form-label" for="name">Description:</label>
                        <input type="text" wire:model="name" class="form-control">
                        @error('name') <span class="error">{{ $message }}</span> @enderror 
                    </div>

                    <div class="col-sm-6">
                        <label class="form-label" for="selectedStockCategory">Stock Category</label>
                        <select class="form-select mb-4" id="selectedStockCategory" wire:model.live="selectedStockCategory">
                            <option value="">Select ...</option>
                            @foreach($stock_category as $stockCat)
                             <option value="{{$stockCat->id}}">{{$stockCat->name}}</option>
                            @endforeach
                        </select>
                        @error('selectedStockCategory') <span class="error">{{ $message }}</span> @enderror 
                    </div>

                    <div class="col-sm-6">
                        <label class="form-label" for="selectedStockClass">Stock Class</label>
                        @if(!is_null($selectedStockCategory))
                            <select class="form-control" wire:model="selectedStockClass">
                                <option value="">Choose..</option>
                                @foreach($stock_class as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                                <option value="0">N/A</option>
                            </select>
                            @error('selectedStockClass') <span class="error">{{ $message }}</span> @enderror 
                        @elseif(is_null($selectedStockCategory))
                            <input type="text" class="form-control border rounded" placeholder="Select Stock Category" readonly />
                        @endif
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