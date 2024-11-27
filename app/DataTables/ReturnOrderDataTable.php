<?php

namespace App\DataTables;

use App\Models\OrderReturn;
use App\Models\ReturnOrder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ReturnOrderDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('order_id', function ($query) {
                return "<a class='' href='" . route('admin.orders.show', $query->order_id) . "'>Order</a>";
            })
            ->addColumn('return_status', function ($query) {
                return "<select class='form-control is_approve' data-id='$query->id'>
                <option " . ($query->return_status == 'pending' ? 'selected' : '') . " value='pending'>Chưa giải quyết</option>
                <option " . ($query->return_status == 'approved' ? 'selected' : '') . " value='approved'>Đã duyệt</option>
                <option " . ($query->return_status == 'rejected' ? 'selected' : '') . " value='rejected'>Từ chối</option>
                <option " . ($query->return_status == 'completed' ? 'selected' : '') . " value='completed'>Thành công</option>
                </select>";
            })
            ->addColumn('video_path', function ($query) {
                return "<button class='btn btn-primary view-video' data-video-path='" . asset(Storage::url($query->video_path)) . "'>Xem Video</button>";
            })
            ->addColumn('refund_amount', function ($query) {
                return number_format($query->refund_amount) . ' VND';
            })
            ->rawColumns(['order_id', 'return_status', 'video_path'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(OrderReturn $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('returnorder-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(0)
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')->title('ID'),
            Column::make('order_id')->title('ID đơn hàng'),
            Column::make('return_reason')->title('Lý do hoàn trả'),
            Column::make('refund_amount')->title('Số tiền hoàn trả'),
            Column::make('video_path')->title('Video'),
            Column::make('return_status')->title('Trạng thái'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'ReturnOrder_' . date('YmdHis');
    }
}
