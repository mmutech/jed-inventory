<div>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h3>Units</h3>

                    <!-- Search Field -->
                    <input
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Search Name or Status..."
                        class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-primary"
                    />

                    <!-- Add Unit -->
                    @if($isEditing)
                        <a href=""><i class="fa fa-plus"></i> Unit</a>
                    @endif
                </div>
                <div class="card-body">
                    <!-- unit Table -->
                    <div class="table-responsive text-nowrap">
                        <table class="table text-wrap">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Status</th>
                                    @can('edit-class')
                                    <th>Actions</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($units as $key => $unit)
                                <tr>
                                    <td>{{ $unit->description }}</td>
                                    <td>{{ $unit->status }}</td>
                                    @can('edit-unit')
                                    <td class="d-flex justify-content-between">
                                        <a type="button" wire:click="edit({{ $unit->id }})"><i class="fa fa-pencil text-info"></i></a>
                                    </td>
                                    @endcan
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $units->links('pagination::bootstrap-5') }}
                    </div>
                    <!--/ class Table -->
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3>{{ $isEditing ? 'Edit Unit' : 'Add Unit' }}</h3>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="{{ $isEditing ? 'update' : 'store' }}">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="description">Name</label>
                                    <input type="text" wire:model="description" class="form-control" placeholder="Cable & conductor">
                                    @error('description') <span class="text-danger">{{ $message }}</span> @enderror
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
                                @canany(['edit-unit', 'create-unit'])
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
