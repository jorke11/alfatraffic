<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Administration\Parameters;
use App\Models\Days;

class CronController extends Controller {

    public function createDays() {

        $months = $this->createMonts();

        $desc = array();
        $init = 0;

        foreach ($months as $key => $value) {
            if ($key == 0) {
                $init = (int) date("d");
            } else {
                $init = 1;
            }

            for ($j = $init; $j <= cal_days_in_month(CAL_GREGORIAN, $value["month"], date("y")); $j++) {
                $dayweek = $this->getDay($value["year"], $value["month"], $j);
                $desc = array("year" => $value["year"], "month" => $value["month"], "day" => $j, "number_week" => $dayweek);
                $valid = Days::where("year", $value["year"])->where("month", $value["month"])->where("day", $j)->first();

                if ($valid == null) {
                    $desc["date"] = date("Y-m-d H:i");
                    print_r($desc);
                    echo "<br>";
                    Days::create($desc);
                }
            }
        }
    }

    public function getDay($year, $month, $day) {
        $i = strtotime(date($year . "-" . $month . "-" . $day));
        $resp = jddayofweek(cal_to_jd(CAL_GREGORIAN, date("m", $i), date("d", $i), date("Y", $i)), 0);

        return ($resp == 0) ? 7 : $resp;
    }

    public function createMonts() {
        $days = Parameters::where("group", "show")->first();
        $init = (int) date("m");
        $end = 12 - $init;

        $months = array();
        $year = (int) date("Y");
        for ($i = 0; $i <= $end; $i++) {
            $months[] = array("month" => $init + $i, "year" => $year, "literal" => $this->getMonth($init + $i));
        }

        $end = 12 - ($init + $days->value);

        if ($end < -12) {
            for ($j = 1; $j <= abs(round(($end / 12))); $j++) {
                $year = $year + 1;

                for ($i = 1; $i <= 12; $i++) {
                    $months[] = array("month" => $i, "year" => $year, "literal" => $this->getMonth($i));
                }
            }
        }

        if ($end < 0) {
            $year = $year + 1;
            for ($i = 1; $i <= abs($end % 12); $i++) {
                $months[] = array("month" => $i, "year" => $year, "literal" => $this->getMonth($i));
            }
        }

        return $months;
    }

    public function getMonth($number) {
        $mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
        return $mes[$number - 1];
    }

}
