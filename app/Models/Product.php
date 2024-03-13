<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'category_id'];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function scopePriceGreaterThan($query, $price){
        return $query->where('price', '>', $price);
    }

    public function scopeSearch(Builder $query, $search)
    {
        $columns = ['name', 'price'];

        return $query->where(function ($query) use ($columns, $search) {
            foreach ($columns as $column) {
                $query->orWhere($column, 'LIKE', "%{$search}%");
            }
        });
    }
}
