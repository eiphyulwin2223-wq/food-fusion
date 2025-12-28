<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ingredient';

    protected $fillable = [
        'food_id',
        'name',
        'quantity',
    ];

    /**
     * Get the food that owns the ingredient.
     */
    public function food()
    {
        return $this->belongsTo(Food::class);
    }
}
