import "./bootstrap";
// Import Toastr CSS và JS
import "toastr/build/toastr.min.css";
import toastr from "toastr";

// Khởi tạo Toastr
window.toastr = toastr;
Echo.channel("user-status").listen("UserStatusChanged", (event) => {
    console.log(`User ${event.user_id} is now ${event.status}`);

    let userElement = document.getElementById("user-" + event.user_id);
    if (userElement) {
        let badgeDot = userElement.querySelector(".badge-dot");
        if (event.status === "online") {
            if (badgeDot) badgeDot.style.display = "block"; // Hiển thị trạng thái online
        } else {
            if (badgeDot) badgeDot.style.display = "none"; // Ẩn trạng thái offline
        }
    }
});


document.addEventListener("DOMContentLoaded", function () {
    if (window.userId) {
        console.log(window.userId); // Kiểm tra ID người dùng có được gán chưa
        window.Echo.private(`user.${window.userId}`)
            .listen("CheckoutOrderComplete", (event) => {
                toastr.options = {
                    closeButton: true, // Hiển thị nút đóng
                    debug: false,
                    newestOnTop: false,
                    progressBar: true, // Hiển thị thanh tiến trình
                    positionClass: "toast-top-right", // Vị trí thông báo
                    preventDuplicates: true, // Ngăn chặn trùng lặp thông báo
                    onclick: function () {
                        // Đóng toastr khi người dùng click vào thông báo
                        toastr.clear();
                    },
                    showDuration: "300", // Thời gian hiện thông báo
                    hideDuration: "1000", // Thời gian ẩn thông báo
                    timeOut: "0", // Không tự động ẩn thông báo
                    extendedTimeOut: "0", // Không tự động ẩn thông báo khi hover
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn", // Hiệu ứng khi hiển thị thông báo
                    hideMethod: "fadeOut", // Hiệu ứng khi ẩn thông báo
                };
                toastr.success("Bạn có thông báo mới");
                toastr.success(`Có đơn hàng mới được đặt`);
                Livewire.dispatch("refreshAdminNotifications");
            })
            .listen("CouponCreated", (event) => {
                console.log(event);

                toastr.options = {
                    closeButton: true, // Hiển thị nút đóng
                    debug: false,
                    newestOnTop: false,
                    progressBar: true, // Hiển thị thanh tiến trình
                    positionClass: "toast-top-right", // Vị trí thông báo
                    preventDuplicates: true, // Ngăn chặn trùng lặp thông báo
                    onclick: function () {
                        // Đóng toastr khi người dùng click vào thông báo
                        toastr.clear();
                    },
                    showDuration: "300", // Thời gian hiện thông báo
                    hideDuration: "1000", // Thời gian ẩn thông báo
                    timeOut: "0", // Không tự động ẩn thông báo
                    extendedTimeOut: "0", // Không tự động ẩn thông báo khi hover
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn", // Hiệu ứng khi hiển thị thông báo
                    hideMethod: "fadeOut", // Hiệu ứng khi ẩn thông báo
                };
                let discount;
                if (event.coupon.discount_type == "percent") {
                    discount = event.coupon.discount + "%";
                } else if (event.coupon.discount_type == "amount") {
                    discount =
                        new Intl.NumberFormat().format(event.coupon.discount) +
                        " VND";
                }
                console.log(discount, event.coupon.discount_type);

                toastr.info(
                    `Có 1 mã giảm giá mới cho bạn ${event.coupon.name} với giá trị ${discount}`
                );
                // Gọi lại Livewire để refresh component
                Livewire.dispatch("refreshNotifications");
                Livewire.dispatch("refreshCouponList");
                toastr.info(`Bạn có một thông báo mới`);
            })
            .listen("ChangeStatusOrder", (event) => {
                toastr.options = {
                    closeButton: true, // Hiển thị nút đóng
                    debug: false,
                    newestOnTop: false,
                    progressBar: true, // Hiển thị thanh tiến trình
                    positionClass: "toast-top-right", // Vị trí thông báo
                    preventDuplicates: true, // Ngăn chặn trùng lặp thông báo
                    onclick: function () {
                        // Đóng toastr khi người dùng click vào thông báo
                        toastr.clear();
                    },
                    showDuration: "300", // Thời gian hiện thông báo
                    hideDuration: "1000", // Thời gian ẩn thông báo
                    timeOut: "0", // Không tự động ẩn thông báo
                    extendedTimeOut: "0", // Không tự động ẩn thông báo khi hover
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn", // Hiệu ứng khi hiển thị thông báo
                    hideMethod: "fadeOut", // Hiệu ứng khi ẩn thông báo
                };
                toastr.success("Bạn có thông báo mới");
                if (event.order.order_status == "return") {
                    toastr.success("Bạn có một yêu cầu hoàn hàng");
                }
                Livewire.dispatch("refreshAdminNotifications");
                Livewire.dispatch("refreshNotifications");
            })
            .error((error) => {
                console.error("Error with Echo connection:", error);
                toastr.error("Lỗi kết nối với WebSocket");
            });
    } else {
        console.log("User is not logged in");
    }
});
