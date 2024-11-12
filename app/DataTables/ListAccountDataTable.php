<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ListAccountDataTable extends DataTable
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
                if (auth()->user()->can('edit-accounts') && (auth()->user()->hasAnyRole(['admin', 'super_admin']) || !$query->hasAnyRole(['admin', 'super_admin']))) {
                    $editBtn = "<a class='btn btn-primary' href='" . route('admin.accounts.edit', $query->id) . "'><i class='far fa-edit'></i></a>";
                }
                if (auth()->user()->can('delete-accounts') && (auth()->user()->hasAnyRole(['admin', 'super_admin']) || !$query->hasAnyRole(['admin', 'super_admin']))) {
                    $deleteBtn = "<a class='btn btn-danger delete-item ml-2' href='" . route('admin.accounts.destroy', $query->id) . "'><i class='far fa-trash-alt'></i></a>";
                }
                return $editBtn . $deleteBtn;
            })
            ->addColumn('status', function ($query) {
                if (auth()->user()->can('edit-accounts') && (auth()->user()->hasAnyRole(['admin', 'super_admin']) || !$query->hasAnyRole(['admin', 'super_admin']))) {
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
            // ->addColumn('role', function ($query) {
            //     if ($query->role_id == 1) {
            //         return "Super Admin";
            //     } elseif ($query->role_id == 2) {
            //         return "Admin";
            //     } elseif ($query->role_id == 3) {
            //         return "Staff";
            //     } elseif ($query->role_id == 3) {
            //         return "User";
            //     }

            // })
            ->rawColumns(['action', 'status'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(User $model): QueryBuilder
    {
        return $model->with(['role'])->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('listaccount-table')
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
            Column::make('id'),
            Column::make('name'),
            Column::make('email'),
            Column::make('role_id')->title('Role')->data('role.name'),
            Column::make('status')->width(150),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'ListAccount_' . date('YmdHis');
    }
}
