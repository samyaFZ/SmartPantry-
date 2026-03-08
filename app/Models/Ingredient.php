<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ingredient extends Model
{
    protected $fillable = ['name'];

    /**
     * Get all meals that use this ingredient.
     */
    public function meals(): BelongsToMany
    {
        return $this->belongsToMany(Meal::class, 'meal_ingredients');
    }
}
