<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrders;
use App\Models\ApprovalPO;
use App\Models\Item;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        
        $data = PurchaseOrders::latest()->paginate(5);
        return view('purchase-order.purchase-order',compact('data'))->with([
            'i', ($request->input('page', 1) - 1) * 5,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $title = 'New';
        return view('purchase-order.create',compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Purchase Order ID
        $lastRecord = PurchaseOrders::latest()->first();
        $poID = $lastRecord ? $lastRecord->purchase_order_id + 1 : 1;

        // Validation
        $validation = $request->validate([
            'purchase_order_no' => 'required',
            'purchase_order_name' => 'required',
            'beneficiary' => 'required',
            'vendor_name' => 'required',
            'delivery_address' => 'required',
            'description.*' => 'required',
            'unit.*' => 'required',
            'quantity.*' => 'required|numeric',
            'rate.*' => 'required|numeric',
        ]);
    
        // Purchase Order
        $new_purchase_order = PurchaseOrders::create([
            'purchase_order_no' => $request->purchase_order_no,
            'purchase_order_name' => $request->purchase_order_name,
            'beneficiary' => $request->beneficiary,
            'vendor_name' => $request->vendor_name,
            'delivery_address' => $request->delivery_address,
            'purchase_order_date' => now(),
            'purchase_order_id' => $poID,
        ]);
    
        // Initiator
        $initiate_purchase_order = ApprovalPO::create([
            'purchase_order_id' => $poID,
            'initiator_action' => 'Initiated',
            'initiator' => auth()->user()->id,
        ]);
    
        // Items
        $descriptions = $request->input('description');
        $units = $request->input('unit');
        $quantities = $request->input('quantity');
        $rates = $request->input('rate');
    
        foreach ($descriptions as $key => $description) {
            Item::create([
                'purchase_order_id' => $poID,
                'description' => $description,
                'unit' => $units[$key],
                'quantity' => $quantities[$key],
                'rate' => $rates[$key],
            ]);
        }
    
        return redirect()->route('purchase-order.index');
    }    

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        //
        $title = 'Details';
        $data = PurchaseOrders::where('purchase_order_id', $id)->first();
        $items = Item::where('purchase_order_id', $id)->get();
        $actions = ApprovalPO::with('purchasedOrderID')->where('purchase_order_id', $id)->first();
        // dd($actions);

        return view('purchase-order.show',compact('title', 'data', 'items', 'actions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = "Modify";

        $data = PurchaseOrders::find($id);

        // dd($editPurchaseOrder);
        return view('purchase-order.edit',compact('title', 'data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validation
        $validation = $request->validate([
            'purchase_order_no' => 'required',
            'purchase_order_name' => 'required',
            'beneficiary' => 'required',
            'vendor_name' => 'required',
            'delivery_address' => 'required',
        ]);
    
        $editPurchaseOrder = PurchaseOrders::find($id);
        $editPurchaseOrder->purchase_order_no = $request->purchase_order_no;
        $editPurchaseOrder->purchase_order_name = $request->purchase_order_name;
        $editPurchaseOrder->beneficiary = $request->beneficiary;
        $editPurchaseOrder->vendor_name = $request->vendor_name;
        $editPurchaseOrder->delivery_address = $request->delivery_address;
        $editPurchaseOrder->updated_at = now();
        $editPurchaseOrder->updated_by = auth()->user()->id;

        $editPurchaseOrder->update();

        return redirect()->route('purchase-order.show', $id);
    }

    // Edit Item
    public function editItem($id)
    {
        $title = "Modify Item";

        $itemID = Item::where('purchase_order_id', $id)->get();
        $item = Item::where('purchase_order_id', $id)->first();

        // dd($editPurchaseOrder);
        return view('purchase-order.edit-item',compact('title', 'itemID', 'item'));
    }

    // Update Item
    public function updateItem(Request $request, $id)
    {
        // Validation
        $validation = $request->validate([
            'description' => 'required',
            'unit' => 'required',
            'quantity' => 'required',
            'rate' => 'required',
        ]);
    
        $inputFields = $request->except('_token');

        foreach ($inputFields['description'] as $key => $description) {
            $itemID = $inputFields['item_id'][$key] ?? null; // Assuming you have an 'item_id' field in your form

            // Validate that $itemID is a valid integer
            if (!is_numeric($itemID)) {
                continue; // Skip the iteration if $itemID is not a valid integer
            }

            $item = Item::where('purchase_order_id', $id)
                ->where('id', $itemID)
                ->first();

            if ($item) {
                // Update the item based on the fetched record
                $item->update([
                    'description' => $description,
                    'unit' => $inputFields['unit'][$key],
                    'quantity' => $inputFields['quantity'][$key],
                    'rate' => $inputFields['rate'][$key],
                    // Add other fields as needed
                ]);
            }
        }

        // $updateItem->update();

        return redirect()->route('purchase-order.show', $id);
    }

    // Recommendation
    public function recommend(Request $request, $id)
    {
        // Validation
        $validation = $request->validate([
            'recommended_action' => 'required',
            'recommend_note' => 'required',
        ]);
    
        ApprovalPO::where('purchase_order_id', $id)->update([
            'recommend_note' => $request->recommend_note,
            'recommended_action' => $request->recommended_action,
            'recommended_by' => auth()->user()->id,
            'date_recommended' => now()
        ]);

        return redirect()->route('purchase-order.show', $id);
    }

    // Approved
    public function approved(Request $request, $id)
    {
        // Validation
        $validation = $request->validate([
            'approved_note' => 'required',
            'approved_action' => 'required',
        ]);
    
        ApprovalPO::where('purchase_order_id', $id)->update([
            'approved_note' => $request->approved_note,
            'approved_action' => $request->approved_action,
            'approved_by' => auth()->user()->id,
            'date_approved' => now()
        ]);

        PurchaseOrders::where('purchase_order_id', $id)->update([
            'status' => 'Approved',
        ]);

        return redirect()->route('purchase-order.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
