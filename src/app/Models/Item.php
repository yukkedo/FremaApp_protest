<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'image',
        'category_id',
        'condition_id',
        'name',
        'brand',
        'description',
        'price',
        'is_purchased'
    ];

    // 1つの商品は1人のユーザーに紐付ける　1対多
    public function users()
    {
        return $this->belongsTo(User::class);
    }

    //　1つの商品は複数のユーザーのいいねを獲得する　多対多
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'item_category', 'item_id', 'category_id');
    }

    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
