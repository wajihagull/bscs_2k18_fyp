<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//Frontend site
Route::get('/','HomeController@index');



//Category Wise Product
Route::get('/product-by-category{category_id}','HomeController@product_by_category');
Route::get('/product_by_manufacture{manufacture_id}','HomeController@product_by_manufacture');
Route::get('/view-product{product_id}','HomeController@product_details_by_id');
//Cart Routes are here.....................
Route::post('/add-to-cart','CartController@Add_to_Cart');
Route::get('/show-cart','CartController@Show_Cart');
Route::get('/delete-to-cart{rowId}','CartController@delete_to_cart');
Route::post('/update-cart','CartController@Update_Cart');
//Checkout routes are here..................
Route::get('/login-checkout','CheckoutController@Login_checkout');
Route::post('/customer-registration','CheckoutController@Customer_Registration');
Route::get('/checkout','CheckoutController@Checkout');
Route::post('/save-shipping-details','CheckoutController@Save_Shipping_Details');
//Customer Login And Logout here.......................
Route::post('/customer-login','CheckoutController@Customer_Login');
Route::get('/customer-logout','CheckoutController@Customer_Logout');

//payment routes are here........

Route::get('/get_sales_data','DashboardController@get_sales_data');
Route::get('/get_orders_data','DashboardController@get_orders_data');
Route::get('/payment','CheckoutController@Payment');
Route::post('/order-place','CheckoutController@Order_Place');
Route::get('/manage_order','CheckoutController@Manage_Order');
Route::get('/view-order{order_id}','CheckoutController@viewOrder');
Route::get('/delete-order{order_id}','CheckoutController@deleteOrder');

//Backend site........................................

Route::get('/logout','SuperAdminController@logout');
Route::get('/admin','AdminController@index');
Route::get('/dashboard','SuperAdminController@index');
Route::post('/admin-dashboard','AdminController@dashboard');

//Category............................................

Route::get('/add-category','AdminCategoryController@index');
Route::get('/all-category','AdminCategoryController@allCategory');
Route::get('/edit-category{category_id}','AdminCategoryController@editCategory');
Route::post('/update-category/{category_id}','AdminCategoryController@updateCategory');
Route::get('/delete-category{category_id}','AdminCategoryController@deleteCategory');

Route::post('/save-category','AdminCategoryController@saveCategory');
Route::get('/unactive-category{category_id}','AdminCategoryController@unactiveCategory');
Route::get('/active-category{category_id}','AdminCategoryController@activeCategory');

//Manufacture or Brands

Route::get('/add-manufacture','ManufactureController@index');
Route::post('/save-manufacture','ManufactureController@saveManufacture');
Route::get('/all-manufacture','ManufactureController@allManufacture');
Route::get('/unactive-manufacture{manufacture_id}','ManufactureController@unactiveManufacture');
Route::get('/active-manufacture{manufacture_id}','ManufactureController@activeManufacture');
Route::get('/delete-manufacture{manufacture_id}','ManufactureController@deleteManufacture');
Route::get('/edit-manufacture{manufacture_id}','ManufactureController@editManufacture');
Route::post('/update-manufacture/{manufacture_id}','ManufactureController@updateManufacture');


//Products......................................

Route::get('/add-product','ProductController@index');
Route::post('/save-product','ProductController@saveProduct');
Route::get('/all-product','ProductController@allProduct');
Route::get('/unactive-product{product_id}','ProductController@unactiveProduct');
Route::get('/active-product{product_id}','ProductController@activeProduct');
Route::get('/delete-product{product_id}','ProductController@deleteProduct');
Route::get('/edit-product{product_id}','ProductController@editProduct');
Route::post('/update-product/{product_id}','ProductController@updateProduct');



Route::get('/contact-us','ContactController@index');
Route::post('/contact-us','ContactController@save');
Route::get('/view_queries','ContactController@list_queries');


Route::get('/get_discount_info','DiscountController@get_discount_info');


//Slider..................................

Route::get('/add-slider','SliderController@AddSlider');
Route::post('/save-slider','SliderController@SaveSlider');
Route::get('/all-slider','SliderController@allSlider');
Route::get('/unactive-slider{slider_id}','SliderController@unactiveSlider');
Route::get('/active-slider{slider_id}','SliderController@activeSlider');
Route::get('/delete-slider{slider_id}','SliderController@deleteSlider');
