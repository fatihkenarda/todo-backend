<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
     // Toplu atama için izin verilen alanlar
    protected $fillable = [
        'name',
        'color',
    ];

    // Category'nin birden fazla todo ile ilişkisi
    public function todos()
    {
        return $this->belongsToMany(Todo::class, 'category_todo', 'category_id', 'todo_id');
    }
}
