<div>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h3>Stock Codes</h3>

                    <!-- Search Field -->
                    <input
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Search Name or Status..."
                        class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-primary"
                    />

                    <!-- Add Stock Code -->
                    @if($isEditing)
                        <a href=""><i class="fa fa-plus"></i> Stock Code</a>
                    @endif
                </div>
                <div class="card-body">
                    <!-- class Table -->
                    <div class="table-responsive text-nowrap">
                        <table class="table text-wrap">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($codes as $key => $code)
                                <tr>
                                    <td>{{ $code->stock_code }}</td>
                                    <td>{{ \Illuminate\Support\Str::limit($code->name, 10) }}</td>
                                    <td>{{  $code->status   }}</td>
                                    <td class="d-flex justify-content-between">
                                        @can('edit-codes')
                                        <a type="button" wire:click="edit({{ $code->id }})"><i class="fa fa-pencil text-info"></i></a>
                                        @endcan
                                        <a href="" data-bs-toggle="modal" data-bs-target="#codeModal{{ $key }}"><i class="fa fa-list text-primary"></i></a>
                                    </td>
                                </tr>

                                <!-- Modal -->
                                <div class="modal fade" id="codeModal{{ $key }}" tabindex="-1" aria-labelledby="codeModalLabel{{ $key }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-top">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="codeModalLabel{{ $key }}">Stock Code Details</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-8 mb-3">
                                                        <ul>
                                                            <li><Strong>Status:</Strong> <span>{{$code->status}}</span></li>
                                                            <li><Strong>Code:</Strong> <span>{{$code->stock_code}}</span></li>
                                                            <li><Strong>Name:</Strong> <span>{{$code->name}}</span></li>
                                                            <li><Strong>Unit:</Strong> <span>{{$code->unitID->description ?? 'N/A'}}</span></li>
                                                            <li><Strong>Ledger Code:</Strong> <span>{{$code->gLedgerID->code ?? 'N/A'}} - {{$code->gLedgerID->name ?? 'N/A'}}</span></li>
                                                            <li><Strong>Class:</Strong> <span>{{$code->stockClassID->name}}</span></li>
                                                            <li><Strong>Category:</Strong> <span>{{$code->stockCategoryID->name}}</span></li>
                                                        </ul>

                                                        <!-- Barcode -->
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#barcode" class="btn btn-label-primary d-grid w-100" wire:click="generateBarcode('{{ $code->stock_code }}')">Generate</a>
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
                        {{ $codes->links('pagination::bootstrap-5') }}
                    </div>
                    <!--/ class Table -->
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3>{{ $isEditing ? 'Edit Stock Code' : 'Add Stock Code' }}</h3>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="{{ $isEditing ? 'update' : 'store' }}">
                        <div class="row">
                            @if(!$isEditing)
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="stock_code">Code</label>
                                    <input type="text" wire:model="stock_code" class="form-control" placeholder="000-1234">
                                    @error('stock_code') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            @endif
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" wire:model="name" class="form-control" placeholder="Cable & conductor">
                                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="unit">Unit</label>
                                    <select wire:model="unit" class="form-control">
                                        <option>Select ...</option>
                                        @foreach($units as $unit)
                                        <option value="{{$unit->id}}">{{$unit->description}}</option>
                                        @endforeach
                                    </select>
                                    @error('unit') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="class">Stock Class</label>
                                    <select id="selectedStockClass" wire:model.live="selectedStockClass" class="form-control">
                                        <option>Select ...</option>
                                        @foreach($stock_class as $class)
                                        <option value="{{$class->id}}">{{$class->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('selectedStockClass') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="category">Stock Category</label>
                                    @if(!is_null($selectedStockClass))
                                        <select class="form-control" wire:model="selectedStockCategory">
                                            <option value="">Choose..</option>
                                            @foreach($stock_category as $item)
                                                <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                            <option value="0">N/A</option>
                                        </select>
                                        @error('selectedStockCategory') <span class="error">{{ $message }}</span> @enderror
                                    @elseif(is_null($selectedStockClass))
                                        <input type="text" class="form-control border rounded" placeholder="Select Stock Class" readonly />
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="gl_code_id">Ledger Code</label>
                                    <select wire:model="gl_code_id" class="form-control">
                                        <option>Select ...</option>
                                        @foreach($ledgerCodes as $ledger)
                                        <option value="{{$ledger->id}}">{{$ledger->code}} - {{$ledger->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('gl_code_id') <span class="text-danger">{{ $message }}</span> @enderror
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
                                @canany(['edit-codes', 'create-codes'])
                                <button type="submit" class="btn btn-{{ $isEditing ? 'info' : 'primary' }}">{{ $isEditing ? 'Update' : 'Submit' }}</button>
                                @endcanany
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Barcode Modal -->
    <div wire:ignore.self class="modal fade" id="barcode" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-center align-items-center">
                    <h5 class="modal-title">Generated Barcode</strong></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div><hr>
                <div class="modal-body d-flex justify-content-center align-items-center" id="printSection">
                    <div class="text-center">
                        <p>{{$stockCodeName}}</p>
                        <h1>{!! DNS1D::getBarcodeSVG($stockCodeId, "C39", 2, 55, '#2A3239') !!}</h1>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                        <i class="bx bx-x bx-xs me-1"></i>Close</button>
                    <button class="btn btn-label-primary" onclick="printSection()">
                        <i class="bx bx-printer bx-xs me-1"></i>Print</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Barcode script -->
<script>
    function printSection() {
        var printContents = document.getElementById('printSection').innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;

        location.reload();
    }
</script>
