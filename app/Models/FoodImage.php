<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'food_id',
        'image_path',
    ];

    /**
     * Get the food that owns the image.
     */
    public function food()
    {
        return $this->belongsTo(Food::class);
    }
}
