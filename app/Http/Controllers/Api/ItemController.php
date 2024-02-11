<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller; 
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(!Auth::user()->authorized('update items'))
        {
            return response()->json(['errors' => 'Not Authorized.'], 403);
        }

        $items = Item::with([
            'extras',
            'itemCategory',
            'itemType',
            'itemSubcategory',
            'prices',
        ])->get();

        return response()->json(['items' => $items], 200);
    }
}
