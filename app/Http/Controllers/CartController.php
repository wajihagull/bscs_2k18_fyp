<?php
namespace App\Http\Controllers;
use App\Http\Requests;
use DB;
use Session;
use Illuminate\Support\Facades\Redirect;
use Cart;
session_start();

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function Add_to_Cart(Request $request)
    {
    	$qty = $request->qty;
    	$product_id = $request->product_id;
    	$add_to_cart = DB::table('tbl_product')
                      ->where('product_id',$product_id)
                      ->first();

         $data['qty'] = $qty;
         $data['id'] = $add_to_cart->product_id;
         $data['name'] = $add_to_cart->product_name;
         $data['price'] = $add_to_cart->product_price;
         $data['options']['image'] = $add_to_cart->product_image;

         Cart::add($data);

         return Redirect::to('/show-cart');

   }

    public function Show_Cart()
    {
    		$all_category_info = DB::table('tbl_category')
    		                    ->where('publication_status',1)
    		                    ->get();
   	     $manage_category = view('pages.add_to_cart')
   	             ->with('all_category_info',$all_category_info);
   	         return view('layout')
   	                    ->with('pages.add_to_cart',$manage_category);
    }

    public function delete_to_cart($rowId)
    {
    	Cart::update($rowId,0);
    	return Redirect::to('/show-cart');
    }

    public function Update_Cart(Request $request)
    {

        dd($request->input());

    	$qty = $request->qty;
    	$rowId = $request->rowId;

        Cart::update($rowId,$qty);
    	return Redirect::to('/show-cart');

    	// echo $qty;
    	// echo "<br>";
    	// echo $rowId;

    }
}
