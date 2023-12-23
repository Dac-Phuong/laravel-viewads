<?php
	
	namespace App\Models;
	
	// use Illuminate\Contracts\Auth\MustVerifyEmail;
	use DateTimeInterface;
	use Illuminate\Database\Eloquent\Factories\HasFactory;
	use MongoDB\Laravel\Eloquent\Model as Eloquent;
	use MongoDB\Laravel\Auth\User as Authenticatable;
	use Illuminate\Notifications\Notifiable;
	use Tymon\JWTAuth\Contracts\JWTSubject;
	use App\Permissions\HasPermissionsTrait;
	
	class User extends Authenticatable implements JWTSubject {
		use HasFactory, Notifiable, HasPermissionsTrait;
		
		protected $connection = 'mongodb';
		protected $collection = 'users';
		/**
		 * The attributes that are mass assignable.
		 *
		 * @var array<int, string>
		 */
		protected $fillable = [
			'name',
			'email',
			'password',
		];
		
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
		 * The attributes that should be cast.
		 *
		 * @var array<string, string>
		 */
		protected $casts = [
			'email_verified_at' => 'datetime',
			'password'          => 'hashed',
		];
		
		protected function serializeDate( DateTimeInterface $date ) {
			return $date->format( 'Y-m-d H:i:s' );
		}
		
		public function getJWTIdentifier() {
			return $this->getKey();
		}
		
		public function getJWTCustomClaims() {
			return [];
		}
		
		public function getPermissionSlugAttribute() {
			return $this->permissions()->pluck( 'slug' );
		}
		
		public function getRoleSlugAttribute() {
			return $this->roles()->pluck( 'slug' );
		}
	}
	
	
	

