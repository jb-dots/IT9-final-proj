<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
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
        'contact_no',
        'address',
        'profile_picture',
        'role', // Added for admin/user differentiation
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
     * Get the borrowed books for the user.
     */
    public function borrowedBooks()
    {
        return $this->hasMany(BorrowedBook::class);
    }
    
    /**
     * Get the transactions for the user.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
    
    /**
     * Check if the user is an admin.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Get the ratings for the user.
     */
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    protected static function booted()
    {
        static::creating(function ($user) {
            if (empty($user->membership_id)) {
                // Get max numeric part of membership_id
                $maxId = static::whereNotNull('membership_id')
                    ->selectRaw('MAX(CAST(SUBSTRING(membership_id, 4) AS UNSIGNED)) as max_id')
                    ->value('max_id');

                $nextId = $maxId ? $maxId + 1 : 1;
                $user->membership_id = 'GA-' . str_pad($nextId, 6, '0', STR_PAD_LEFT);
            }
        });
    }

    public function favorites()
    {
        return $this->belongsToMany(\App\Models\Book::class, 'user_favorites')->withTimestamps();
    }
}
