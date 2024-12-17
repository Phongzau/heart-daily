<?php

namespace App\DataTables;

use App\Models\WithdrawRequest;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class WithdrawRequestDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($query) {
                $showBtn = "<a class='btn btn-primary' href='" . route('admin.withdraws.show', $query->id) . "'><i class='far fa-eye'></i></a>";
                return $showBtn; //. $statusBtn
            })
            ->addColumn('user_id', function ($query) {
                return $query->user->name;
            })
            ->addColumn('point', function ($query) {
                return number_format($query->point);
            })
            ->addColumn('equivalent_money', function ($query) {
                $generalSettings = app('generalSettings');
                return number_format($query->equivalent_money) . $generalSettings->currency_icon;
            })
            ->addColumn('status', function ($query) {
                switch ($query->status) {
                    case 'reject':
                        return '<span class="badge bg-danger">Từ chối</span>';
                    case 'processing':
                        return '<span class="badge bg-warning">Đang xử lý</span>';
                    case 'complete':
                        return '<span class="badge bg-success">Hoàn thành</span>';
                    default:
                        return '<span class="badge bg-secondary">Không xác định</span>';
                }
            })
            ->rawColumns(['user_id', 'action', 'status'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(WithdrawRequest $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('withdrawrequest-table')
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
            Column::make('user_id')->title('Người dùng'),
            Column::make('point')->title('Điểm')->width(150),
            Column::make('equivalent_money')->title('Số tiền tương ứng'),
            Column::make('bank_name')->title('Tên ngân hàng'),
            Column::make('account_name')->title('Tên chủ tài khoản'),
            Column::make('bank_account')->title('Số tài khoản'),
            Column::make('status')->title('Trạng thái '),
            Column::computed('action')->title('Chức năng')
                ->exportable(false)
                ->printable(false)
                ->width(200)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'WithdrawRequest_' . date('YmdHis');
    }
}
