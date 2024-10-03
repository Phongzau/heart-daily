<?php

namespace App\DataTables;

use App\Models\Attribute;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AttributeDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('status', function ($query) {
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
            })
            ->addColumn('userid_created', function ($query) {
                return $query->creator ? $query->creator->name : 'N/A';
            })
            ->addColumn('userid_updated', function ($query) {
                return $query->updater ? $query->updater->name : 'N/A';
            })
            ->addColumn('action', function ($row) {
                return '
                <a href="' . route('admin.attributes.edit', $row->id) . '" class="btn btn-primary"><i class="far fa-edit"></i></a>
                <a href="' . route('admin.attributes.destroy', $row->id) . '" class="btn btn-danger delete-item"><i class="far fa-trash-alt"></i></a>';
            })
            ->rawColumns(['action', 'status'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Attribute $model): QueryBuilder
    {
        return $model->with(['categoryAttribute'])->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('attribute-table')
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
            Column::make('id'),
            Column::make('title'),
            Column::make('slug'),
            Column::make('category_attribute_id')->title('Category')->data('category_attribute.title'),
            Column::make('price_start'),
            Column::make('price_end'),
            Column::make('status'),
            Column::make('userid_created')->title('Created By'),
            Column::make('userid_updated')->title('Updated By'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(105)
                ->addClass('text-center'),

        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Attribute_' . date('YmdHis');
    }
}
