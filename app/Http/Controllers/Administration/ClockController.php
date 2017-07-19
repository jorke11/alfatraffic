<?php

namespace App\Http\Controllers\Administration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClockController extends Controller
{
    public function index(){
        return view("Administration.clock.init");
    }
}
