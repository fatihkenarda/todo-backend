<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Todo extends Model
{
      use SoftDeletes;

    // Toplu atama için izin verilen alanlar
    protected $fillable = [
        'title',
        'description',
        'status',
        'priority',
        'due_date',
    ];

    // Todo'nun birden fazla kategoriyle ilişkisi
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_todo', 'todo_id', 'category_id');
    }
}
