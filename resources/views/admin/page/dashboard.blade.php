@extends('layouts.admin')
@section('title')
    Dashboard
@endsection
@section('section')
    <section class="section">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card card-statistic-2">
                    <div class="card-stats">
                        <div class="card-stats-title">Order Statistics -
                            <div class="dropdown d-inline">
                                <a class="font-weight-600 dropdown-toggle" data-toggle="dropdown" href="#"
                                    id="orders-month">{{ \Carbon\Carbon::createFromFormat('m', $month)->format('F') }}</a>
                                <ul class="dropdown-menu dropdown-menu-sm">
                                    <li class="dropdown-title">Select Month</li>
                                    @foreach (range(1, 12) as $m)
                                        <li>
                                            <a href="#" id="month" data-month="{{ $m }}"
                                                class="dropdown-item {{ $m == $month ? 'active' : '' }}">
                                                {{ \Carbon\Carbon::createFromFormat('m', $m)->format('F') }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="card-stats-items">
                            <div class="card-stats-item">
                                <div class="card-stats-item-count" id="pending-count">{{ @$pendingCount }}</div>
                                <div class="card-stats-item-label">Pending</div>
                            </div>
                            <div class="card-stats-item">
                                <div class="card-stats-item-count" id="shipping-count">{{ @$shippingCount }}</div>
                                <div class="card-stats-item-label">Shipping</div>
                            </div>
                            <div class="card-stats-item">
                                <div class="card-stats-item-count" id="completed-count">{{ @$completedCount }}</div>
                                <div class="card-stats-item-label">Completed</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-icon shadow-primary bg-primary">
                        <i class="fas fa-archive"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Orders</h4>
                        </div>
                        <div class="card-body" id="total-orders">
                            {{ $totalOrdersCount }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card card-statistic-2">
                    <div class="card-chart">
                        <canvas id="balance-chart" height="80"></canvas>
                    </div>
                    <div class="card-icon shadow-primary bg-primary">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Doanh thu</h4>
                        </div>
                        <div class="card-body" id="total-revenue">
                            {{ number_format($totalRevenue, 0, ',', '.') }}₫
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card card-statistic-2">
                    <div class="card-chart">
                        <canvas id="sales-chart" height="80"></canvas>
                    </div>
                    <div class="card-icon shadow-primary bg-primary">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Đã bán</h4>
                        </div>
                        <div class="card-body" id="total-products-sold">
                            {{ $totalProductsSold }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Biểu đồ doanh số</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="myChart" height="158"></canvas>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Best Products</h4>
                    </div>
                    <div class="card-body">
                        <div class="owl-carousel owl-theme" id="products-carousel">
                            <div>
                                <div class="product-item pb-3">
                                    <div class="product-image">
                                        <img alt="image" src="assets/img/products/product-4-50.png" class="img-fluid">
                                    </div>
                                    <div class="product-details">
                                        <div class="product-name">iBook Pro 2018</div>
                                        <div class="product-review">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <div class="text-muted text-small">67 Sales</div>
                                        <div class="product-cta">
                                            <a href="#" class="btn btn-primary">Detail</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="product-item">
                                    <div class="product-image">
                                        <img alt="image" src="assets/img/products/product-3-50.png" class="img-fluid">
                                    </div>
                                    <div class="product-details">
                                        <div class="product-name">oPhone S9 Limited</div>
                                        <div class="product-review">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half"></i>
                                        </div>
                                        <div class="text-muted text-small">86 Sales</div>
                                        <div class="product-cta">
                                            <a href="#" class="btn btn-primary">Detail</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="product-item">
                                    <div class="product-image">
                                        <img alt="image" src="assets/img/products/product-1-50.png" class="img-fluid">
                                    </div>
                                    <div class="product-details">
                                        <div class="product-name">Headphone Blitz</div>
                                        <div class="product-review">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="far fa-star"></i>
                                        </div>
                                        <div class="text-muted text-small">63 Sales</div>
                                        <div class="product-cta">
                                            <a href="#" class="btn btn-primary">Detail</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card gradient-bottom">
                    <div class="card-header">
                        <h4>Top 5 Products</h4>
                        <div class="card-header-action dropdown">
                            <a href="#" data-toggle="dropdown" class="btn btn-danger dropdown-toggle">Month</a>
                            <ul class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                <li class="dropdown-title">Select Period</li>
                                <li><a href="#" class="dropdown-item" id="dropdown-item"
                                        data-period="today">Today</a></li>
                                <li><a href="#" class="dropdown-item" id=dropdown-item data-period="week">Week</a>
                                </li>
                                <li><a href="#" class="dropdown-item" id="dropdown-item"
                                        data-period="month">Month</a></li>
                                <li><a href="#" class="dropdown-item" id="dropdown-item" data-period="year">This
                                        Year</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body" id="top-5-scroll">
                        <ul class="list-unstyled list-unstyled-border" id="top-products-list">

                        </ul>
                    </div>
                    {{-- <div class="card-footer pt-3 d-flex justify-content-center"></div> --}}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Invoices</h4>
                        {{-- @can('view-orders') --}}
                            <div class="card-header-action">
                                <a href="{{ route('admin.orders.index') }}" class="btn btn-danger">View More <i
                                        class="fas fa-chevron-right"></i></a>
                            </div>
                        {{-- @endcan --}}
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive table-invoice">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Invoice ID</th>
                                        <th>Customer</th>
                                        <th>Status</th>
                                        <th>Due Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td><a
                                                    href="{{ route('admin.orders.show', $order->id) }}">{{ Str::limit($order->invoice_id, 15, '...') }}</a>
                                            </td>
                                            <td class="font-weight-600">{{ @$order->user->name }}</td>
                                            <td>
                                                @switch($order->order_status)
                                                    @case('pending')
                                                        <span class='badge bg-warning'>Pending</span>
                                                    @break

                                                    @case('processed_and_ready_to_ship')
                                                        <span class='badge bg-info'>Processed</span>
                                                    @break

                                                    @case('dropped_off')
                                                        <span class='badge bg-info'>Dropped off</span>
                                                    @break

                                                    @case('shipped')
                                                        <span class='badge bg-primary'>Shipped</span>
                                                    @break

                                                    @case('out_for_delivery')
                                                        <span class='badge bg-primary'>Out for delivery</span>
                                                    @break

                                                    @case('delivered')
                                                        <span class='badge bg-success'>Delivered</span>
                                                    @break

                                                    @case('canceled')
                                                        <span class='badge bg-danger'>Canceled</span>
                                                    @break

                                                    @default
                                                        <span class='badge bg-secondary'>Unknown</span>
                                                @endswitch
                                            </td>
                                            <td>{{ $order->created_at->format('F d, Y') }}</td>
                                            <td>
                                                <a href="{{ route('admin.orders.show', $order->id) }}"
                                                    class="btn btn-primary">Detail</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-hero">
                    <div class="card-header">
                        <div class="card-icon">
                            <i class="far fa-question-circle"></i>
                        </div>
                        <h4>14</h4>
                        <div class="card-description">Customers need help</div>
                    </div>
                    <div class="card-body p-0">
                        <div class="tickets-list">
                            <a href="#" class="ticket-item">
                                <div class="ticket-title">
                                    <h4>My order hasn't arrived yet</h4>
                                </div>
                                <div class="ticket-info">
                                    <div>Laila Tazkiah</div>
                                    <div class="bullet"></div>
                                    <div class="text-primary">1 min ago</div>
                                </div>
                            </a>
                            <a href="#" class="ticket-item">
                                <div class="ticket-title">
                                    <h4>Please cancel my order</h4>
                                </div>
                                <div class="ticket-info">
                                    <div>Rizal Fakhri</div>
                                    <div class="bullet"></div>
                                    <div>2 hours ago</div>
                                </div>
                            </a>
                            <a href="#" class="ticket-item">
                                <div class="ticket-title">
                                    <h4>Do you see my mother?</h4>
                                </div>
                                <div class="ticket-info">
                                    <div>Syahdan Ubaidillah</div>
                                    <div class="bullet"></div>
                                    <div>6 hours ago</div>
                                </div>
                            </a>
                            <a href="features-tickets.html" class="ticket-item ticket-more">
                                View All <i class="fas fa-chevron-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            function getTopProducts(period) {
                $.ajax({
                    url: '/admin/dashboard/top-products/' + period,
                    method: 'GET',
                    success: function(response) {
                        $('#top-products-list').empty();
                        response.forEach(function(product) {
                            $('#top-products-list').append(`
                        <li class="media">
                            <img class="mr-3 rounded" width="55" src="{{ asset('storage') }}/${product.image}" alt="product">
                            <div class="media-body">
                                <div class="media-title">${product.name}</div>
                                <div class="mt-1">
                                    <div class="font-weight-600 text-muted text-small">${product.sales} Sales</div>
                                </div>
                            </div>
                        </li>
                    `);
                        });
                    }
                });
            }

            getTopProducts('month');

            $('a#dropdown-item').on('click', function(e) {
                e.preventDefault();
                var period = $(this).data('period');
                $('a#dropdown-item').removeClass('active');
                $(this).addClass('active');

                getTopProducts(period);
            });
        });

        $(document).ready(function() {
            $.ajax({
                url: '{{ route('admin.dashboard.yearly-statistics') }}',
                method: 'GET',
                success: function(response) {
                    var ctx = document.getElementById("myChart").getContext('2d');
                    var myChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: [
                                "Tháng một", "Tháng hai", "Tháng ba",
                                "Tháng tư", "Tháng năm", "Tháng sáu",
                                "Tháng bảy", "Tháng tám", "Tháng chín",
                                "Tháng mười", "T.Mười một", "T.Mười hai"
                            ],
                            datasets: [{
                                label: 'Doanh thu (VND)',
                                data: response.monthlyRevenue,
                                borderWidth: 2,
                                backgroundColor: 'rgba(63,82,227,.8)',
                                borderColor: 'rgba(63,82,227,.8)',
                                pointBorderWidth: 0,
                                pointRadius: 3.5,
                                pointBackgroundColor: 'transparent',
                                pointHoverBackgroundColor: 'rgba(63,82,227,.8)',
                            }, ]
                        },
                        options: {
                            // responsive: true,
                            // maintainAspectRatio: false,
                            legend: {
                                display: false
                            },
                            tooltips: {
                                bodyFontSize: 10,
                                titleFontSize: 12,
                            },
                            scales: {
                                yAxes: [{
                                    gridLines: {
                                        // display: false,
                                        drawBorder: false,
                                        color: '#f2f2f2',
                                    },
                                    ticks: {
                                        beginAtZero: true,
                                        // stepSize: 1500,
                                        callback: function(value) {
                                            return value.toLocaleString('vi-VN');
                                        }
                                    }
                                }],
                                xAxes: [{
                                    gridLines: {
                                        display: false,
                                        tickMarkLength: 15,
                                    }
                                }]
                            }
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Lỗi tải dữ liệu:', error);
                }
            });
        });
        var balance_chart = document.getElementById("balance-chart").getContext('2d');
        var balance_chart_bg_color = balance_chart.createLinearGradient(0, 0, 0, 70);
        balance_chart_bg_color.addColorStop(0, 'rgba(63,82,227,.2)');
        balance_chart_bg_color.addColorStop(1, 'rgba(63,82,227,0)');

        var balanceChart = new Chart(balance_chart, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Doanh thu (₫)',
                    data: [],
                    backgroundColor: balance_chart_bg_color,
                    borderWidth: 3,
                    borderColor: 'rgba(63,82,227,1)',
                    pointBorderWidth: 0,
                    pointBorderColor: 'transparent',
                    pointRadius: 3,
                    pointBackgroundColor: 'transparent',
                    pointHoverBackgroundColor: 'rgba(63,82,227,1)',
                }]
            },
            options: {
                layout: {
                    padding: {
                        bottom: -1,
                        left: -1
                    }
                },
                legend: {
                    display: false,

                },
                tooltips: {
                    bodyFontSize: 7,
                    titleFontSize: 8,
                },
                scales: {
                    yAxes: [{
                        gridLines: {
                            display: false,
                            drawBorder: false,
                        },
                        ticks: {
                            beginAtZero: true,
                            display: false
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            drawBorder: false,
                            display: false,
                        },
                        ticks: {
                            display: false
                        }
                    }]

                },
            }
        });

        var sales_chart = document.getElementById("sales-chart").getContext('2d');
        var sales_chart_bg_color = sales_chart.createLinearGradient(0, 0, 0, 80);
        balance_chart_bg_color.addColorStop(0, 'rgba(63,82,227,.2)');
        balance_chart_bg_color.addColorStop(1, 'rgba(63,82,227,0)');

        var salesChart = new Chart(sales_chart, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Số lượng đã bán',
                    data: [],
                    borderWidth: 2,
                    backgroundColor: balance_chart_bg_color,
                    borderWidth: 3,
                    borderColor: 'rgba(63,82,227,1)',
                    pointBorderWidth: 0,
                    pointBorderColor: 'transparent',
                    pointRadius: 3,
                    pointBackgroundColor: 'transparent',
                    pointHoverBackgroundColor: 'rgba(63,82,227,1)',
                }]
            },
            options: {
                layout: {
                    padding: {
                        bottom: -1,
                        left: -1
                    }
                },
                legend: {
                    display: false
                },
                tooltips: {
                    bodyFontSize: 7,
                    titleFontSize: 8,
                },
                scales: {
                    yAxes: [{
                        gridLines: {
                            display: false,
                            drawBorder: false,
                        },
                        ticks: {
                            beginAtZero: true,
                            display: false
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            drawBorder: false,
                            display: false,
                        },
                        ticks: {
                            display: false
                        }
                    }]
                },
            }
        });

        function updateCharts(month) {
            $.ajax({
                url: `/admin/dashboard/order-statistics/${month}`,
                method: 'GET',
                success: function(response) {
                    $('#total-revenue').text(new Intl.NumberFormat('vi-VN', {
                        style: 'currency',
                        currency: 'VND'
                    }).format(response.totalRevenue));
                    $('#total-products-sold').text(response.totalProductsSold);

                    const labels = response.chartLabels || [];
                    const revenueData = response.revenueData || [];
                    const salesData = response.salesData || [];

                    balanceChart.data.labels = labels;
                    balanceChart.data.datasets[0].data = revenueData;
                    balanceChart.update();

                    salesChart.data.labels = labels;
                    salesChart.data.datasets[0].data = salesData;
                    salesChart.update();
                },
                error: function(xhr, status, error) {
                    alert('Có lỗi xảy ra khi tải dữ liệu biểu đồ.');
                }
            });
        }

        $(document).ready(function() {
            const currentMonth = new Date().getMonth() + 1;
            updateCharts(currentMonth);

            $('body').on('click', '#month', function(e) {
                e.preventDefault();
                const month = $(this).data('month');
                updateCharts(month);
            });
        });
        $(document).ready(function() {
            $('a[data-month]').on('click', function(e) {
                e.preventDefault();

                var month = $(this).data('month');
                var url = '/admin/dashboard/order-statistics/' + month;

                console.log("Requesting URL: " + url);
                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(response) {
                        console.log(response);
                        $('#pending-count').text(response.pendingCount);
                        $('#shipping-count').text(response.shippingCount);
                        $('#completed-count').text(response.completedCount);
                        $('#total-orders').text(response.totalOrdersCount);
                        $('#total-revenue').text(response.totalRevenue.toLocaleString('vi-VN') +
                            '₫');
                        $('#total-products-sold').text(response.totalProductsSold);

                        $('#orders-month').text(response.monthName);
                        $('a[data-month]').removeClass('active');
                        $('a[data-month="' + month + '"]').addClass('active');
                    },
                    error: function(xhr, status, error) {
                        alert('Có lỗi xảy ra khi tải thống kê.');
                    }
                });
            });
        });
    </script>
@endpush
