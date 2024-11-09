<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.add-to-cart-simple').on('click', function(e) {
            e.preventDefault();
            let form = $(this).closest('.shopping-cart-form');
            let formData = form.serialize();
            console.log(formData);

            $.ajax({
                url: "{{ route('add-to-cart') }}",
                method: 'POST',
                data: {
                    formData: formData,
                },
                success: function(data) {
                    if (data.status === 'success') {
                        getCartCount();
                        fetchSidebarCartProducts();
                        $('.dropdown-cart-total').removeClass('d-none');
                        $('.dropdown-cart-action').removeClass('d-none');
                        toastr.success(data.message);
                    } else if (data.status === 'error') {
                        toastr.error(data.message);
                    }
                },
                error: function(data) {

                },
            })
        })

        $('#add-to-cart').on('submit', function(e) {
            e.preventDefault();
            if (!checkSelectOptions()) {
                toastr.error('Vui lòng chọn biến thể sản phẩm');
                return false;
            }

            // Đối tượng để lưu trữ các tùy chọn đã chọn
            let selectedOptions = {};

            // Lấy tất cả các tùy chọn đã chọn
            $('.product-single-filter a.selected').each(function() {
                const attribute = $(this).data('attribute'); // Lấy tên thuộc tính (color, size)
                const value = $(this).data('value'); // Lấy giá trị của thuộc tính

                // Cập nhật vào đối tượng selectedOptions
                selectedOptions[attribute] = value;
            });
            let formData = $(this).serialize();
            $.ajax({
                url: "{{ route('add-to-cart') }}",
                method: 'POST',
                data: {
                    formData: formData,
                    variants: selectedOptions,
                },
                success: function(data) {
                    if (data.status === 'success') {
                        getCartCount();
                        fetchSidebarCartProducts();
                        $('.dropdown-cart-total').removeClass('d-none');
                        $('.dropdown-cart-action').removeClass('d-none');
                        toastr.success(data.message);
                    } else if (data.status === 'error') {
                        toastr.error(data.message);
                    }
                },
                error: function(data) {

                },
            })


            // In ra kết quả
            console.log(selectedOptions);
        })

        function checkSelectOptions() {
            let totalFilter = $('.product-single-filter').length - 1;
            let selectedCount = $('.product-single-filter a.selected').length;

            return totalFilter === selectedCount;
        }

        // Get Count Cart
        function getCartCount() {
            $.ajax({
                method: 'GET',
                url: "{{ route('cart-count') }}",
                success: function(data) {
                    $('.cart-count').text(data);
                },
                error: function(data) {

                }
            })
        }

        // Get Cart Products
        function fetchSidebarCartProducts() {
            $.ajax({
                method: 'GET',
                url: "{{ route('cart-products') }}",
                success: function(data) {
                    $('.dropdown-cart-products').html("");
                    var html = '';
                    for (let item in data) {
                        let product = data[item];
                        // Chuyển đổi variants thành mảng nếu cần thiết
                        let variants = product.options.variants;
                        let variantsDisplay = '';

                        // Kiểm tra xem variants có phải là một mảng không
                        if (Array.isArray(variants)) {
                            variantsDisplay = variants.join(' - ');
                        } else if (typeof variants === 'object') {
                            // Nếu là đối tượng, chuyển đổi thành mảng
                            variantsDisplay = Object.entries(variants).map(([key, value]) =>
                                `${value}`).join(' - ');
                        }

                        html += `
                            <div class="product item-${item}">
                                <div class="product-details">
                                    <h4 class="product-title">
                                        <a href="{{ url('product.detail', ['slug' => '${product.options.slug}']) }}">
                                            ${product.name}
                                             ${variantsDisplay ? ' (' + variantsDisplay + ')' : ''}
                                        </a>
                                    </h4>
                                    <span class="cart-product-info">
                                        <span class="cart-product-qty">${product.qty}</span> ×
                                        ${new Intl.NumberFormat().format(product.price)} VND
                                    </span>
                                </div>
                                <!-- End .product-details -->

                                <figure class="product-image-container">
                                    <a href="{{ url('product.detail', ['slug' => '${product.options.slug}']) }}"
                                    class="product-image">
                                        <img src="{{ Storage::url('') }}${product.options.image}"
                                            alt="${product.name}" width="80" height="80">
                                    </a>

                                    <a href="" data-id="${item}"
                                    class="remove_sidebar_product btn-remove"
                                    title="Remove Product"><span>×</span></a>
                                </figure>
                            </div>
                            `;
                    }
                    $('.dropdown-cart-products').html(html);
                    getSidebarCartSubtotal();
                },
                error: function(error) {

                }
            })
        }

        //  get sidebar cart subtotal
        function getSidebarCartSubtotal() {
            $.ajax({
                method: 'GET',
                url: "{{ route('cart.product-total') }}",
                success: function(data) {
                    $('.cart-total-price').text(data + ' VND')
                },
                error: function(data) {

                }
            })
        }

        $(document).on('click', '.remove_sidebar_product', function(e) {
            e.preventDefault();
            let cartKey = $(this).data('id');

            $.ajax({
                method: 'POST',
                data: {
                    cartKey: cartKey,
                },
                url: "{{ route('cart.remove-sidebar-product') }}",
                success: function(data) {
                    $(`.item-${cartKey}`).remove();
                    getSidebarCartSubtotal();
                    getCartCount();
                    if ($('.dropdown-cart-products').find('.product').length === 0) {
                        $('.dropdown-cart-products').html(
                            '<li class="text-center" style="font-size: 25px;padding: 10px;color: darkgrey;">Cart Is Empty!</li>'
                        )
                        $('.dropdown-cart-total').addClass('d-none');
                        $('.dropdown-cart-action').addClass('d-none');
                    }
                },
                error: function(data) {

                }
            })
        })

        // Toggle notification dropdown
        $('.notification-icon').on('click', function(event) {
            $('#notification-dropdown').toggle();
            $('#login-dropdown').hide(); // Ẩn dropdown login nếu đang mở
            event.stopPropagation();
        });

        // Toggle login dropdown
        $('.login-icon').on('click', function(event) {
            $('#login-dropdown').toggle();
            $('#notification-dropdown').hide(); // Ẩn dropdown notification nếu đang mở
            event.stopPropagation();
        });

        // Đóng tất cả dropdown khi click bên ngoài
        $(document).on('click', function(event) {
            if (!$(event.target).closest('#notification-dropdown').length && !$(event.target).closest(
                    '.notification-icon').length) {
                $('#notification-dropdown').hide();
            }
            if (!$(event.target).closest('#login-dropdown').length && !$(event.target).closest(
                    '.login-icon').length) {
                $('#login-dropdown').hide();
            }
        });

    });
</script>
