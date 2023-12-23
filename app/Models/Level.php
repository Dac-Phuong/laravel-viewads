<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class Level extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $connection = 'mongodb';
    protected $collection = 'levels';

    protected $fillable = [
        'name',
        'joining_fee',
        'time_ads',
        'number_ads',
        'bonus_ads',
    ];
}
