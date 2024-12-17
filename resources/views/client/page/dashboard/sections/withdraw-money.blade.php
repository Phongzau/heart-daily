<div class="tab-pane fade" id="withdraw" role="tabpanel">
    <!-- Tổng số điểm -->
    <div class="d-flex justify-content-between align-items-center mb-4 bg-light p-3 rounded shadow-sm"
        style="border-top: 5px solid #2299dd;">
        <!-- Icon điểm và số điểm -->
        <div class="d-flex align-items-center" style="padding: 5px 0px 5px 0px;">
            <i class="fas fa-wallet"></i>
            <span style="margin-left: 3px;" class="fs-4 fw-bold text-dark">
                <span data-point="{{ Auth::user()->point }}"
                    id="point_current">{{ number_format(Auth::user()->point) }}</span> điểm <span
                    class="text-secondary">(Tương đương
                    {{ number_format(Auth::user()->point) }}{{ $generalSettings->currency_icon }})</span>
            </span>
        </div>
        <!-- Nút Rút Tiền -->
        <button style="border-radius: 40px;" class="btn btn-primary px-4 py-2 fw-bold" id="withdrawButton">Rút
            Điểm</button>
    </div>

    <!-- Lịch sử rút tiền -->
    <div>
        <h4 class="mb-3">Lịch sử rút điểm</h4>
        <div class="history_wishdraw">
            @include('client.page.dashboard.sections.history-withdraw', ['withDraws' => $withDraws]);
        </div>
        <!-- Giao dịch -->
    </div>
</div><!-- End .tab-pane -->
