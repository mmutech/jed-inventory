<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SRA;
use App\Models\SRARemark;
use App\Models\PurchaseOrders;
use App\Models\Item;
use Illuminate\View\View;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class SRAController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        //
        $query = $request->input('search');
        
        // $data = SRA::where('local_purchase_order_no', 'LIKE', "%$query%")
        // ->orWhere('project_name', 'LIKE', "%$query%")
        // ->get();

        $data = SRARemark::latest()->paginate(5);

        // $item = Item::where('purchase_order_id', $data->raisedID->purchase_order_id)->first();

        // if (empty($query)) {
        //     $data = [];
        // }

        // dd($item);
        return view('sra.index', compact('data', 'query'))->with(
            'i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //
        $query = $request->input('search');
        
        $data = PurchaseOrders::where('status', 'Approved')
        ->orWhere('purchase_order_no', 'LIKE', "%$query%")
        ->orWhere('status', 'LIKE', "%$query%")
        ->get();

        if (empty($query)) {
            $data = [];
        }
        // dd($data);

        return view('sra.create', compact('data', 'query'))->with([
            'i', ($request->input('page', 1) - 1) * 5,
        ]);
    }

    public function raisedSra($id)
    {
        //
        $title = 'Raised SRA';
        $itemID = Item::where('purchase_order_id', $id)->get();
        $item = Item::where('purchase_order_id', $id)->first();

        // dd($item);

        return view('sra.raised-sra', compact('title', 'itemID', 'item'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        // Purchase Order ID
        $lastRecord = SRA::latest()->first();
        $sraID = $lastRecord ? $lastRecord->sra_id + 1 : 1;

        // Validation
        $validation = $request->validate([
            'consignment_note_no' => 'required',
            'invoice_no' => 'required',
            'received_note' => 'required',
            'confirm_qty' => 'required',
            'confirm_rate' => 'required',
            'stock_code' => 'required',
        ]);
    
        // Purchase Order
        if (!SRA::where('purchase_order_id', $id)->exists()) {
            $new_sra = SRA::create([
                'consignment_note_no' => $request->consignment_note_no,
                'invoice_no' => $request->invoice_no,
                'sra_id' => $sraID,
                'purchase_order_id' => $id,
                // 'updated_by' => auth()->user()->id,
            ]);
        }else {
            return redirect()->back()->with('info', 'SRA Already Exist');
        }
        

        //Confirm Items
        $inputFields = $request->except('_token');

        foreach ($inputFields['confirm_qty'] as $key => $confirm_qty) {
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
                    'confirm_qty' => $confirm_qty,
                    'confirm_rate' => $inputFields['confirm_rate'][$key],
                    'stock_code' => $inputFields['stock_code'][$key],
                    'confirm_by' => auth()->user()->id,
                    'confirm_date' => now(),
                    // Add other fields as needed
                ]);
            }
        }
    
        // Raised SRA
        SRARemark::create([
            'sra_id' => $sraID,
            'raised_date' => now(),
            'raised_by' => auth()->user()->id,
            'received_note' => $request->received_note,
            'received_by' => auth()->user()->id,
            'received_date' => now(),
        ]);

        return redirect()->route('sra.show', $id);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $title = 'SRA Details';
        $data = SRARemark::find($id);
        $items = Item::where('purchase_order_id', $data->raisedID->purchase_order_id)->get();
        $item = Item::where('purchase_order_id', $data->raisedID->purchase_order_id)->first();

        // dd($items);

        return view('sra.show', compact('data', 'title', 'items', 'item'));
    }

    /**
     * SRA.
     */
    public function edit(string $id)
    {
        //
        $title = "Modify";

        $data = SRARemark::find($id);
        $item = Item::where('purchase_order_id', $data->raisedID->purchase_order_id)->first();
        // dd($sra);
        return view('sra.edit',compact('title', 'data', 'item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
         // Validation
         $validation = $request->validate([
            'consignment_note_no' => 'required',
            'invoice_no' => 'required',
        ]);
    
        $sra = SRA::find($id);
        $sra->consignment_note_no = $request->consignment_note_no;
        $sra->invoice_no = $request->invoice_no;
        $sra->updated_at = now();
        $sra->updated_by = auth()->user()->id;

        $sra->update();

        return redirect()->route('sra.show', $id);
    }

    // Edit SRA Item
    public function sraItemEdit($id)
    {
        //
        $title = 'Raised SRA';
        $itemID = Item::where('purchase_order_id', $id)->get();
        $item = Item::where('purchase_order_id', $id)->first();

        return view('sra.edit-sra-item', compact('title', 'itemID', 'item'));
    }

    public function sraItemUpdate(Request $request, $id)
    {
        // Validation
        $validation = $request->validate([
            'stock_code' => 'required',
            'confirm_rate' => 'required',
            'confirm_qty' => 'required',
        ]);
    
        $inputFields = $request->except('_token');

        foreach ($inputFields['confirm_qty'] as $key => $confirm_qty) {
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
                    'confirm_qty' => $confirm_qty,
                    'confirm_rate' => $inputFields['confirm_rate'][$key],
                    'stock_code' => $inputFields['stock_code'][$key],
                    // Add other fields as needed
                ]);
            }
        }

        // $updateItem->update();

        return redirect()->route('sra.show', $id);
    }

    //Quality Checks
    public function qualityCheckEdit($id)
    {
        //
        $title = 'Quality Check';
        $itemID = Item::where('purchase_order_id', $id)->get();
        $item = Item::where('purchase_order_id', $id)->first();

        return view('sra.quality-check', compact('title', 'itemID', 'item'));
    }

    public function qualityCheckUpdate(Request $request, $id)
    {
        // Validation
        $validation = $request->validate([
            'quality_check_note.*' => 'required',
            'quality_check_action.*' => 'boolean',
        ]);
    
        $inputFields = $request->except('_token');

        foreach ($inputFields['quality_check_note'] as $key => $quality_check_note) {
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
                    'quality_check_by' => auth()->user()->id,
                    'quality_check_note' => $quality_check_note,
                    'quality_check_date' => now(),
                    'quality_check_action' => (bool)$inputFields['quality_check_action'][$key] == 1,
                    // Add other fields as needed
                ]);
            }
        }

        // $updateItem->update();

        return redirect()->route('sra.show', $id);
    }

    public function received(Request $request, $id)
    {
        // Validation
        $validation = $request->validate([
            'received_note' => 'required',
        ]);
    
        SRARemark::where('sra_id', $id)->update([
            'received_note' => $request->received_note,
            'received_by' => auth()->user()->id,
            'received_date' => now()
        ]);

        return redirect()->route('sra.show', $id);
    }

    public function psc(Request $request, $id)
    {
        // Validation
        $validation = $request->validate([
            'psc_card_note' => 'required',
        ]);
    
        SRARemark::where('sra_id', $id)->update([
            'psc_card_note' => $request->psc_card_note,
            'posted_stock_control_card' => auth()->user()->id,
            'psc_card_date' => now()
        ]);

        return redirect()->route('sra.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
