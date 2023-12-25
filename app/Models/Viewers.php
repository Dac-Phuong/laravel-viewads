<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Permissions\HasPermissionsTrait;

class Viewers extends Authenticatable implements JWTSubject
{

    use HasFactory, Notifiable, HasPermissionsTrait;
    public $timestamps = true;
    protected $connection = 'mongodb';
    protected $collection = 'viewers';

    protected $fillable = [
        'username',
        'email',
        'phone',
        'account_name',
        'account_number',
        'code',
        'password',
        'level_id',
        'presenter_id',
        'password_bank',
    ];
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    public function scopeSearch($query, $value)
    {
        $query->where('username', 'like', "%{$value}%")->orwhere('phone', 'like', "%{$value}%");
    }
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
    public function level()
    {
        return $this->belongsTo(Level::class);
    }
}
