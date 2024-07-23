<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_photo',
        
        'subscriptions', // Agrega este campo
    ];
    public function subscriptions()
{
    return $this->belongsToMany(User::class, 'subscriptions', 'user_id', 'subscribed_user_id');
}
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function subscribeTo($userId)
    {
        $subscriptions = $this->subscriptions ?? [];
        if (!in_array($userId, $subscriptions)) {
            $subscriptions[] = $userId;
            $this->subscriptions = $subscriptions;
            $this->save();
        }
    }
    public function unsubscribeFrom($userId)
    {
        $subscriptions = $this->subscriptions ?? [];
        if (($key = array_search($userId, $subscriptions)) !== false) {
            unset($subscriptions[$key]);
            $this->subscriptions = array_values($subscriptions);
            $this->save();
        }
    }
    public function isSubscribedTo($userId)
    {
        return in_array($userId, $this->subscriptions ?? []);
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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
            'subscriptions' => 'array',
        ];
    }
}
