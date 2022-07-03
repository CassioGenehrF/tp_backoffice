<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class OwnerController extends Controller
{
    public function index(Request $request)
    {
        return view('owner')->with('name', Auth::user()->display_name);
    }
}
