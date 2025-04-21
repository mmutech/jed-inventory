<div>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h3>Stores</h3>

                    <!-- Search Field -->
                    <input
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Search Name or Status..."
                        class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-primary"
                    />

                    <!-- Add Store -->
                    @if($isEditing)
                        <a href=""><i class="fa fa-plus"></i> Store</a>
                    @endif
                </div>
                <div class="card-body">
                    <!-- Store Table -->
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
                                @foreach($stores as $key => $store)
                                <tr>
                                    <td>{{ $store->name }}</td>
                                    <td>{{$store->status}}</td>
                                    <td class="d-flex justify-content-between">
                                        @can('edit-store')
                                        <a type="button" wire:click="edit({{ $store->id }})"><i class="fa fa-pencil text-info"></i></a>
                                        @endcan
                                        <a href="" data-bs-toggle="modal" data-bs-target="#storeModal{{ $key }}"><i class="fa fa-list text-primary"></i></a>
                                    </td>
                                </tr>

                                <!-- Modal -->
                                <div class="modal fade" id="storeModal{{ $key }}" tabindex="-1" aria-labelledby="storeModalLabel{{ $key }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-top">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="storeModalLabel{{ $key }}">Store Details</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-8 mb-3">
                                                        <ul>
                                                            <li><Strong>Status:</Strong> <span>{{$store->status}}</span></li>
                                                            <li><Strong>Name:</Strong> <span>{{$store->name}}</span></li>
                                                            <li><Strong>Location:</Strong> <span>{{$store->locationID->name}}</span></li>
                                                            <li><Strong>Officer:</Strong> <span>{{ $store->storeOfficerID->name }} ({{$store->storeOfficerID->staff_id}})</span></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $stores->links('pagination::bootstrap-5') }}
                    </div>
                    <!--/ class Table -->
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3>{{ $isEditing ? 'Edit Store' : 'Add Store' }}</h3>
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
                                    <label for="location">Location</label>
                                    <select wire:model="location" class="form-control">
                                        <option>Select ...</option>
                                        @foreach($locations as $location)
                                        <option value="{{$location->id}}">{{$location->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('location') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="store_officer">Store Officer</label>
                                    <select wire:model="store_officer" class="form-control">
                                        <option>Select ...</option>
                                        @foreach($officers as $officer)
                                        <option value="{{$officer->id}}">{{$officer->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('store_officer') <span class="text-danger">{{ $message }}</span> @enderror
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
                                @canany(['edit-store', 'create-store'])
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
