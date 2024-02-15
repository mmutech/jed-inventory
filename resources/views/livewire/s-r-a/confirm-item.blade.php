<div>
    <h6 class="py-1 mb-2">
    <span class="text-muted fw-light"><a href="{{url('sra');}}">Store Received Advice</a> /</span> {{$title}}
    </h6>

    <div class="row">
        <div class="col-md-12">
            <div class="bs-stepper">
                <!--Headers-->
                @if($step === 1)
                <div class="bs-stepper-header">
                    <div class="step active">
                        <button type="button" class="step-trigger" aria-selected="true">
                        <span class="bs-stepper-circle">1</span>
                        <span class="bs-stepper-label mt-1">
                            <span class="bs-stepper-title">SRA</span>
                            <span class="bs-stepper-subtitle">Details</span>
                        </span>
                        </button>
                    </div>

                    <!--Pointer-->
                    <div class="line">
                        <i class="bx bx-chevron-right"></i>
                    </div>
                    <div class="step" data-target="#Item-info">
                        <button type="button" class="step-trigger" aria-selected="false" disabled>
                        <span class="bs-stepper-circle">2</span>
                        <span class="bs-stepper-label mt-1">
                            <span class="bs-stepper-title">Item Info</span>
                            <span class="bs-stepper-subtitle">Confirm Item info</span>
                        </span>
                        </button>
                    </div>
                </div>
                @else
                <div class="bs-stepper-header">
                    <div class="step">
                        <button type="button" class="step-trigger" wire:click="previousStep">
                        <span class="bs-stepper-circle">1</span>
                        <span class="bs-stepper-label mt-1">
                            <span class="bs-stepper-title">SRA</span>
                            <span class="bs-stepper-subtitle">Details</span>
                        </span>
                        </button>
                    </div>

                    <!--Pointer-->
                    <div class="line">
                        <i class="bx bx-chevron-right"></i>
                    </div>
                    <div class="step active" data-target="#Item-info">
                        <button type="button" class="step-trigger" aria-selected="false">
                        <span class="bs-stepper-circle">2</span>
                        <span class="bs-stepper-label mt-1">
                            <span class="bs-stepper-title">Item Info</span>
                            <span class="bs-stepper-subtitle">Confirm Item info</span>
                        </span>
                        </button>
                    </div>
                </div>
                @endif

                <div class="bs-stepper-content">
                    @if($step === 1)
                        <!-- SRA Details -->
                        <div class="content active dstepper-block">
                            <div class="content-header mb-3">
                                <h6 class="mb-0">Stores Received Advice</h6>
                                <small>Enter Your SRA Details.</small>
                            </div>
                            
                            <div class="row g-3 mb-3">
                                <div class="col-sm-6">
                                    <label class="form-label" for="purchase_order_no">Purchase Order No:</label>
                                    <input type="text" class="form-control" wire:model="purchase_order_no" disabled>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label" for="project_name">Project Name</label>
                                    <input type="text" class="form-control" wire:model="purchase_order_name" disabled>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label" for="location">Station:</label>
                                    <input type="text" class="form-control" wire:model="delivery_address" disabled>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label" for="vendor_name">Vendor Name</label>
                                    <input type="text" wire:model="vendor_name" class="form-control" disabled>
                                </div>

                                <div class="col-sm-6">
                                    <label class="form-label" for="invoice_no">Invoice Number</label>
                                    <input type="text" wire:model="invoice_no" class="form-control" placeholder="">
                                    @error('invoice_no') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label" for="consignment_note_no">Consignment Note No: </label>
                                    <input type="text" wire:model="consignment_note_no" class="form-control" placeholder="johndoe">
                                    @error('consignment_note_no') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="col-12 d-flex justify-content-between">
                                <button class="btn btn-label-secondary btn-prev" disabled="">
                                <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                                <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                </button>
                                <button type="button" class="btn btn-primary btn-next" wire:click="nextStep">
                                <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                                <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                                </button>
                            </div>
                        </div>

                    @elseif($step === 2)
                        <div class="content-header mb-3">
                            <h6 class="mb-0">Item Info</h6>
                            <small>Enter Your Item Info.</small>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{$error}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                        <!-- Item Info -->
                        <div class="row g-3">
                            <div class="col-sm-12">
                                <div class="mb-3" data-repeater-list="group-a">
                                    <div class="repeater-wrapper pt-0 pt-md-4" data-repeater-item="">
                                        <div class="d-flex border rounded position-relative pe-0">
                                        <div class="row w-100 m-0 p-3">
                                            <div class="table-responsive text-nowrap">
                                                <div id="dynamicFieldsContainer">
                                                    <table class="table" id="itemsTable">
                                                        <thead>
                                                            <tr>
                                                            <th>Stock Code</th>
                                                            <th>Description</th>
                                                            <th>Quantity/(Unit)</th>
                                                            <th>Rate</th>
                                                            <th>Job Order Amount (&#8358;)</th>
                                                            <th>Confirm Quantity</th>
                                                            <th>Confirm Rate (&#8358;)</th>
                                                            <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        @php
                                                            $subtotal = 0;
                                                        @endphp
                                                        @foreach ($items as $key => $item)
                                                            @php 
                                                                $amount = $item->rate * $item->quantity;
                                                                $subtotal += $amount;
                                                            @endphp
                                                            <tr class="input-container">
                                                                <input type="hidden" wire:model="itemIDs.{{ $key }}" class="form-control">
                                                                <td class="col-sm-2">
                                                                <input type="text" wire:model.live="search" class="form-control" placeholder="Type to Search...">
                                                                    <select class="form-control" wire:model="stock_codes.{{ $key }}">
                                                                        <option value="">Select...</option>
                                                                        @foreach($stock_code as $stCode)
                                                                        <option value="{{$stCode->id}}">{{$stCode->stock_code}} - {{$stCode->name}}</option>
                                                                        @endforeach
                                                                    </select>     
                                                                    @error("stock_codes.$key") <span class="error">{{ $message }}</span> @enderror 
                                                                </td>
                                                                <td><p>{{$item->description}}</p></td>
                                                                <td><p>{{$item->quantity}} ({{$item->unitID->description}})</p></td>
                                                                <td><p>{{number_format($item->rate)}}</p></td>
                                                                <td><p>{{number_format($amount)}}</p></td>
                                                                <td class="col-sm-2">
                                                                    <input type="number" wire:model="confirm_qtys.{{ $key }}" class="form-control invoice-item-qty" step="1" min="1" oninput="calculateAmount(this)">
                                                                    @error("confirm_qtys.$key") <span class="error">{{ $message }}</span> @enderror 
                                                                </td>
                                                                <td class="col-sm-2">
                                                                    <input type="number" wire:model="confirm_rates.{{ $key }}" class="form-control invoice-item-rate" step="0.01" min="1" oninput="calculateAmount(this)">
                                                                    @error("confirm_rates.$key") <span class="error">{{ $message }}</span> @enderror 
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <!--Raised Note-->
                                            <div class="col-sm-12 mt-4">
                                            <label class="form-label" for="received_note">Received Note</label>
                                            <textarea class="form-control" wire:model="received_note" id="received_note" cols="10" rows="2"></textarea>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 d-flex justify-content-between">
                        <button class="btn btn-primary btn-prev" wire:click="previousStep">
                            <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                            <span class="align-middle d-sm-inline-block d-none">Previous</span>
                        </button>
                        <button class="btn btn-success btn-next btn-submit" wire:click="confirmed">Submit</button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
