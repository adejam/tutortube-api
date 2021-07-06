<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminVideoController extends Controller
{
    public function store(Request $request)
    {
        return response(['status'=> 'working'], 200);
    }
}
