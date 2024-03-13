<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function products(){
        return $this->hasMany(Product::class, 'category_id');
    }

    public function scopeSearch(Builder $query, $search)
    {
        return $query->where('name', 'LIKE', "%{$search}%");
    }
}
