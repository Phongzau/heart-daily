<div class="tab-pane fade" id="order" role="tabpanel">
    <div class="filter-section">
        <label for="status">Trạng thái:</label>
        <select style="margin-left: 5px;" id="status" name="status">
            <option value="">Tất cả</option>
            <option value="pending">Đang chờ xác nhận</option>
            <option value="processed_and_ready_to_ship">Đơn hàng đã đóng gói</option>
            <option value="dropped_off">Đơn hàng đã giao cho đơn vị vận chuyển</option>
            <option value="shipped">Đang giao</option>
            <option value="delivered">Đã giao</option>
            <option value="canceled">Đã hủy</option>
        </select>

        <label for="from_date">Từ ngày:</label>
        <input type="date" id="from_date" name="from_date">

        <label for="to_date">Đến ngày:</label>
        <input type="date" id="to_date" name="to_date">
        <div class="button-container">
            <button type="button" id="btn-search-order">Tìm kiếm</button>
        </div>
    </div>
    <div id="order-list">
        @include('client.page.dashboard.sections.order-list', ['orders' => $orders])
    </div>
</div><!-- End .tab-pane -->
