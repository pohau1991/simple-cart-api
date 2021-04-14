<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Item;

use App\Services\ApiService;

class ItemController extends Controller
{
    //

    public function getItems(){
        $api = new ApiService();
        $items = Item::all();
        return $api->makeResponse($items);
    }
}
