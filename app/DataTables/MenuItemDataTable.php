<?php

namespace App\DataTables;

use App\Models\MenuItem;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class MenuItemDataTable extends DataTable
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
                if (auth()->user()->can('edit-menu-items')) {
                    $editBtn = "<a class='btn btn-primary' href='" . route('admin.menu_items.edit', $query->id) . "'><i class='far fa-edit'></i></a>";
                }
                if (auth()->user()->can('delete-menu-items')) {
                    $deleteBtn = "<a class='btn btn-danger delete-item ml-2' href='" . route('admin.menu_items.destroy', $query->id) . "'><i class='far fa-trash-alt'></i></a>";
                }
                return $editBtn . $deleteBtn;
            })
            ->addColumn('status', function ($query) {
                if (auth()->user()->can('edit-menu-items')) {
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
            ->addColumn('parent_name', function ($query) {
                return $query->parentId ? $query->parentId->title : 'Danh mục cha';
            })
            ->addColumn('menu_name', function ($query) {
                return $query->menu ? $query->menu->title : 'N/A';
            })

            ->rawColumns(['action', 'status'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(MenuItem $model): QueryBuilder
    {
        return $model::with(['parent', 'menu'])->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('menuitem-table')
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
            Column::make('id')->title('ID')->width(100),
            Column::make('title')->title('Tiêu đề')->width(200),
            Column::make('parent_name')->title('Tên danh mục')->width(200),
            Column::make('order')->title('Vị trí')->width(150),
            Column::make('url')->title('Đường dẫn')->width(150),
            Column::make('menu_name')->title('Tên menu')->width(150),
            Column::make('status')->title('Trạng thái')->width(150),
            Column::make('userid_created')->title('Người thêm')->width(150),
            Column::make('userid_updated')->title('Người cập nhật')->width(150),
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
        return 'MenuItem_' . date('YmdHis');
    }
}
