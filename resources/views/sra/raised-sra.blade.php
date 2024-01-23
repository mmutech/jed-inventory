@extends('components.layouts.app')

@section('content')
<h6 class="py-1 mb-2">
  <span class="text-muted fw-light"><a href="{{url('sra');}}">Store Received Advice</a> /</span> {{$title}}
</h6>

<div class="col-12 mb-4">
  <div class="bs-stepper wizard-numbered mt-2">
    <!--Headers-->
    <div class="bs-stepper-header">
      <div class="step active" data-target="#purchase-order-details">
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
        <button type="button" class="step-trigger" aria-selected="false">
          <span class="bs-stepper-circle">2</span>
          <span class="bs-stepper-label mt-1">
            <span class="bs-stepper-title">Item Info</span>
            <span class="bs-stepper-subtitle">Confirm Item info</span>
          </span>

        </button>
      </div>
    </div>

    <!--Contents-->
    <div class="bs-stepper-content">
      <form action="{{ route('store', $item->purchase_order_id) }}"  method="POST" >
        @csrf
        <!-- SRA Details -->
        <div id="purchase-order-details" class="content active dstepper-block">
          <div class="content-header mb-3">
            <h6 class="mb-0">Stores Received Advice</h6>
            <small>Enter Your SRA Details.</small>
          </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('info'))
                <div class="alert alert-info">
                    {{ session('info') }}
                </div>
            @endif
            <div class="row g-3">
              <div class="col-sm-6">
                <label class="form-label" for="purchase_order_no">Purchase Order No:</label>
                <input type="text" class="form-control" value="{{$item->purchaseOrderID->purchase_order_no}}" disabled>
              </div>
              <div class="col-sm-6">
                <label class="form-label" for="project_name">Project Name</label>
                <input type="text" class="form-control" value="{{$item->purchaseOrderID->purchase_order_name}}" disabled>
              </div>
              <div class="col-sm-6">
                <label class="form-label" for="location">Location:</label>
                <input type="text" class="form-control" value="{{$item->purchaseOrderID->delivery_address}}" disabled>
              </div>
              <div class="col-sm-6">
                <label class="form-label" for="vendor_name">Vendor Name</label>
                <input type="text" class="form-control" value="{{$item->purchaseOrderID->vendor_name}}" disabled>
              </div>

              <div class="col-sm-6">
                <label class="form-label" for="invoice_no">Invoice Number</label>
                <input type="text" name="invoice_no" class="form-control" placeholder="">
              </div>
              <div class="col-sm-6">
                <label class="form-label" for="consignment_note_no">Consignment Note No: </label>
                <input type="text" name="consignment_note_no" class="form-control" placeholder="johndoe">
              </div>

              <div class="col-12 d-flex justify-content-between">
                <button class="btn btn-label-secondary btn-prev" disabled="">
                  <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                  <span class="align-middle d-sm-inline-block d-none">Previous</span>
                </button>
                <button type="button" class="btn btn-primary btn-next">
                  <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                  <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                </button>
              </div>
            </div>
        </div>

        <!-- Item Info -->
        <div id="Item-info" class="content">
          <div class="content-header mb-3">
            <h6 class="mb-0">Item Info</h6>
            <small>Enter Your Item Info.</small>
          </div>
          <div class="row g-3">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="col-sm-12">
                <div class="mb-3" data-repeater-list="group-a">
                  <div class="repeater-wrapper pt-0 pt-md-4" data-repeater-item="">
                    <div class="d-flex border rounded position-relative pe-0">
                      <div class="row w-100 m-0 p-3">
                        <div class="table-responsive text-nowrap">
                            <!-- <div class="d-flex justify-content-end">  
                                <button type="button" class="btn btn-primary" onclick="addInputField()" data-repeater-create="">Add Item</button>
                            </div> -->
                            <div id="dynamicFieldsContainer">
                                <table class="table" id="itemsTable">
                                    <thead>
                                        <tr>
                                        <th>Stock Code</th>
                                        <th>Description</th>
                                        <th>Quantity/Unit</th>
                                        <th>Rate</th>
                                        <th>Job Order Amount</th>
                                        <th>Confirm Quantity</th>
                                        <th>Confirm Rate</th>
                                        <th>New Amount</th>
                                        <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $subtotal = 0;
                                        @endphp
                                        @foreach ($itemID as $key => $item)
                                        @php 
                                            $amount = $item->rate * $item->quantity;
                                            $subtotal += $amount;
                                        @endphp
                                            <tr class="input-container">
                                                <input type="text" name="item_id[]" value="{{$item->id}}" hidden>
                                                <td>
                                                <select class="form-select mb-4" name="stock_code[]">
                                                  <option value="123-456">(123-456) Test Item</option>
                                                  <option value="789-012">(789-012) Test Item 2</option>
                                                </select>
                                                </td>
                                                <td><p>{{$item->description}}</p></td>
                                                <td><p>{{$item->quantity}} ({{$item->unit}})</p></td>
                                                <td><p>{{$item->rate}}</p></td>
                                                <td><p class="mb-0 ">{{number_format($amount)}}</p></td>
                                                <td><input type="number" name="confirm_qty[]" class="form-control invoice-confirm_qty" value="{{$item->confirm_qty}}" step="1" min="1" oninput="calculateConfirmAmount(this)"></td>
                                                <td><input type="number" name="confirm_rate[]" class="form-control invoice-item-confirm_rate" value="{{$item->confirm_rate}}" step="0.01" min="1" oninput="calculateConfirmAmount(this)"></td>
                                                <td class="col-sm-2 confirm_amount"><p class="mb-0 "></p></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!--Raised Note-->
                        <div class="col-sm-12 mt-4">
                          <label class="form-label" for="received_note">Received Note</label>
                          <textarea class="form-control" name="received_note" id="received_note" cols="10" rows="2"></textarea>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
           
            <div class="col-12 d-flex justify-content-between">
              <button type="button" class="btn btn-primary btn-prev">
                <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                <span class="align-middle d-sm-inline-block d-none">Previous</span>
              </button>
              <button type="submit" class="btn btn-success btn-next btn-submit">Submit</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection