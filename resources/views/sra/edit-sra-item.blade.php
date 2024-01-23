@extends('components.layouts.app')

@section('content')
<h6 class="py-1 mb-2">
  <span class="text-muted fw-light"><a href="{{url('sra');}}">Store Receive Advice</a> /</span> {{$title}}
</h6>

<div class="card">
    <div class="card-header">
        <h6 class="mb-0">SRA Items</h6>
        <small>Modify Your SRA Items.</small>
    </div>
    <hr class="my-1">
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row w-100 m-0 p-3">
            <div class="table-responsive text-nowrap">
                <form action="{{ route('update-sra-item', $item->purchase_order_id) }}" method="POST">
                    @csrf
                    <div id="dynamicFieldsContainer">
                        <table class="table" id="itemsTable">
                            <thead>
                                <tr>
                                <th rowspan="3">Stock Code</th>
                                <th>Description</th>
                                <th>Quantity/Unit</th>
                                <th>Current Amount</th>
                                <th>Confirm Quantity</th>
                                <th>Confirm Rate</th>
                                <th>New Amount</th>
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
                                        <td rowpan="3">
                                        <select class="form-select mb-4" name="stock_code[]">
                                            <option value="123-456">(123-456) Test Item</option>
                                            <option value="789-012">(789-012) Test Item 2</option>
                                        </select>
                                        </td>
                                        <td><p>{{$item->description}}</p></td>
                                        <td><p>{{$item->quantity}} ({{$item->unit}})</p></td>
                                        <td><p class="mb-0 ">{{number_format($amount)}}</p></td>
                                        <td><input type="number" name="confirm_qty[]" class="form-control invoice-confirm_qty" value="{{$item->confirm_qty}}" step="1" min="1" oninput="calculateConfirmAmount(this)"></td>
                                        <td><input type="number" name="confirm_rate[]" class="form-control invoice-item-confirm_rate" value="{{$item->confirm_rate}}" step="0.01" min="1" oninput="calculateConfirmAmount(this)"></td>
                                        <td class="col-sm-2 confirm_amount"><p class="mb-0 "></p></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="row py-sm-3">
                            <div class="col-12 d-flex justify-content-between">
                                <button type="submit" class="btn btn-info btn-next">
                                    <span class="align-middle d-sm-inline-block d-none me-sm-1">Modify</span>
                                    <i class="bx bx-pencil bx-sm me-sm-n2"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection