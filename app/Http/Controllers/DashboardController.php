<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class DashboardController extends Controller
{

    public function get_sales_data(Request $request){
        $data = [];
        $data[] = ['Date', 'Sales'];
        $begin = (new DateTime())->modify('-7 day');
        $end   = new DateTime();

        for($i = $begin; $i <= $end; $i->modify('+1 day')){
            $sql = "select * from tbl_order o where DATE(created_at)  = ? order by created_at";
            $results = DB::select($sql, [$i->format("Y-m-d")]);
            $totalSale = 0;
            foreach ($results as $result) {
                $totalSale += str_replace(',', '', $result->order_total);

            }
            $data[] = [$i->format("d M"), $totalSale];
        }

        return response()->json($data);
    }
    public function get_orders_data(Request $request){
        $data = [];
        $data[] = ['Date', 'Orders'];
        $begin = (new DateTime())->modify('-7 day');
        $end   = new DateTime();

        for($i = $begin; $i <= $end; $i->modify('+1 day')){
            $sql = "select * from tbl_order o where DATE(created_at)  = ? order by created_at";
            $results = DB::select($sql, [$i->format("Y-m-d")]);
            $data[] = [$i->format("d M"), count($results)];
        }

        return response()->json($data);
    }

}
