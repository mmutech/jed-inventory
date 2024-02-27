<?php
    //namespace App\Helpers;

    use App\Models\Store;

    //class Helper{
    if(!function_exists('showStores')) {

        function showStores(){
            $store = Store::where('store_officer', auth()->id())->pluck('name')->first();
            return $store;
        }
    }
