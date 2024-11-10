<?php

namespace App\DataTables;

use App\Models\Coupon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CouponDataTable extends DataTable
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
                $editBtn = '';
                $deleteBtn = '';
                if (auth()->user()->can('edit-coupons')) {
                    $editBtn = "<a class='btn btn-primary' href='" . route('admin.coupons.edit', $query->id) . "'><i class='far fa-edit'></i></a>";
                }
                if (auth()->user()->can('delete-coupons')) {
                    $deleteBtn = "<a class='btn btn-danger delete-item' href='" . route('admin.coupons.destroy', $query->id) . "' ><i class='far fa-trash-alt'></i></a>";
                }
                return $editBtn . $deleteBtn;
            })
            ->addColumn('status', function ($query) {
                if (auth()->user()->can('edit-coupons')) {
                    if ($query->status == 1) {
                        $button = "<label class='custom-switch mt-2'>
                        <input type='checkbox' data-id='" . $query->id . "' checked name='custom-switch-checkbox' class='custom-switch-input change-status'>
                        <span class='custom-switch-indicator'></span>
                      </label>";
                    } else {
                        $button = "<label class='custom-switch mt-2'>
                        <input type='checkbox' data-id='" . $query->id . "' name='custom-switch-checkbox' class='custom-switch-input change-status'>
                        <span class='custom-switch-indicator'></span>
                      </label>";
                    }
                    return $button;
                }
                return $query->status == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
            })
            ->addColumn('discount', function ($query) {
                if ($query->discount_type === 'percent') {
                    return $query->discount . '%';
                } else {
                    return number_format($query->discount) . ' VND';
                }
            })
            ->addColumn('min_order_value', function ($query) {
                return number_format($query->min_order_value) . ' VND';
            })
            ->rawColumns(['action', 'status'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Coupon $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('coupon-table')
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
            Column::make('id')->width(60),
            Column::make('name')->width(200),
            Column::make('code')->width(130),
            Column::make('discount_type')->width(200),
            Column::make('discount')->width(200),
            Column::make('min_order_value')->width(200),
            Column::make('total_used')->width(150),
            Column::make('start_date')->width(200),
            Column::make('end_date')->width(200),
            Column::make('status')->width(130),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(200)
                ->addClass('text-center')
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Coupon_' . date('YmdHis');
    }
}
