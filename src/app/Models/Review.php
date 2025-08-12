<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_id',
        'reviewer_id',
        'reviewed_id',
        'rating'
    ];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }
}
