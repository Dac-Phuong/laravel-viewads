<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model ;
use App\Models\Permission;

class Role extends Model {
    use HasFactory;

    public $timestamps = false;
    protected $connection = 'mongodb';
    protected $collection = 'roles';

    public function users() {
        return $this->belongsToMany( User::class, null, 'role_ids', 'user_ids' );
    }

    public function permissions() {

        return $this->belongsToMany( Permission::class, null, 'role_ids', 'permission_ids' );
    }

}
