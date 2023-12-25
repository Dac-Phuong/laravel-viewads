<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model ;

class Permission extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $connection = 'mongodb';
    protected $collection = 'permissions';

    protected $fillable = [
        'slug',
    ];

    public function roles() {
        return $this->belongsToMany( Role::class, null,'permission_ids','role_ids' );

    }

    public function users() {
        return $this->belongsToMany( User::class, null,'permission_ids','user_ids' );
    }
}
