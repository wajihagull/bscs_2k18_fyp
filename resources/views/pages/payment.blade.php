@extends('layout')
@section('content')

    <section id="cart_items">
        <div class="container col-sm-12">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="#">Home</a></li>
                    <li class="active">Shopping Cart</li>
                </ol>
            </div>
            <div class="table-responsive cart_info">
                <?php
                $contents = Cart::content();

                ?>
                <table class="table table-condensed">
                    <thead>
                    <tr class="cart_menu">
                        <td class="image">Image</td>
                        <td class="description">Name</td>
                        <td class="price">Price</td>
                        <td class="quantity">Quantity</td>
                        <td class="total">Total</td>
                        <td>Action</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($contents as $v_contents) {?>
                    <tr>
                        <td class="cart_product">
                            <a href=""><img src="{{URL::to($v_contents->options->image)}}" height="80px" width="80px"
                                            alt=""></a>
                        </td>
                        <td class="cart_description">
                            <h4><a href="">{{$v_contents->name}}</a></h4>

                        </td>


                        <td class="cart_price">
                            <p>{{$v_contents->price}}</p>
                        </td>
                        <td class="cart_quantity">
                            <div class="cart_quantity_button">
                                <form action="{{url('/update-cart')}}" method="post">
                                    {{ csrf_field()}}
                                    <input class="cart_quantity_input" type="text" name="qty"
                                           value="{{$v_contents->qty}}" autocomplete="off" size="2">
                                    <input type="hidden" name="rowId" value="{{$v_contents->rowId}}">
                                    <input type="submit" name="submit" value="update" class="btn btn-sm btn-default">
                                </form>
                            </div>
                        </td>

                        <td class="cart_total">
                            <p class="cart_total_price">{{$v_contents->total}}</p>
                        </td>
                        <td class="cart_delete">

                            <a class="cart_quantity_delete" href="{{URL::to('/delete-to-cart/'.$v_contents->rowId)}}"><i
                                    class="fa fa-times"></i></a>
                        </td>
                    </tr>
                    <?php }?>

                    </tbody>
                </table>
            </div>
            <div class="total_area">
                <ul>
                    <li>Cart Sub Total <span>{{Cart::subtotal()}}</span></li>
                    <li>Eco Tax <span>{{Cart::tax()}}</span></li>
                    <li>Shipping Cost <span>Free</span></li>
                    <li>Total <span>{{Cart::total()}}</span></li>
                    <li>
                        <div class="row">
                            <div class="col-md-7">
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="discount" placeholder="Enter your code here."
                                       id="discount_code" class="form-control">
                            </div>
                            <button style="margin-top: 0px;" class="col-md-2 btn btn-primary" id="discount_btn">Apply
                                Discount
                            </button>
                        </div>
                    </li>
                    <li>Total after Discount <span id="totalAfterDiscount">0 PKR</span></li>

                </ul>
            </div>

        </div>
    </section> <!--/#cart_items-->
    <section id="do_action">
        <div class="container">
            <div class="heading">
                <h3>What would you like to do next?</h3>
                <p>Choose if you have a discount code or reward points you want to use or would like to estimate your
                    delivery cost.</p>
            </div>
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="#">Home</a></li>
                    <li class="active">Payment method</li>
                </ol>
            </div>
            <div class="paymentCont col-sm-8">
                <div class="headingWrap">
                    <h3 class="headingTop text-center"><b><i>Select Your Payment Method</i></b></h3><br>

                </div>
                <form action="{{url('/order-place')}}" method="post">
                    {{ csrf_field() }}
                    <input type="radio" name="payment_method" value="handcash">Cash on Delivery<br>
                    <input type="hidden" id="discount_code_input" name="discount_code" value="">
                    {{--                    <input type="radio" name="payment_method" value="card">Debit Card<br>--}}
                    {{--                    <input type="radio" name="payment_method" value="paypal">Paypal<br><br>--}}
                    <input type="submit" class="btn btn-success" name="" value="Done">
                </form>
            </div>
        </div>
    </section><!--/#do_action-->

@endsection
@section("scripts")
    <script>
        $(document).ready(() => {
            let total = "{{Cart::total()}}";
            $("#totalAfterDiscount").text(total);

            let formatNumber = (number)=>{
                return number.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            }
            $("#discount_btn").on('click', () => {
                let code = $("#discount_code").val();
                if(code === ''){
                    console.log("Nothing can be applied if code is empty");
                    return;
                }
                $("#discount_code_input").val(code);
                $.ajax({
                    url: "/get_discount_info",
                    method: "GET",
                    data: {
                        code
                    },
                    success: (resp) => {
                        if(resp.discount_percentage){
                            total = total.replace(",", "");
                            let discount = (Number.parseInt(total) * resp.discount_percentage/100);
                            $("#totalAfterDiscount").text(formatNumber(Number.parseInt(total)) + " - " + formatNumber(discount) + " = " + formatNumber( Number.parseInt(total) - discount));
                        }else{
                            alert("Code is not correct");
                        }
                    }
                });
            })
        });
    </script>
@endsection
