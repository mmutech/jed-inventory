<div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h3>Stock Category</h3>

                    <!-- Search Field -->
                    <input
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Search Name or Status..."
                        class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-primary"
                    />

                    <!-- Add Stock Category -->
                    @if($isEditing)
                        <a href=""><i class="fa fa-plus"></i> Stock Category</a>
                    @endif
                </div>
                <div class="card-body">
                    <!-- category Table -->
                    <div class="table-responsive text-nowrap">
                        <table class="table text-wrap">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Class</th>
                                    <th>Status</th>
                                    @can('edit-category')
                                    <th>Actions</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $key => $category)
                                <tr>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->stockClassID->name ?? 'N/A' }}</td>
                                    <td>{{$category->status}}</td>
                                    @can('edit-category')
                                    <td class="d-flex justify-content-between">
                                        <a type="button" wire:click="edit({{ $category->id }})"><i class="fa fa-pencil text-info"></i></a>
                                    </td>
                                    @endcan
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $categories->links('pagination::bootstrap-5') }}
                    </div>
                    <!--/ category Table -->
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3>{{ $isEditing ? 'Edit Stock Category' : 'Add Stock Category' }}</h3>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="{{ $isEditing ? 'update' : 'store' }}">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" wire:model="name" class="form-control" placeholder="Cable & conductor">
                                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="class">Stock class</label>
                                    <select wire:model="stock_class_id" class="form-control">
                                        <option>Select ...</option>
                                        @foreach($classes as $class)
                                        <option value="{{$class->id}}">{{$class->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('stock_class_id') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            @if($isEditing)
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select wire:model="status" class="form-control">
                                        <option>Select ...</option>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            @endif
                            <div class="col-md-12">
                                @canany(['edit-category', 'create-category'])
                                <button type="submit" class="btn btn-{{ $isEditing ? 'info' : 'primary' }}">{{ $isEditing ? 'Update' : 'Submit' }}</button>
                                @endcanany
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
