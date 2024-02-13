<div>
    <h6 class="py-1 mb-2">
    <span class="text-muted fw-light"><a href="{{url('purchase-order');}}">Purchase Order</a> /</span> {{$title}}
    </h6>

    <div class="row">
        <div class="col-md-12">
            <div class="bs-stepper">
                <!--Headers-->
                @if($step === 1)
                <div class="bs-stepper-header">
                    <div class="step active" data-target="#purchase-order-details">
                        <button type="button" class="step-trigger" aria-selected="true">
                        <span class="bs-stepper-circle">1</span>
                        <span class="bs-stepper-label mt-1">
                            <span class="bs-stepper-title">Purchase Order</span>
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
                            <span class="bs-stepper-subtitle">Add Item info</span>
                        </span>

                        </button>
                    </div>
                </div>
                @else
                <div class="bs-stepper-header">
                    <div class="step" data-target="#purchase-order-details">
                        <button type="button" class="step-trigger" wire:click="previousStep">
                        <span class="bs-stepper-circle">1</span>
                        <span class="bs-stepper-label mt-1">
                            <span class="bs-stepper-title">Purchase Order</span>
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
                            <span class="bs-stepper-subtitle">Add Item info</span>
                        </span>
                        </button>
                    </div>
                </div>
                @endif

                <div class="bs-stepper-content">
                    @if($step === 1)
                        <!-- Purchase Order Details -->
                        <div id="purchase-order-details" class="content active dstepper-block">
                            <div class="content-header mb-3">
                                <h6 class="mb-0">Purchase Order Details</h6>
                                <small>Enter Your Purchase Order Details.</small>
                            </div>
                            <div class="row g-3">
                            <div class="col-sm-6">
                                <label class="form-label" for="purchase_order_no">Purchase Order No</label>
                                <input type="text" wire:model="purchase_order_no" class="form-control" placeholder="JED/PROC/00/00/00">
                                @error('purchase_order_no') <span class="text-danger">{{ $message }}</span> @enderror 
                            </div>

                            <div class="col-sm-6">
                                <label class="form-label" for="purchase_order_name">Purchase Order Name</label>
                                <input type="text" wire:model="purchase_order_name" class="form-control" placeholder="johndoe">
                                @error('purchase_order_name') <span class="text-danger">{{ $message }}</span> @enderror 
                            </div>

                            <div class="col-sm-6">
                                <label class="form-label" for="beneficiary">Beneficiary</label>
                                <input type="text" wire:model="beneficiary" class="form-control" placeholder="Department / Unit Name">
                                @error('beneficiary') <span class="text-danger">{{ $message }}</span> @enderror 
                            </div>

                            <div class="col-sm-6">
                                <label class="form-label" for="vendor_name">Vendor Name</label>
                                <input type="text" wire:model="vendor_name" class="form-control" placeholder="Company Name Limited">
                                @error('vendor_name') <span class="text-danger">{{ $message }}</span> @enderror 
                            </div>

                            <div class="col-sm-6">
                                <label class="form-label" for="delivery_address">Delivery Address</label>
                                <select class="form-select mb-0" wire:model="delivery_address">
                                    <option value="">Select ...</option>
                                    @foreach($stations as $station)
                                        <option value="{{$station->store_id}}">{{$station->name}}</option>
                                    @endforeach
                                </select>
                                @error('delivery_address') <span class="text-danger">{{ $message }}</span> @enderror 
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
                                            <div class="d-flex justify-content-end">  
                                                <button type="button" class="btn btn-primary" wire:click.prevent="addInput" data-repeater-create="">Add Item</button>
                                            </div>
                                            <div id="dynamicFieldsContainer">
                                                <table class="table" id="itemsTable">
                                                    <thead>
                                                        <tr>
                                                        <th>#</th>
                                                        <th>Description</th>
                                                        <th>Unit</th>
                                                        <th>Quantity</th>
                                                        <th>Rate(&#8358;)</th>
                                                        <th>Amount(&#8358;)</th>
                                                        <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($inputs as $key => $value)
                                                            <tr>
                                                                <td></td>
                                                                <td class="col-sm-4">
                                                                    <input type="text" wire:model="descriptions.{{ $key }}" class="form-control" placeholder="Item Description">
                                                                    @error("descriptions.$key") <span class="error">{{ $message }}</span> @enderror 
                                                                </td>
                                                                <td class="col-sm-2">
                                                                    <select class="form-select" wire:model="units.{{ $key }}">
                                                                        <option value="">Select ...</option>
                                                                        @foreach($unitOfMeasure as $unit)
                                                                            <option value="{{$unit->id}}">{{$unit->description}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    @error("units.$key") <span class="error">{{ $message }}</span> @enderror 
                                                                </td>
                                                                <td class="col-sm-2">
                                                                    <input type="number" wire:model="quantities.{{ $key }}" class="form-control invoice-item-qty" step="1" min="1" oninput="calculateAmount(this)">
                                                                    @error("quantities.$key") <span class="error">{{ $message }}</span> @enderror 
                                                                </td>
                                                                <td class="col-sm-2">
                                                                    <input type="number" wire:model="rates.{{ $key }}" class="form-control invoice-item-rate" step="0.01" min="1" oninput="calculateAmount(this)">
                                                                    @error("rates.$key") <span class="error">{{ $message }}</span> @enderror 
                                                                </td>
                                                                <td class="col-sm-2 amount"><p class="mb-0 "></p></td>
                                                                <td>
                                                                @if($key !== 0)
                                                                    <a href="#" wire:click="removeInput({{ $key }})"><i class="bx bx-x text-danger"></i></a>
                                                                @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
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
                            <button class="btn btn-success btn-next btn-submit" wire:click="store">Submit</button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
