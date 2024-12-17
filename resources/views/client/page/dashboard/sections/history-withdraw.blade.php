@if ($withDraws->isEmpty())
    <div class="text-center" style="margin: 5px;">
        <h3 style="color:rgba(138, 138, 135, 0.878);">Không có yêu cầu nào !!</h3>
    </div>
@else
    @foreach ($withDraws as $withDraw)
        <div class="card mb-3 border-0 shadow-sm"
            style="border-top: 4px solid
                @if ($withDraw->status == 'processing') #ffc107
                @elseif ($withDraw->status == 'rejected')
                #dc3545
                @elseif ($withDraw->status == 'complete')
                #28a745 @endif
                !important;">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fw-bold mb-1">{{ $withDraw->created_at->format('d/m/Y H:i') }}</h6>
                    <p class="mb-0 text-muted">Số tiền:
                        <strong>{{ number_format($withDraw->equivalent_money) }}{{ $generalSettings->currency_icon }}
                        </strong>
                    </p>
                    <p class="mb-0 text-muted">Số dư cuối:
                        <strong>{{ number_format($withDraw->final_balance) }}{{ $generalSettings->currency_icon }}
                        </strong>
                    </p>
                </div>
                <div>
                    <span style="font-size:14px"
                        class="badge
                    @if ($withDraw->status == 'complete') bg-success text-light
                    @elseif($withDraw->status == 'processing')
                        bg-warning text-light
                    @elseif($withDraw->status == 'rejected')
                        bg-danger text-light @endif
                     px-3 py-2">
                        @if ($withDraw->status == 'complete')
                            Thành công
                        @elseif($withDraw->status == 'processing')
                            Đang xử lý
                        @elseif($withDraw->status == 'rejected')
                            Thất bại
                        @endif
                        <!-- Thêm nút "Xem chi tiết" dưới trạng thái -->
                    </span>
                    <div class="mt-2">
                        <btn style="font-size: 11px;
                            width: 100%; border-radius: 3px;"
                            data-withdraw-id="{{ $withDraw->id }}" id="myBtnWithdraw" class="btn btn-success btn-sm">Xem
                            chi tiết
                        </btn>
                    </div>
                </div>


            </div>

        </div>
    @endforeach
    <!-- End .row -->
    <nav class="toolbox toolbox-pagination">
        <div class="toolbox-item toolbox-show"></div>
        <ul class="pagination pagination-text pagination-withdraw toolbox-item" data-source='withdraw'
            id="pagination-links">
            {{ $withDraws->appends(request()->query())->links() }}
        </ul>
    </nav>
@endif
