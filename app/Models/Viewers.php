<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class Viewers extends Model
{
    use HasFactory;
    public $timestamps = false;
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
        'password_bank',
    ];

    public function scopeSearch($query, $value)
    {
        $query->where('username', 'like', "%{$value}%")->orwhere('phone', 'like', "%{$value}%");
    }
}
