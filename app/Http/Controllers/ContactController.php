<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// compact("DearUserName")
class ContactController extends Controller
{
    public function show_contanct_page() {
        return view("Contact");
}
}
