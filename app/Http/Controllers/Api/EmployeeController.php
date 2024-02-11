<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller; 
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(!Auth::user()->authorized('update invoices'))
        {
            return response()->json(['errors' => 'Not Authorized.'], 403);
        }

        $employees = Employee::all();

        return response()->json(['employees' => $employees], 200);
    }
}
