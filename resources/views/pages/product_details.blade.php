@extends('layout')
@section('content')

<div class="col-sm-9 padding-right">
					<div class="product-details"><!--product-details-->
						<div class="col-sm-5">
							<div class="view-product">
								<img src="{{$product_details_by_id->product_image}}" alt="" />
{{--								<h3>ZOOM</h3>--}}
							</div>
						</div>
						<div class="col-sm-7">
							<div class="product-information"><!--/product-information-->
{{--								<img src="{{URL::to('frontend/images/product-details/new.jpg')}}" class="newarrival" alt="" />--}}
								<h2>{{$product_details_by_id->product_name}}</h2>
								<p>Product ID:{{$product_details_by_id->product_id}} </p>
								<p>Color:{{$product_details_by_id->product_color}} </p>
								<img src="{{URL::to('frontend/images/product-details/rating.png')}}" alt="" />
								<span>
									<form action="{{url('/add-to-cart')}}" method="post">
										{{ csrf_field() }}
									<span>Rs. {{$product_details_by_id->product_price}}</span>
									<label>Quantity:</label>
									<input type="text" value="1" name="qty" />
                                    <input type="hidden" name="product_id" value="{{$product_details_by_id->product_id}}">
									<button type="submit" class="btn btn-fefault cart">
										<i class="fa fa-shopping-cart"></i>
										Add to cart
									</button>
									</form>
								</span>
								<p><b>Availability:</b> In Stock</p>
								<p><b>Condition:</b> New</p>
								<p><b>Brand:</b>{{$product_details_by_id->manufacture_name}}</p>
								<p><b>Category:</b>{{$product_details_by_id->category_name}}</p>
								<p><b>Size:</b>{{$product_details_by_id->product_size}}</p>
{{--								<a href=""><img src="{{URL::to('frontend/images/product-details/share.png')}}" class="share img-responsive"  alt="" /></a>--}}
{{--							</div><!--/product-information-->--}}
						</div>
					</div><!--/product-details-->

					<div class="category-tab shop-details-tab"><!--category-tab-->
						<div class="col-sm-12">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#details" data-toggle="tab">Details</a></li>
							</ul>
						</div>

						<div class="tab-content">
							<div class="tab-pane fade active in" id="details" >

                              <p>{!! $product_details_by_id->product_long_description !!}</p>

							</div>

							<div class="tab-pane fade" id="companyprofile" >
								<div class="col-sm-3">
									<div class="product-image-wrapper">
										<div class="single-products">
											<div class="productinfo text-center">
												<img src="images/home/gallery1.jpg" alt="" />
												<h2>$56</h2>
												<p>Easy Polo Black Edition</p>
												<button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
											</div>
										</div>
									</div>
								</div>
							</div>



							<div class="tab-pane fade" id="tag" >
								<div class="col-sm-3">
									<div class="product-image-wrapper">
										<div class="single-products">
											<div class="productinfo text-center">
												<img src="images/home/gallery1.jpg" alt="" />
												<h2>$56</h2>
												<p>Easy Polo Black Edition</p>
												<button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
											</div>
										</div>
									</div>
								</div>
							</div>



							<div class="tab-pane fade " id="reviews" >
								<div class="col-sm-12">
{{--									<ul>--}}
{{--										<li><a href=""><i class="fa fa-user"></i>EUGEN</a></li>--}}
{{--										<li><a href=""><i class="fa fa-clock-o"></i>12:41 PM</a></li>--}}
{{--										<li><a href=""><i class="fa fa-calendar-o"></i>31 DEC 2014</a></li>--}}
{{--									</ul>--}}
									<p>A boutique (French: [butik]) is a small shop that deals in fashionable clothing or accessories.</p>
									<p><b>Write Your Review</b></p>

									<form action="#">
										<span>
											<input type="text" placeholder="Your Name"/>
											<input type="email" placeholder="Email Address"/>
										</span>
										<textarea name="" ></textarea>
										<b>Rating: </b> <img src="{{URL::to('frontend/images/product-details/rating.png')}}" alt="" />
										<button type="button" class="btn btn-default pull-right">
											Submit
										</button>
									</form>
								</div>
							</div>

						</div>
					</div><!--/category-tab-->



@endsection
