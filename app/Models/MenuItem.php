<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;
    public function parentId()
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    public function menu()
{
    return $this->belongsTo(Menu::class);
}
}
