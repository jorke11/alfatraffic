<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
   public function driverEd(){
       return view("Pages.drivered");
   }
   public function scholarship(){
       return view("Pages.scholarship");
   }
}
