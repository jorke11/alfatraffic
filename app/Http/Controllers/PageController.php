<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller {

    public function driverEd() {
        return view("Pages.drivered");
    }

    public function scholarship() {
        return view("Pages.scholarship");
    }

    public function duirisk() {
        return view("Pages.duirisk");
    }

    public function victimImpact() {
        return view("Pages.victimImpact");
    }

    public function duiClinical() {
        return view("Pages.duiClinical");
    }

    public function defensive() {
        return view("Pages.defensive");
    }
    public function adultdrivers() {
        return view("Pages.adultdrivers");
    }
    public function teendriving() {
        return view("Pages.teendriving");
    }
    public function roadtest() {
        return view("Pages.roadtest");
    }
    public function pageschedule() {
        return view("Pages.pageschedule");
    }
    public function sandysprings() {
        return view("Pages.sandysprings");
    }
    public function buckheadatlanta() {
        return view("Pages.buckheadatlanta");
    }
    public function midtownatlanta() {
        return view("Pages.midtownatlanta");
    }
    public function smyrnaaustell() {
        return view("Pages.smyrnaaustell");
    }
    public function mariettaeastcobb() {
        return view("Pages.mariettaeastcobb");
    }
    public function doravillechamblee() {
        return view("Pages.doravillechamblee");
    }
    public function duluthlawrenceville() {
        return view("Pages.duluthlawrenceville");
    }

}
