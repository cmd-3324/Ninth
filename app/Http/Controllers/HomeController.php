<?php

// CHANGE THIS LINE:
namespace App\Http\Controllers; // ✅ Correct namespace

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
public function index() {
    return view("home");
    // return response()->json(['user_idd' => $user_id]); // Test response
}
}
