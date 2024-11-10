<?php

namespace App\DataTables;

use App\Models\ProductReview;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProductReviewDataTable extends DataTable
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
                $deleteBtn = '';
                if (auth()->user()->can('delete-reviews')) {
                    $deleteBtn = "<a class='btn btn-danger delete-item ml-2' href='" . route('admin.product_reviews.destroy', $query->id) . "'><i class='far fa-trash-alt'></i></a>";
                }
                return $deleteBtn;
            })
            ->addColumn('user_name', function ($query) {
                return $query->user->name;
            })
            ->addColumn('product_name', function ($query) {
                // return "<a href='" . route('product.product-details', ['slug' => $query->product->slug]) . "' target='_blank'>" . $query->product->name . "</a>";
                return $query->product->name;
            })

            ->addColumn('user_review', function ($query) {
                return $query->comment;
            })
            ->rawColumns(['product_name', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ProductReview $model): QueryBuilder
    {
        return $model::with(['user', 'product'])->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('ProductReview-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(1)
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

            Column::make('id')->width(100),
            Column::make('product_name')->width(250),
            Column::make('user_name')->width(150),
            Column::make('review')->width(300),
            Column::computed('action')
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
        return 'ProductReview' . date('YmdHis');
    }
}
