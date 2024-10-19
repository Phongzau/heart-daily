<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;

    // Relationship with parent menu item
    public function parent()
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    // Relationship with child menu items
    public function children()
    {
        return $this->hasMany(MenuItem::class, 'parent_id');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}

