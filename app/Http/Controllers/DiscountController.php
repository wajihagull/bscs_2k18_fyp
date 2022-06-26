<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\JsonResponse;

class DiscountController extends Controller
{

    public function index()
    {
        $manage_published_product = view('pages.contact-us');
        return view('layout')
            ->with('pages.home_content',$manage_published_product);
    }

    public function save(Request $request){
        $data = [];
        $data['email'] = $request->email;
        $data['mobile_number'] = $request->mobile_number;
        $data['city'] = $request->city;
        $data['message'] = $request->message;
        DB::table('tbl_contact_query')->insert($data);
        return Redirect::to('/');
    }


    public function list_queries(Request $request){
        $all_queries = DB::table('tbl_contact_query')
            ->select('tbl_contact_query.*')
            ->get();

        $manage_order = view('admin.view_queries')
            ->with('queries',$all_queries);
        return view('admin_layout')
            ->with('admin.manage_order',$manage_order);
    }

    public function get_discount_info(Request $request){

//        dd();


        $data = DB::table('tbl_discount')
            ->select('tbl_discount.*')
            ->where('tbl_discount.discount_code', '=', $request->input('code'))
            ->where('tbl_discount.is_active', '=', true)
            ->get()->first();
        return response()
            ->json($data);
    }

}
