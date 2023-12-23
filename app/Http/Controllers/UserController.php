<?php
	
	namespace App\Http\Controllers;
	
	use App\Models\Permission;
	use App\Models\Role;
	use App\Models\User;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Hash;
	use Illuminate\Support\Facades\Validator;
	
	class UserController extends Controller
	{
		public function __construct( Request $request ) {
			$this->middleware( 'permission:view-users' )->only( 'index' );
			$this->middleware( 'permission:add-users' )->only( 'store' );
			$this->middleware( 'permission:edit-users' )->only( 'update' );
			$this->middleware( 'permission:delete-users' )->only('destroy');
		}
		
		/**
		 * Display a listing of the resource.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function index( Request $request ) {
			$keyword = (string) $request->input( 'keyword' );
			$role_id = (string) $request->input( 'role_id' );
			$query   = User::query();
			$query   = $query->with( 'roles' );
			if ( $keyword != '' )
			{
				$query = $query->where( function ( $query ) use ( $keyword ) {
					$query = $query->orWhere( 'name', 'like', '%' . $keyword . '%' );
					$query = $query->orWhere( 'username', 'like', '%' . $keyword . '%' );
					$query = $query->orWhere( 'email', 'like', '%' . $keyword . '%' );
				} );
			}
			if ( $role_id > 0 )
			{
				$query = $query->whereHas( 'roles', function ( $query ) use ( $role_id ) {
					$query->where( '_id', '=', $role_id );
				} );
			}
			$users = $query->paginate( 20 );
			
			return response()->json( $users, 200 );
		}
		
		/**
		 * Store a newly created resource in storage.
		 *
		 * @param \Illuminate\Http\Request $request
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function store( Request $request ) {
			$name     = (string) $request->input( 'name' );
			$username = (string) $request->input( 'username' );
			$phone    = (string) $request->input( 'phone' );
			$email    = (string) $request->input( 'email' );
			$password = (string) $request->input( 'password' );
			
			$status    = $request->input( 'status' );
			$roles     = $request->input( 'roles' );
			$validator = Validator::make( $request->all(), [
				'name'     => [ 'required', 'string' ],
				'password' => [ 'required', 'string' ],
				'email'    => [ 'required', 'string', 'email', 'max:255', 'unique:users' ],
				'username' => [ 'required', 'string', 'max:255', 'unique:users' ],
				'roles'    => [ 'array' ]
			] );
			if ( $validator->fails() )
			{
				return response()->json( [
					'error_code' => 1,
					'message'    => trans( 'The given data is invalid' ),
					'errors'     => $validator->errors()
				], 200 );
			}
			$role_permissions = [];
			$user_roles       = Role::whereIn( 'slug', $roles )->get();
			if ( ! empty( $roles ) )
			{
				foreach ( $roles as $role )
				{
					$r = Role::where( 'slug', '=', $role )->first();
					if ( $r )
					{
						$r_p = $r->permissions;
						if ( ! empty( $r_p ) )
						{
							foreach ( $r_p as $p )
							{
								array_push( $role_permissions, $p->slug );
							}
						}
					}
				}
			}
			$user_permissions = Permission::whereIN( 'slug', $role_permissions )->get();
			
			$user           = new User();
			$user->name     = $name;
			$user->username = $username;
			$user->phone    = $phone;
			$user->email    = $email;
			$user->status   = $status;
			$user->password = Hash::make( $password );
			
			$user->save();
			$user->roles()->sync( $user_roles );
			$user->permissions()->sync( $user_permissions );
			
			return response()->json( [
				'error_code' => 0,
				'data'       => $user,
			], 200 );
			
		}
		
		/**
		 * Display the specified resource.
		 *
		 * @param int $id
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function show( $id ) {
			$user = User::find( $id );
			if ( ! $user )
			{
				return response()->json( [
					'error_code' => 1,
					'message'    => trans( 'This user not exist' ),
				], 200 );
			}
			$user['roles'] = $user->getRoleSlugAttribute();
			
			return response()->json( [
				'error_code' => 0,
				'data'       => $user,
			], 200 );
		}
		
		/**
		 * Update the specified resource in storage.
		 *
		 * @param \Illuminate\Http\Request $request
		 * @param int $id
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function update( Request $request, $id ) {
			$user = User::find( $id );
			if ( ! $user )
			{
				return response()->json( [
					'error_code' => 1,
					'message'    => trans( 'This user not exist' ),
				], 200 );
			}
			$name     = (string) $request->input( 'name' );
			$password = (string) $request->input( 'password' );
			$status   = $request->input( 'status' );
			$roles    = $request->input( 'roles' );
			
			$validator = Validator::make( $request->all(), [
				'name'  => [ 'required', 'string' ],
				'roles' => [ 'array' ]
			] );
			if ( $validator->fails() )
			{
				return response()->json( [
					'error_code' => 1,
					'message'    => trans( 'The given data is invalid' ),
					'errors'     => $validator->errors()
				], 200 );
			}
			$role_permissions = [];
			$user_roles       = Role::whereIn( 'slug', $roles )->get();
			if ( ! empty( $roles ) )
			{
				foreach ( $roles as $role )
				{
					$r = Role::where( 'slug', '=', $role )->first();
					if ( $r )
					{
						$r_p = $r->permissions;
						if ( ! empty( $r_p ) )
						{
							foreach ( $r_p as $p )
							{
								array_push( $role_permissions, $p->slug );
							}
						}
					}
				}
			}
			$user_permissions = Permission::whereIN( 'slug', $role_permissions )->get();
			$user->name       = $name;
			$user->status     = $status;
			if ( $password != '' )
			{
				$user->password = Hash::make( $password );
			}
			
			$user->save();
			$user->roles()->sync( $user_roles );
			$user->permissions()->sync( $user_permissions );
			
			return response()->json( [
				'error_code' => 0,
				'data'       => $user,
			], 200 );
		}
		
		/**
		 * Remove the specified resource from storage.
		 *
		 * @param int $id
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function destroy( $id ) {
			$user = User::find( $id );
			if ( ! $user )
			{
				return response()->json( [
					'error_code' => 1,
					'message'    => trans( 'This user not exist' ),
				], 200 );
			}
			$user->delete();
			
			return response()->json( [
				'error_code' => 0,
				'message'    => trans( 'Destroyed' ),
			], 200 );
		}
		
		public function profile( Request $request ) {
			$user = $request->user();
			$user->roles;
			
			return response()->json( [
				'error_code' => 0,
				'user'       => $user,
			], 200 );
		}
		
		public function update_profile( Request $request ) {
			$user      = $request->user();
			$validator = Validator::make( $request->all(), [
				'name'             => [ 'required', 'string' ],
				'current_password' => [
					'nullable',
					function ( $attribute, $value, $fail ) use ( $user ) {
						if ( ! Hash::check( $value, $user->password ) )
						{
							return $fail( __( 'The current password is incorrect' ) );
						}
					}
				],
				'password'         => [ 'required_with:current_password' ]
			] );
			
			if ( $validator->fails() )
			{
				return response()->json( [
					'error_code' => 1,
					'message'    => trans( 'The given data is invalid' ),
					'errors'     => $validator->errors()
				], 200 );
			}
			
			$name             = $request->input( 'name' );
			$phone            = $request->input( 'phone' );
			$password         = $request->input( 'password' );
			$current_password = $request->input( 'current_password' );
			
			$user->name  = $name;
			$user->phone = $phone;
			if ( $current_password != '' && $password != '' )
			{
				$user->password = Hash::make( $password );
			}
			$user->save();
			
			return response()->json( [
				'error_code' => 0,
				'user'       => $user,
				'message'    => trans( 'Update success' )
			], 200 );
		}
		
		public function get_all_roles( Request $request ) {
			$roles = Role::all();
			
			return response()->json( $roles, 200 );
		}
		
		public function ajax_search_users( Request $request ) {
			$keyword = $request->input( 'q' );
			$type    = $request->input( 'type' );
			$role    = $request->input( 'role' );
			if ( $keyword == '' )
			{
				return response()->json( [], 200 );
			}
			$query = User::query();
			if ( $keyword != '' )
			{
				$query = $query->where( function ( $query ) use ( $keyword ) {
					$query = $query->orWhere( 'name', 'like', '%' . $keyword . '%' );
					$query = $query->orWhere( 'username', 'like', '%' . $keyword . '%' );
					$query = $query->orWhere( 'email', 'like', '%' . $keyword . '%' );
				} );
			}
			if ( $type != '' )
			{
				$query = $query->where( 'type', $type );
			}
			if ( $role != '' )
			{
				$query = $query->whereHas( 'roles', function ( $q ) use ( $role ) {
					$q->where( 'slug', $role );
				} );
			}
			$query   = $query->select(
				'_id',
				'username',
				'name',
			);
			$results = $query->get();
			
			return response()->json( $results, 200 );
		}
		
		
		
		public function get_all_user( Request $request ) {
			
			$keyword = $request->input( 'keyword' );
			$type    = $request->input( 'type' );
			$role    = $request->input( 'role' );
			
			$query = User::query();
			if ( $keyword != '' )
			{
				$query = $query->where( function ( $query ) use ( $keyword ) {
					$query = $query->orWhere( 'name', 'like', '%' . $keyword . '%' );
					$query = $query->orWhere( 'username', 'like', '%' . $keyword . '%' );
					$query = $query->orWhere( 'email', 'like', '%' . $keyword . '%' );
				} );
			}
			if ( $type != '' )
			{
				$query = $query->where( 'type', $type );
			}
			if ( $role != '' )
			{
				$query = $query->whereHas( 'roles', function ( $q ) use ( $role ) {
					$q->where( 'slug', $role );
				} );
			}
			
			$users = $query->get();
			
			return response()->json( $users, 200 );
		}
		
		
	}

