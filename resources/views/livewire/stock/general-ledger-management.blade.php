<div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h3>General Ledger</h3>

                    <!-- Search Field -->
                    <input
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Search Name, Code, or Category..."
                        class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-primary"
                    />
                    <!-- Add General Ledger -->
                     @if($isEditing)
                    <a href=""><i class="fa fa-plus"></i> General Ledger</a>
                    @endif
                </div>
                <div class="card-body">
                    <!-- ledger Table -->
                    <div class="table-responsive text-nowrap">
                        <table class="table text-wrap">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ledgers as $key => $ledger)
                                <tr>
                                    <td>{{$ledger->code}}</td>
                                    <td>{{ \Illuminate\Support\Str::limit($ledger->name, 10) }}</td>
                                    <td>{{$ledger->category}}</td>
                                    <td class="d-flex justify-content-between">
                                        @can('edit-ledger')
                                        <a type="button" wire:click="edit({{ $ledger->id }})"><i class="fa fa-pencil text-info"></i></a>
                                        @endcan
                                        <a href="" data-bs-toggle="modal" data-bs-target="#ledgerModal{{ $key }}"><i class="fa fa-list text-primary"></i></a>
                                    </td>
                                </tr>

                                <!-- Modal -->
                                <div class="modal fade" id="ledgerModal{{ $key }}" tabindex="-1" aria-labelledby="ledgerModalLabel{{ $key }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-top">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="ledgerModalLabel{{ $key }}">General Ledger</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-8 mb-3">
                                                        <ul>
                                                            <li><Strong>Code:</Strong> <span>{{$ledger->code}}</span></li>
                                                            <li><Strong>Name:</Strong> <span>{{$ledger->name}}</span></li>
                                                            <li><Strong>Category:</Strong> <span>{{$ledger->category}}</span></li>
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
                        {{ $ledgers->links('pagination::bootstrap-5') }}
                    </div>
                    <!--/ ledger Table -->
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3>{{ $isEditing ? 'Edit General Ledger' : 'Add General Ledger' }}</h3>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="{{ $isEditing ? 'update' : 'store' }}">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" wire:model="name" class="form-control" placeholder="ACCOUNTING SERVICES">
                                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="code">Code</label>
                                    <input type="text" wire:model="code" class="form-control" placeholder="8300006">
                                    @error('code') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="category">Category</label>
                                    <select wire:model="category" class="form-control">
                                        <option>Select ...</option>
                                        <option value="B">B</option>
                                        <option value="P">P</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                @canany(['edit-ledger', 'create-ledger'])
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
