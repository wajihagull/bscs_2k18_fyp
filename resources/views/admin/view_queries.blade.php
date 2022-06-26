@extends('admin_layout')
@section('admin_dashboard')

<ul class="breadcrumb">
				<li>
					<i class="icon-home"></i>
					<a href="/">Home</a>
					<i class="icon-angle-right"></i>
				</li>
				<li><a href="#">View Queries</a></li>
			</ul>

			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon user"></i><span class="break"></span>Queries List</h2>

					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								  <th>Id</th>
								  <th>Email</th>
								  <th>Mobile Number</th>
								  <th>City</th>
								  <th>Message</th>
							  </tr>
						  </thead>


                         <p class="alert-success">
							<?php
							$message = Session::get('message');
							if ($message) {
								   echo $message;
								   Session::put('message',null);
							}
						    ?>
						</p>

                          @foreach($queries as $query)
						  <tbody>
							<tr>
								<td>{{$query->id}}</td>
								<td class="center">{{$query->email}}</td>
								<td class="center">{{$query->mobile_number}}</td>
								<td class="center">{{$query->city}}</td>
								<td class="center">{{$query->message}}</td>



							</tr>

						  </tbody>
						  @endforeach


					  </table>
					</div>
				</div><!--/span-->

			</div><!--/row-->



@endsection
