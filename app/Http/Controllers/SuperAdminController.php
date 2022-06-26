<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;

session_start();

class SuperAdminController extends Controller
{
    public function logout()
    {
    	Session::flush();
    	return Redirect::to('/admin');
    }
    public function index()
    {
    	$this->AdminAuthCheck();
        $totalUsers = DB::table('tbl_admin')
            ->selectRaw('count(*) as count')->first()->count;
        $totalQueries = DB::table('tbl_contact_query')
            ->selectRaw('count(*) as count')->first()->count;
        $totalOrders = DB::table('tbl_order')
            ->selectRaw('count(*) as count')->first()->count;
        $totalProducts = DB::table('tbl_product')
            ->selectRaw('count(*) as count')->first()->count;
//dd();
        return view('admin.admin_dashboard2', compact('totalUsers', 'totalQueries', 'totalOrders', 'totalProducts'));
    }

    public function AdminAuthCheck()
    {
    	$admin=Session::get('admin_id');
        if($admin)
        {
        	return;
        }else{
        	return Redirect::to('/admin')->send();
        }
    }

}
