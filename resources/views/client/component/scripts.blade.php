<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        let debounceTimer;

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
                error: function(xhr) {
                    // if (xhr.status === 401) {
                    //     // Chuyển hướng người dùng đến trang đăng nhập
                    //     toastr.warning('Bạn cần đăng nhập để thực hiện điều này.');
                    //     setTimeout(() => {
                    //         window.location.href = '/login';
                    //     }, 1500);
                    // }
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
                error: function(xhr) {
                    // if (xhr.status === 401) {
                    //     // Chuyển hướng người dùng đến trang đăng nhập
                    //     toastr.warning('Bạn cần đăng nhập để thực hiện điều này.');
                    //     setTimeout(() => {
                    //         window.location.href = '/login';
                    //     }, 1500);
                    // }
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
                                        ${new Intl.NumberFormat().format(product.price)}{{ $generalSettings->currency_icon }}
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
                    $('.cart-total-price').text(data + '{{ $generalSettings->currency_icon }}')
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

        $(document).on('keyup', '#search', function() {
            let searchKey = $(this).val();
            if (searchKey == '') {
                $('#searchResults').html(
                    "<div class='text-center' style='padding: 20px; font-size:18px;font-weight:700' >Bạn hãy nhập để tìm kiếm sản phẩm</div>"
                );
                return;
            }
            // Hủy bỏ timer cũ nếu người dùng đang gõ tiếp
            clearTimeout(debounceTimer);

            debounceTimer = setTimeout(function() {
                $.ajax({
                    url: "{{ route('product.get-product-by-search') }}",
                    method: "POST",
                    data: {
                        searchKey: searchKey,
                    },
                    success: function(data) {
                        $('#searchResults').html("");
                        $('#searchResults').removeClass("hidden");

                        if (data.products.length > 0) {
                            data.products.forEach(product => {
                                const productItem = $('<div>');
                                productItem.addClass('result-item');
                                productItem.html(
                                    `
                                    <a href="/product/${product.slug}">
                                        <img src="{{ Storage::url('') }}${product.image}" alt="${product.name}"
                                            style="width: 65px; margin-right: 10px;">
                                        <span>${product.name}</span>
                                    </a>
                                `
                                )
                                $('#searchResults').append(productItem);
                            });
                        } else {
                            $('#searchResults').html(
                                "<div class='text-center' style='padding: 20px; font-size:18px;font-weight:700' >Không tìm thấy sản phẩm</div>"
                            );
                        }
                    },
                    error: function(error) {
                        console.log("ERROR:", error);

                        $('#searchResults').html(
                            "<div class='result-item'>Lỗi tìm kiếm</div>");
                    },
                })
            }, 1000);
        })


        // Ẩn kết quả tìm kiếm khi click ra ngoài
        $(document).on('click', function(e) {
            if (!$(e.target).closest('#search, #searchResults').length) {
                $('#searchResults').addClass('hidden');
            }
        });

        $('#search').on('click', function() {
            if ($('#searchResults').children().length > 0) {
                $('#searchResults').removeClass('hidden');
            }
        });

        $(document).on('click', '.btnQuickView', function(e) {
            e.preventDefault();
            // let idProduct = $(this).data('productid');

            // $.ajax({
            //     url: "{{ route('product.quickview') }}",
            //     method: "POST",
            //     data: {
            //         idProduct,
            //     },
            //     success: function(data) {
            //         if (data.status == "success") {
            //             $('#modal-body-quickview').html(data.updatedQuickViewHtml);
            //         } else if (data.status == "error") {
            //             toastr.error(data.message);
            //         }
            //     },
            //     error: function(error) {

            //     },
            // })

            $('#quickViewModal').fadeIn();
        })

        $(".close").click(function() {
            $("#quickViewModal").fadeOut();
        });

        // var countOptions = $('.product-single-filter').length - 1;

        // // Lấy giá trị của input số lượng và min, max từ thuộc tính của input
        // var $qtyInput = $('input[name="qty"]');
        // var minQty = parseInt($qtyInput.attr('min'));
        // var maxQty = parseInt($qtyInput.attr('max'));

        // $qtyInput.on('change', function() {
        //     var currentQty = parseInt($qtyInput.val());
        //     if (currentQty < minQty) {
        //         $qtyInput.val(minQty);
        //     } else if (currentQty > maxQty) {
        //         $qtyInput.val(maxQty);
        //     }
        // });

        // // Chọn biến thể
        // $(document).on('click', '.select-variant', function() {
        //     let selectedOptions = {};
        //     let currentOptions = $('.product-single-filter a.selected').length;
        //     if (countOptions === currentOptions) {
        //         $('.product-single-filter a.selected').each(function() {
        //             const attribute = $(this).data('attribute');
        //             const value = $(this).data('value');
        //             // Cập nhật vào đối tượng selectedOptions
        //             selectedOptions[attribute] = value;
        //         });
        //         let idPrd = $('.product-single-filter a.selected').data('idproduct');
        //         $.ajax({
        //             url: "{{ route('product.get-qty-variant') }}",
        //             method: 'POST',
        //             data: {
        //                 product_id: idPrd,
        //                 variants: selectedOptions,
        //             },
        //             success: function(data) {

        //                 if (data.status === 'success') {

        //                     const formatCurrency = (value) => {
        //                         return new Intl.NumberFormat('vi-VN', {
        //                                 style: 'decimal', // Không dùng currency để loại bỏ ký hiệu ₫
        //                                 minimumFractionDigits: 0
        //                             }).format(value) +
        //                             "{{ $generalSettings->currency_icon }}"; // Thêm ' VND' vào cuối
        //                     };
        //                     let priceText = '';

        //                     if (data.variant.variant_offer_start_date && data.variant
        //                         .variant_offer_end_date) {
        //                         let currentDate = new Date();
        //                         let startDate = new Date(data.variant
        //                             .variant_offer_start_date);
        //                         let endDate = new Date(data.variant
        //                             .variant_offer_end_date);

        //                         if (startDate <= currentDate && currentDate <= endDate &&
        //                             data.variant.offer_price_variant > 0) {
        //                             priceText =
        //                                 `<span style="margin-right: 10px;">${formatCurrency(data.variant.offer_price_variant)}</span>`;
        //                         } else {
        //                             priceText =
        //                                 `<span>${formatCurrency(data.variant.price_variant)}</span>`;
        //                         }
        //                     } else {
        //                         priceText =
        //                             `<span>${formatCurrency(data.variant.price_variant)}</span>`;
        //                     }

        //                     // if (data.variant.offer_price_variant > 0) {
        //                     //     // Thêm giá khuyến mãi bên cạnh
        //                     //     priceText =
        //                     //         `<span style="margin-right: 10px;">${formatCurrency(data.variant.offer_price_variant)}</span>`;
        //                     //     // priceText +=
        //                     //     //     `<span style="text-decoration: line-through red; color: black;">${formatCurrency(data.variant.price_variant)}</span> `;
        //                     // } else {
        //                     //     priceText =
        //                     //         `<span>${formatCurrency(data.variant.price_variant)}</span>`;
        //                     // }
        //                     $('.price-render').html(priceText);
        //                     $('.qty-product').text(data.variant.qty);
        //                     // Cập nhật thuộc tính max của input số lượng
        //                     $qtyInput.attr('max', data.variant.qty);
        //                     minQty = parseInt($qtyInput.attr('min'));
        //                     maxQty = parseInt($qtyInput.attr('max'));

        //                     // Nếu số lượng hiện tại lớn hơn số lượng tối đa mới, điều chỉnh lại giá trị
        //                     if (parseInt($qtyInput.val()) > data.qty) {
        //                         $qtyInput.val(data.qty);
        //                     }
        //                 }
        //             },
        //             error: function(error) {

        //             },
        //         })
        //     }
        // })

        // // Xử lý sự kiện nhấp vào tùy chọn màu
        // $('.color-options').click(function() {
        //     // Bỏ chọn tất cả các màu trước đó
        //     $('.color-options').removeClass('selected');

        //     $(this).addClass('selected');
        //     // Xóa các kích cỡ hiện tại
        //     var ulElement = $('.size-options').closest('.config-size-list');
        //     if (ulElement) {
        //         var selectedColor = $(this).data('color'); // Lấy màu đã chọn
        //         var availableSizes = variantData[
        //             selectedColor]; // Lấy các kích cỡ tương ứng với màu đã chọn

        //         ulElement.empty();

        //         // Hiển thị các kích cỡ liên quan đến màu đã chọn
        //         if (availableSizes) {
        //             $.each(availableSizes, function(size, qty) {
        //                 var sizeLink = $(
        //                     '<li><a href="javascript:;" class="d-flex select-variant align-items-center justify-content-center size-options" data-size="' +
        //                     size + '" data-attribute="size" data-value="' + size +
        //                     '">' +
        //                     size + '</a></li>'
        //                 );
        //                 // Kiểm tra số lượng
        //                 if (qty <= 0) {
        //                     sizeLink.find('a').addClass('disabled').css('pointer-events',
        //                         'none');;
        //                 }

        //                 ulElement.append(sizeLink);
        //             });
        //         }
        //     }
        // });

        // $('.color-options.default-selected').trigger('click');

        // $('.config-size-list').on('click', 'a', function() {
        //     var ulElement = $(this).closest('.config-size-list');
        //     ulElement.find('a').removeClass('selected');
        //     ulElement.find('li').removeClass('active');
        //     var liElement = $(this).closest('li');
        //     liElement.addClass('active');
        //     $(this).addClass('selected');
        // });

        // Xử lý sự kiện nhấp vào nút Clear
        // $('.clear-btn').click(function() {
        //     $('.color-options').removeClass('selected'); // Xóa class selected nếu cần
        //     console.log("Filters cleared");
        // });


    });
</script>
