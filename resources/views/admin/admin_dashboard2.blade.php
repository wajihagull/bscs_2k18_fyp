@extends('admin_layout')
@section('admin_dashboard')

    <ul class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="/">Home</a>
            <i class="icon-angle-right"></i>
        </li>
        <li><a href="#">Dashboard</a></li>
    </ul>

    <div class="row-fluid">

        <a class="quick-button metro yellow span3">
            <i class="icon-group"></i>
            <p>Users</p>
            <span class="badge">{{$totalUsers}}</span>
        </a>

        <a class="quick-button metro blue span3">
            <i class="icon-shopping-cart"></i>
            <p>Orders</p>
            <span class="badge">{{$totalOrders}}</span>
        </a>
        <a class="quick-button metro green span3">
            <i class="icon-barcode"></i>
            <p>Products</p>
            <span class="badge">{{$totalProducts}}</span>

        </a>
        <a class="quick-button metro pink span3">
            <i class="icon-envelope"></i>
            <p>Messages</p>
            <span class="badge">{{$totalQueries}}</span>
        </a>
    </div>
    <div class="clearfix"></div>

    <div style="display: flex !important;">
            <div id="sales_chart" style="width: 450px; height: 300px"></div>
            <div id="order_chart" style="width: 450px; height: 300px"></div>
    </div>
@endsection


@section("scripts")
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages': ['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {


            $.ajax({
                url: "/get_sales_data",
                method: "GET",
                success: (resp) => {
                    var data = google.visualization.arrayToDataTable(resp);

                    var options = {
                        title: 'Sales History',
                        curveType: 'function',
                        legend: {position: 'bottom'},
                        width: 550,
                        height: 350,
                    };

                    var chart = new google.visualization.LineChart(document.getElementById('order_chart'));

                    chart.draw(data, options);

                }
            });


            $.ajax({
                url: "/get_orders_data",
                method: "GET",
                success: (resp) => {
                    var data = google.visualization.arrayToDataTable(resp);

                    var options = {
                        title: 'Orders History',
                        curveType: 'function',
                        width: 550,
                        height: 350,
                        legend: {position: 'bottom'}
                    };

                    var chart = new google.visualization.LineChart(document.getElementById('sales_chart'));

                    chart.draw(data, options);

                }
            });


        }
    </script>
@endsection
