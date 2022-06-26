@extends('layout')
@section('content')
    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="#">Home</a></li>
                    <li class="active">Check out</li>
                </ol>
            </div><!--/breadcrums-->

            <div class="shopper-informations">
                <div class="row">
                    <div class="col-sm-12 clearfix">
                        <div class="bill-to">
                            <p>Contact Us</p>
                            <div class="form-one">
                                <form action="{{url('/contact-us')}}" method="post">
                                    {{ csrf_field() }}
                                    <input type="text" name="email" placeholder="Email*">
                                    <input type="text" name="mobile_number" placeholder="Mobile Number *">
                                    <input type="text" name="city" placeholder="City *">
                                    <textarea name="message" id="message" cols="30" rows="10"></textarea>
                                    <input type="submit" class="btn btn-default" value="Done">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="review-payment">
                <h2>Review & Payment</h2>
            </div>
        </div>
    </section> <!--/#cart_items-->

@endsection
