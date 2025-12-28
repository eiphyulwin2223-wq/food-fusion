<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rating';

    protected $fillable = [
        'food_id',
        'user_id',
        'rating',
        'comment',
    ];

    /**
     * Get the food that owns the rating.
     */
    public function food()
    {
        return $this->belongsTo(Food::class);
    }

    /**
     * Get the user that owns the rating.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
