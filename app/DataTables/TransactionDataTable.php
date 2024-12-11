<?php

namespace App\DataTables;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class TransactionDataTable extends DataTable
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
                return $query->order->id;
            })
            ->addColumn('amount', function ($query) {
                $generalSettings = app('generalSettings');
                // Kiểm tra phương thức thanh toán
                if ($query->payment_method == 'paypal') {
                    // Nếu là PayPal, định dạng tiền theo USD
                    return '$' . number_format($query->amount_real_currency, 2, '.', ',');
                }

                // Nếu không phải PayPal, định dạng tiền theo VNĐ
                return number_format($query->amount) . $generalSettings->currency_icon;
            })
            ->rawColumns(['action']); // Ensure the action column renders HTML correctly
    }




    /**
     * Get the query source of dataTable.
     */
    public function query(Transaction $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the HTML builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('transaction-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(0, 'desc') // Default order by the first column
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
     * Get the DataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')->title('ID'),
            Column::make('order_id')->title('ID hóa đơn'),
            Column::make('transaction_id')->title('ID giao dịch'),
            Column::make('payment_method')->title('Phương thức thanh toán'),
            Column::make('amount')->title('Số tiền '),
            Column::make('amount_real_currency_name')->title('Tên loại tiền')
                ->exportable(false)
                ->printable(false)
                ->width(150)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Transaction_' . date('YmdHis');
    }
}
