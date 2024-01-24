<?php

namespace App\Http\Controllers\Api;

use App\Models\Table;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Auth;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(!Auth::user()->authorized('update tables'))
        {
            return response()->json(['errors' => 'Not Authorized.'], 403);
        }

        $tables = Table::all();

        return response()->json(['tables' => $tables], 200);
    }

}
