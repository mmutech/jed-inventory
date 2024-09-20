<?php

namespace App\Livewire\Request;

use App\Models\Recommendations;
use App\Models\RequestItemTable;
use Livewire\Component;
use Livewire\Attributes\Rule; 
use Livewire\Attributes\Locked;
use Illuminate\Support\Facades\Auth;

class Recommendation extends Component
{
    public $title;

    #[Locked]
    public $referenceId;

    #[Rule('required')]
    public $recommendQty = [];

    public $recommend_action, $recommend_note, $items, $key;

    public function recommend($key, $stockCodeID)
    {
        $data = RequestItemTable::where('reference', $this->referenceId)
        ->where('stock_code_id', $stockCodeID)
        ->first();

        // dd($this->recommendQty);

        if ($data) {
            if (empty($data->quantity_recommend)) {
                RequestItemTable::where('id', $data->id)->update([
                    'quantity_recommend' => $this->recommendQty[$key],
                ]);
    
                $this->dispatch('success', message: 'Item Recommended Successfully!');
            } else{
                $this->dispatch('error', message: 'Item Already Recommended!');
            }
        }else {

            $this->dispatch('error', message: 'Item Not Found!');
        }

        $this->recommendQty[$key] = '';
    }

    public function update()
    {
        if($this->referenceId){
            Recommendations::create([
                'reference'         => $this->referenceId,
                'recommend_note'    => $this->recommend_note,
                'recommend_action'  => $this->recommend_action,
                'recommend_by'      => auth()->user()->id,
                'recommend_date'    => now()
            ]);

            if ($this->recommend_action == 'Recommend') {
                RequestItemTable::where('reference', $this->referenceId)->update([
                    'status' => 'Recommended',
                ]);

                $this->dispatch('success', message: 'Items Recommended Successfully!');
                return redirect()->to('request-view/' . $this->referenceId);
            }else {
                $this->dispatch('danger', message: 'Items Not Recommended!');
                return redirect()->to('request-view/' . $this->referenceId);
            }

            
        }
    }

    public function mount($referenceId)
    {
        $this->referenceId = $referenceId;
        $referenceId = $this->referenceId;
        $this->title = substr($referenceId, 0, strpos($referenceId, '-'));

        $this->items = RequestItemTable::where('reference', $this->referenceId)->get();
    }

    public function render()
    {
        return view('livewire.request.recommendation');
    }
}
