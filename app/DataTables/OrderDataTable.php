<?php

namespace App\DataTables;

use Carbon\Carbon;
use App\Models\Order;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class OrderDataTable extends DataTable
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
                $showBtn = '';
                $deleteBtn = '';
                if (auth()->user()->can('edit-orders')) {
                    $showBtn = "<a class='btn btn-primary' href='" . route('admin.orders.show', $query->id) . "'><i class='far fa-eye'></i></a>";
                }
                if (auth()->user()->can('delete-orders')) {
                    if ($query->order_status == 'canceled' || $query->order_status == 'return' || $query->order_status == 'delivered') {
                        $deleteBtn = "<a class='btn btn-danger delete-item ml-2' href='" . route('admin.orders.destroy', $query->id) . "'><i class='far fa-trash-alt'></i></a>";
                    } else {
                        $deleteBtn = "<a class='disabled-link btn btn-secondary delete-item ml-2'><i class='far fa-trash-alt'></i></a>";
                    }
                    // $statusBtn = "<a class='btn btn-warning ml-2' href='" . route('admin.products.edit', $query->id) . "'><i class='fas fa-truck'></i></a>";
                }
                return $showBtn . $deleteBtn; //. $statusBtn
            })
            ->filter(function ($query) {
                $query->whereNull('deleted_at');
            })
            ->addColumn('customer', function ($query) {
                return $query->user->name;
            })
            ->addColumn('amount', function ($query) {
                $generalSettings = app('generalSettings');
                return number_format($query->amount) . $generalSettings->currency_icon;
            })
            ->addColumn('date', function ($query) {
                Carbon::setLocale('vi'); // Đặt ngôn ngữ là tiếng Việt
                return Carbon::parse($query->created_at)->translatedFormat('d F, Y'); // Ví dụ: 12 Tháng Mười Hai, 2024

            })
            ->addColumn('payment_status', function ($query) {
                if ($query->payment_status == 1) {
                    return "<span class='badge bg-success'>Hoàn thành</span>";
                } else {
                    return "<span class='badge bg-warning'>Chưa xử lý</span>";
                }
            })
            ->addColumn('order_status', function ($query) {
                switch ($query->order_status) {
                    case 'pending':
                        return "<span class='badge bg-warning'>Chưa xử lý</span>";
                        break;
                    case 'processed_and_ready_to_ship':
                        return "<span class='badge bg-info'>Đã xử lý</span>";
                        break;
                    case 'dropped_off':
                        return "<span class='badge bg-info'>Đã giao cho đơn vị vận chuyển</span>";
                        break;
                    case 'shipped':
                        return "<span class='badge bg-warning'>Đã vận chuyển</span>";
                        break;
                    case 'out_for_delivery':
                        return "<span class='badge bg-primary'>Đang giao</span>";
                        break;
                    case 'delivered':
                        return "<span class='badge bg-success'>Đã giao hàng</span>";
                        break;
                    case 'return':
                        return "<span class='badge bg-secondary '>Trả hàng</span>";
                        break;
                    case 'canceled':
                        return "<span class='badge bg-danger'>Hủy bỏ</span>";
                        break;
                    default:
                        # code...
                        break;
                };
            })
            ->rawColumns(['action', 'order_status', 'payment_status'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Order $model): QueryBuilder
    {
        $query = $model->newQuery();

        // Lọc theo trạng thái đơn hàng
        if (request()->has('order_status') && request()->order_status != '') {
            $query->where('order_status', request()->order_status);
        }

        // Lọc theo trạng thái thanh toán
        if (request()->has('payment_status') && request()->payment_status != '') {
            $query->where('payment_status', request()->payment_status);
        }

        // Lọc theo ngày bắt đầu
        if (request()->has('start_date') && request()->start_date != '') {
            $query->whereDate('created_at', '>=', request()->start_date);
        }

        // Lọc theo ngày kết thúc
        if (request()->has('end_date') && request()->end_date != '') {
            $query->whereDate('created_at', '<=', request()->end_date);
        }

        return $query;
    }


    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('order-table')
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
            Column::make('invoice_id')->title('ID hóa đơn'),
            Column::make('customer')->title('Khách hàng')->width(150),
            Column::make('date')->title('Ngày đặt'),
            Column::make('product_qty')->title('Số lượng'),
            Column::make('amount')->title('Số tiền'),
            Column::make('order_status')->title('Trạng thái đơn'),
            Column::make('payment_status')->title('Trạng thái thanh toán'),
            Column::make('payment_method')->title('Phương thức thanh toán')->width(180),
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
        return 'Order_' . date('YmdHis');
    }
}
