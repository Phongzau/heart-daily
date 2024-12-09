@extends('layouts.admin')
@section('title')
    {{ $generalSettings->site_name }} || Bảng điều khiển
@endsection

@section('section')
    <section class="section">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card card-statistic-2">
                    <div class="card-stats">
                        <div class="card-stats-title">Thống kê đơn hàng -
                            <div class="dropdown d-inline">
                                <a class="font-weight-600 dropdown-toggle" data-toggle="dropdown" href="#"
                                    id="orders-month">{{ \Carbon\Carbon::createFromFormat('m', $month)->locale('Vi')->translatedFormat('F') }}</a>
                                <ul class="dropdown-menu dropdown-menu-sm">
                                    <li class="dropdown-title">Chọn Tháng</li>
                                    @foreach (range(1, 12) as $m)
                                        <li>
                                            <a href="#" id="month" data-month="{{ $m }}"
                                                class="dropdown-item {{ $m == $month ? 'active' : '' }}">
                                                {{ \Carbon\Carbon::createFromFormat('m', $m)->locale('Vi')->translatedFormat('F') }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="card-stats-items">
                            <div class="card-stats-item">
                                <div class="card-stats-item-count" id="pending-count">{{ @$pendingCount }}</div>
                                <div class="card-stats-item-label">Chưa xử lý</div>
                            </div>
                            <div class="card-stats-item">
                                <div class="card-stats-item-count" id="shipping-count">{{ @$shippingCount }}</div>
                                <div class="card-stats-item-label">Đang vận chuyển</div>
                            </div>
                            <div class="card-stats-item">
                                <div class="card-stats-item-count" id="completed-count">{{ @$completedCount }}</div>
                                <div class="card-stats-item-label">Hoàn thành</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-icon shadow-primary bg-primary">
                        <i class="fas fa-archive"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Tổng số đơn đặt hàng</h4>
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
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Biểu đồ doanh số</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="myChart" height="158"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Danh mục & Thương hiệu</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="myChart2"></canvas>
                        <hr>
                        <br>
                        <canvas id="myChart3"></canvas>
                    </div>
                </div>
            </div>


        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Top 5 Doanh thu</h4>
                        <div class="card-header-action dropdown">
                            <a href="#" id="revenue-dropdown-toggle-btn" data-toggle="dropdown"
                                class="btn btn-danger dropdown-toggle">Tháng</a>
                            <ul class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                <li class="dropdown-title"></li>
                                <li><a href="#" class="dropdown-item" data-revenue-period="today">Ngày</a></li>
                                <li><a href="#" class="dropdown-item" data-revenue-period="week">Tuần</a></li>
                                <li><a href="#" class="dropdown-item" data-revenue-period="month">Tháng</a></li>
                                <li><a href="#" class="dropdown-item" data-revenue-period="year">Năm</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul id="top-revenue-list" class="list-unstyled list-unstyled-border">

                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Top 5 Sản phẩm</h4>
                        <div class="card-header-action dropdown">
                            <a href="#" id="dropdown-toggle-btn" data-toggle="dropdown"
                                class="btn btn-danger dropdown-toggle">Tháng</a>
                            <ul class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                <li class="dropdown-title"></li>
                                <li>
                                    <a href="#" class="dropdown-item" data-period="today">Ngày</a>
                                </li>
                                <li>
                                    <a href="#" class="dropdown-item" data-period="week">Tuần</a>
                                </li>
                                <li>
                                    <a href="#" class="dropdown-item" data-period="month">Tháng</a>
                                </li>
                                <li>
                                    <a href="#" class="dropdown-item" data-period="year">Năm</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled list-unstyled-border" id="top-products-list">

                        </ul>
                    </div>
                    {{-- <div class="card-footer pt-3 d-flex justify-content-center"></div> --}}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Sản phẩm tốt nhất</h4>
                    </div>
                    <div class="card-body">
                        <div class="owl-carousel owl-theme" id="products-carousel">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Hóa đơn</h4>




                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive table-invoice">
                            <table class="table table-striped gradient-bottom">
                                <thead>
                                    <tr>
                                        <th>ID hóa đơn</th>
                                        <th>Khách hàng</th>
                                        <th>Trạng thái đơn</th>
                                        <th>Ngày đặt đơn</th>
                                        <th>Thao tác</th>
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
                                                        <span class='badge bg-warning'>Chưa xử lý</span>
                                                    @break

                                                    @case('processed_and_ready_to_ship')
                                                        <span class='badge bg-info'>Đã xử lý</span>
                                                    @break

                                                    @case('dropped_off')
                                                        <span class='badge bg-info'>Đã giao đến</span>
                                                    @break

                                                    @case('shipped')
                                                        <span class='badge bg-primary'>Đã vận chuyển</span>
                                                    @break

                                                    @case('out_for_delivery')
                                                        <span class='badge bg-primary'>Đang giao</span>
                                                    @break

                                                    @case('delivered')
                                                        <span class='badge bg-success'>Đã giao hàng</span>
                                                    @break

                                                    @case('canceled')
                                                        <span class='badge bg-danger'>Hủy bỏ</span>
                                                    @break

                                                    @default
                                                        <span class='badge bg-secondary'>Unknown</span>
                                                @endswitch
                                            </td>
                                            @php
                                                \Carbon\Carbon::setLocale('vi');
                                            @endphp

                                            <td>{{ \Carbon\Carbon::parse($order->created_at)->translatedFormat('d F, Y') }}
                                            </td>

                                            <td>
                                                <a href="{{ route('admin.orders.show', $order->id) }}"
                                                    class="btn btn-primary">Chi tiết</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            @if ($orders->count() >= 3)
                                                <a href="{{ route('admin.orders.index') }}">Xem thêm<i
                                                        class="fas fa-chevron-right"></i></a>
                                            @endif
                                        </td>
                                    </tr>

                                </tfoot>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
@push('scripts')
    <script>
        //category
        fetch('/admin/dashboard/category-statistics')
            .then(response => response.json())
            .then(data => {
                var ctx = document.getElementById("myChart2").getContext('2d');
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {

                        labels: data.categoryLabels,
                        datasets: [{
                            data: data.categorySales,
                            backgroundColor: data.categoryColors,
                        }],


                    },
                    options: {
                        responsive: true,
                        legend: {
                            position: 'bottom',
                        },
                    }
                });
            }).catch(error => console.error('Error fetching category statistics:', error));
        //brand
        fetch('/admin/dashboard/brand-statistics')
            .then(response => response.json())
            .then(data => {
                var ctx = document.getElementById("myChart3").getContext('2d');
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {

                        labels: data.brandLabels,
                        datasets: [{
                            data: data.brandSales,
                            backgroundColor: data.brandColors,
                        }],


                    },
                    options: {
                        responsive: true,
                        legend: {
                            position: 'bottom',
                        },
                    }
                });
            }).catch(error => console.error('Error fetching brand statistics:', error));
        // review
        function loadBestRatedProducts() {
            $.ajax({
                url: '/admin/dashboard/best-rated-products',
                method: 'GET',
                success: function(response) {

                    $('#products-carousel').empty();


                    response.forEach(function(product) {
                        let productName = product.name;
                        if (productName.length > 20) {
                            productName = productName.substring(0, 20) +
                                '...';
                        }
                        $('#products-carousel').append(`
                        <div>
                            <div class="product-item pb-3">
                                <div class="product-image">
                                    <img alt="${product.name}" src="{{ asset('storage') }}/${product.image}" class="img-fluid">
                                </div>
                                <div class="product-details">
                                    <div class="product-name">${productName}</div>
                                    <div class="product-review">
                                        ${renderStars(product.avg_rating)}
                                    </div>
                                    <div class="text-muted text-small">${product.review_count} Reviews</div>
                                    <div class="product-cta">
                                        <a href="{{ url('product/detail') }}/${product.slug}" class="btn btn-primary">Chi tiết</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `);
                    });

                    // Reinitialize carousel (nếu cần thiết)
                    $('#products-carousel').trigger('destroy.owl.carousel').owlCarousel({
                        loop: true,
                        margin: 10,
                        nav: false,
                        dots: false,
                        autoplay: true,
                        autoplayTimeout: 2000,
                        autoplayHoverPause: true,
                        responsive: {
                            0: {
                                items: 1
                            },
                            600: {
                                items: 2
                            },
                            1000: {
                                items: 3
                            }
                        }
                    });
                },
                error: function() {
                    alert('Không thể tải danh sách sản phẩm đánh giá cao nhất.');
                },
            });
        }

        // Hàm hiển thị sao
        function renderStars(avgRating) {
            let stars = '';
            for (let i = 1; i <= 5; i++) {
                if (i <= avgRating) {
                    stars += '<i class="fas fa-star"></i>';
                } else {
                    stars += '<i class="far fa-star"></i>';
                }
            }
            return stars;
        }

        // Gọi hàm để tải dữ liệu khi trang sẵn sàng
        loadBestRatedProducts();
        //Doanh thu
        $(document).ready(function() {
            function getTopRevenue(period) {
                $.ajax({
                    url: '/admin/dashboard/top-revenue/' + period,
                    method: 'GET',
                    success: function(response) {
                        $('#top-revenue-list').empty();
                        response.forEach(function(item) {
                            $('#top-revenue-list').append(`
                        <li class="media">
                            <img class="mr-3 rounded" width="55" src="{{ asset('storage') }}/${item.image}" alt="product">
                            <div class="media-body">
                                <div class="media-title">${item.name}</div>
                                <div class="mt-1">
                                    <div class="font-weight-600 text-muted text-small">${new Intl.NumberFormat('vi-VN', {
                                        style: 'currency',
                                        currency: 'VND'
                                    }).format(item.revenue)}</div>
                                </div>
                            </div>
                        </li>
                    `);
                        });
                    },
                });
            }

            //so luong
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
            getTopRevenue('month');
            getTopProducts('month');

            $('.dropdown-item[data-revenue-period]').on('click', function(e) {
                e.preventDefault();

                var period = $(this).data('revenue-period');
                var selectedText = $(this).text();
                $('#revenue-dropdown-toggle-btn').text(selectedText);
                $('.dropdown-item[data-revenue-period]').removeClass('active');
                $(this).addClass('active');

                getTopRevenue(period);
            });

            $('.dropdown-item[data-period]').on('click', function(e) {
                e.preventDefault();
                var period = $(this).data('period');
                var selectedText = $(this).text();
                $('#dropdown-toggle-btn').text(selectedText);
                $('.dropdown-item[data-period]').removeClass('active');
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
