<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Mail;
use Session;
use Cart;
use Illuminate\Support\Facades\Redirect;

session_start();

class CheckoutController extends Controller
{
    public function Login_checkout()
    {
        return view('pages.login');
    }

    public function Customer_Registration(Request $request)
    {
        $data = array();
        $data['customer_name'] = $request->customer_name;
        $data['customer_email'] = $request->customer_email;
        $data['password'] = md5($request->password);
        $data['mobile_number'] = $request->mobile_number;

        $customer_id = DB::table('tbl_customer')
            ->insertGetId($data);

        Session::put('customer_id', $customer_id);
        Session::put('customer_name', $request->customer_name);
        return Redirect('/checkout');

    }

    public function Checkout()
    {
        // $all_category_info = DB::table('tbl_category')
        // 	                    ->where('publication_status',1)
        // 	                    ->get();
        //     $manage_category = view('pages.checkout')
        //             ->with('all_category_info',$all_category_info);
        //         return view('layout')
        //                    ->with('pages.checkout',$manage_category);

        return view('pages.checkout');
    }

    public function Save_Shipping_Details(Request $request)
    {
        $data = array();
        $data['shipping_email'] = $request->shipping_email;
        $data['shipping_first_name'] = $request->shipping_first_name;
        $data['shipping_last_name'] = $request->shipping_last_name;
        $data['shipping_address'] = $request->shipping_address;
        $data['shipping_mobile_number'] = $request->shipping_mobile_number;
        $data['shipping_city'] = $request->shipping_city;

        try{
            $to_name = $data['shipping_first_name']." ".$data['shipping_last_name'];
            $to_email = $data['shipping_email'];
            Mail::send("mails.order_confirm", $data,
                function ($message) use ($to_name, $to_email) {
                    $message->to($to_email, $to_name)
                        ->subject("Thank You! Your Order is Confirmed");
                    $message->from("ladlike@gmail.com", "Lady Like");
                });
        }catch (Exception $e){
            //ignore
        }

        dd("test");

        $shipping_id = DB::table('tbl_shipping')
            ->insertGetId($data);
        Session::put('shipping_id', $shipping_id);
        return Redirect::to('/payment');

        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
    }


    public function Customer_Login(Request $request)
    {
        $customer_email = $request->customer_email;
        $password = md5($request->password);

        $result = DB::table('tbl_customer')
            ->where('customer_email', $customer_email)
            ->where('password', $password)
            ->first();

        // echo "<pre>";
        // print_r($result);
        // echo "</pre>";


        if ($result) {
            Session::put('customer_id', $result->customer_id);
            return Redirect::to('/checkout');
        } else {
            return Redirect::to('/login-checkout');
        }
    }

//     public function Customer_Logout()
//     {
//     	Session::flush();
//     	return Redirect::to('/');
//     }

    public function Payment()
    {
        return view('pages.payment');
    }

    public function Order_place(Request $request)
    {
        $payment_method = $request->payment_method;
        $discount_code = $request->discount_code;
        // $shipping_id = Session::get('shipping_id');
        // $customer_id = Session::get('customer_id');
        // echo $payment_gateway;
        // echo $customer_id;
        // echo "<pre>";
        // print_r($shipping_id);
        // echo "</pre>";

        $pdata = array();
        $pdata['payment_method'] = $payment_method;
        $pdata['payment_status'] = 0;

        $payment_id = DB::table('tbl_payment')
            ->insertGetId($pdata);

        $odata = array();
        $odata['customer_id'] = Session::get('customer_id');
        $odata['shipping_id'] = Session::get('shipping_id');
        $odata['payment_id'] = $payment_id;
        $total = Cart::total();
        $odata['order_total_before_discount'] = $total;
        if ($discount_code != "") {
            $odata['discount_code'] = $discount_code;
            $discount = DB::table('tbl_discount')
                ->select('tbl_discount.*')
                ->where('tbl_discount.discount_code', '=', $discount_code)
                ->where('tbl_discount.is_active', '=', true)
                ->get()->first();
            if ($discount) {
                $total = number_format((float)str_replace(',', '', $total) - ((float)str_replace(',', '', $total) * $discount->discount_percentage / 100));
            }
        }
        $odata['order_total'] = $total;
        $odata['order_status'] = 0;
        $odata['created_at'] = Carbon::now();
        $odata['updated_at'] = Carbon::now();
        $order_id = DB::table('tbl_order')
            ->insertGetId($odata);
        $contents = Cart::content();

        $oddata = array();
        foreach ($contents as $content) {
            $oddata['order_id'] = $order_id;
            $oddata['product_id'] = $content->id;
            $oddata['product_name'] = $content->name;
            $oddata['product_price'] = $content->price;
            $oddata['product_sales_quantity'] = $content->qty;

            $order_details = DB::table('tbl_order_details')
                ->insert($oddata);
        }

        if ($payment_method == 'handcash') {
            Cart::destroy();
            return view('pages.handcash');

        } elseif ($payment_method == 'card') {
            echo "successfully done Card";
        } elseif ($payment_method == 'paypal') {
            echo "successfully done paypal";
        } else {
            echo "No selected";
        }
    }

    public function Manage_Order()
    {
        $all_order_info = DB::table('tbl_order')
            ->join('tbl_customer', 'tbl_order.customer_id', '=', 'tbl_customer.customer_id')
            ->select('tbl_order.*', 'tbl_customer.customer_name')
            ->get();

        $manage_order = view('admin.manage_order')
            ->with('all_order_info', $all_order_info);
        return view('admin_layout')
            ->with('admin.manage_order', $manage_order);
    }

    public function viewOrder($order_id)
    {
        $order_by_id = DB::table('tbl_order')
            ->join('tbl_customer', 'tbl_order.customer_id', '=', 'tbl_customer.customer_id')
            ->join('tbl_order_details', 'tbl_order.order_id', '=', 'tbl_order_details.order_id')
            ->join('tbl_shipping', 'tbl_order.shipping_id', '=', 'tbl_shipping.shipping_id')
            ->select('tbl_order.*', 'tbl_order_details.*', 'tbl_shipping.*', 'tbl_customer.*')
            ->get();

        $view_order = view('admin.view_order')
            ->with('order_by_id', $order_by_id);
        return view('admin_layout')
            ->with('admin.view_order', $view_order);
    }


    public function deleteOrder($order_id)
    {
        DB::table('tbl_order')
            ->where('order_id', $order_id)
            ->delete();
        Session::get('message', 'Product Delete Successfully');
        return Redirect::to('/manage_order');

    }


    public function Customer_Logout()
    {
        Session::flush();
        return Redirect::to('/');
    }
}
