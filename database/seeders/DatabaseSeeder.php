<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
	public function run() {
		// Insert permissions
		$permissions      = config( 'permissions' );
		$list_permissions = [];
		if ( ! empty( $permissions ) )
		{
			foreach ( $permissions as $p )
			{
				if ( isset( $p['permissions'] ) && ! empty( $p['permissions'] ) )
				{
					$list_permissions = array_merge( $list_permissions, $p['permissions'] );
				}
			}
		}
		
		if ( ! empty( $list_permissions ) )
		{
			foreach ( $list_permissions as $permission => $name )
			{
				$p       = new Permission();
				$p->name = $name;
				$p->slug = $permission;
				$p->save();
			}
		}
		
		// Create role
		$role             = new Role();
		$role->name       = 'Administrator';
		$role->slug       = 'administrator';
		$role->can_delete = 0;
		$role->save();
		$role_permissions = Permission::all();
		$role->permissions()->sync( $role_permissions );
		
		// Create user
		$role_permissions = $role->permissions->pluck( 'slug' );
		$user_permissions = Permission::whereIN( 'slug', $role_permissions )->get();
		$ability          = array(
			array( 'action' => 'manage', 'subject' => 'all' )
		);
		$user             = new User();
		$user->name       = 'Administrator';
		$user->email      = 'admin@viewads.com';
		$user->username   = 'admin';
		$user->phone      = '0989777888';
		$user->status     = 1;
		$user->ability    = $ability;
		$user->password   = bcrypt( '5ChauMedia@' );
		$user->save();
		$user->roles()->attach( $role );
		$user->permissions()->sync( $user_permissions );
		
	}
}
