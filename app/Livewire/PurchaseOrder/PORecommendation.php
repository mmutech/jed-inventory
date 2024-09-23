<?php

namespace App\Livewire\PurchaseOrder;

use App\Models\Item;
use App\Models\PurchaseOrders;
use App\Models\Recommendations;
use Livewire\Component;
use Livewire\Attributes\Rule; 
use Livewire\Attributes\Locked;
use Illuminate\Support\Facades\Auth;

class PORecommendation extends Component
{
    public $title = 'Recommendation';

    public $item;

    #[Locked]
    public $poID;

    #[Rule('required')]
    public $recommend_action, $recommend_note, $items, $key;

    public function recommend($id)
    {
        Item::where('id', $id)->first()->update([
            'recommend' => 1,
        ]);

        $this->dispatch('success', message: 'Recommended!');

    }

    public function update()
    {
        Recommendations::create([
            'reference'         => $this->poID,
            'recommend_note'    => $this->recommend_note,
            'recommend_by'      => auth()->user()->id,
            'recommend_date'    => now()
        ]);

        $this->dispatch('info', message: 'Items Recommended!');
        return redirect()->to('purchase-order-show/' . $this->poID);

    }

    public function mount($poID)
    {
        $this->poID = $poID;

        $this->items = Item::where('purchase_order_id', $this->poID)->get();
    }

    public function render()
    {
        return view('livewire.purchase-order.p-o-recommendation')->with([
            'items' => Item::where('purchase_order_id', $this->poID)->get(),
        ]);
    }
}
