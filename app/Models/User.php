<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get meals created by this user.
     */
    public function meals(): HasMany
    {
        return $this->hasMany(Meal::class);
    }

    /**
     * Get meals favorited by this user.
     */
    public function favoriteMeals(): BelongsToMany
    {
        return $this->belongsToMany(Meal::class, 'user_favorites', 'user_id', 'meal_id')
            ->wherePivot('type', 'favorite')
            ->withTimestamps();
    }

    /**
     * Get meals saved by this user.
     */
    public function savedMeals(): BelongsToMany
    {
        return $this->belongsToMany(Meal::class, 'user_favorites', 'user_id', 'meal_id')
            ->wherePivot('type', 'saved')
            ->withTimestamps();
    }

    /**
     * Get all favorited/saved meals by this user.
     */
    public function allFavoritedMeals(): BelongsToMany
    {
        return $this->belongsToMany(Meal::class, 'user_favorites', 'user_id', 'meal_id')
            ->withPivot('type')
            ->withTimestamps();
    }
}
