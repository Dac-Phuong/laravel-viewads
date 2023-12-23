<?php

    namespace App\Http\Controllers;

    use App\Models\Permission;
    use App\Models\Role;
    use App\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;

    class RoleController extends Controller {
        public function __construct( Request $request ) {
            $this->middleware( 'permission:view-roles' )->only( 'index' );
            $this->middleware( 'permission:add-roles' )->only( 'store' );
            $this->middleware( 'permission:edit-roles' )->only( 'update' );
            $this->middleware( 'permission:delete-roles' )->only( 'destroy' );
        }

        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index( Request $request ) {
            $query = Role::query();
            $query = $query->with( 'permissions' );
            $query = $query->with( 'users' );
            $query = $query->orderBy( 'name', 'ASC' );
            $roles = $query->get();

            return response()->json( [
                'error_code' => 0,
                'data'       => $roles,
            ], 200 );
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\Response
         */
        public function store( Request $request ) {
            $name        = (string) $request->input( 'name' );
            $permissions = $request->input( 'permissions' );
            $validator   = Validator::make( $request->all(), [
                'name'        => [ 'required', 'string', 'unique:roles' ],
                'permissions' => [ 'array' ]
            ] );
            if ( $validator->fails() )
            {
                return response()->json( [
                    'error_code' => 1,
                    'message'    => trans( 'The given data is invalid' ),
                    'errors'     => $validator->errors()
                ], 200 );
            }

            if ( ! empty( $permissions ) )
            {
                foreach ( $permissions as $permission )
                {
                    $p       = Permission::firstOrNew( [ 'slug' => $permission ] );
                    $p->name = $permission;
                    $p->slug = $permission;
                    $p->save();
                }
            }
            $role_permissions = Permission::whereIn( 'slug', $permissions )->get();
            $role             = new Role();
            $role->name       = $name;
            $role->slug       = strtolower( str_replace( ' ', '-', $name ) );
            $role->can_delete = 1;
            $role->save();
            $role->permissions()->sync( $role_permissions );

            return response()->json( [
                'error_code' => 0,
                'data'       => $role,
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
            $role = Role::find( $id );
            if ( ! $role )
            {
                return response()->json( [
                    'error_code' => 1,
                    'message'    => trans( 'This role not exist' ),
                ], 200 );
            }

            $role['permissions'] = $role->permissions()->pluck( 'slug' );

            return response()->json( [
                'error_code' => 0,
                'data'       => $role,
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
            $role = Role::find( $id );
            if ( ! $role )
            {
                return response()->json( [
                    'error_code' => 1,
                    'message'    => trans( 'This role not exist' ),
                ], 200 );
            }
            $name        = (string) $request->input( 'name' );
            $permissions = $request->input( 'permissions' );
            $validator   = Validator::make( $request->all(), [
                'name'        => [ 'required', 'string' ],
                'permissions' => [ 'array' ]
            ] );
            if ( $validator->fails() )
            {
                return response()->json( [
                    'error_code' => 1,
                    'message'    => trans( 'The given data is invalid' ),
                    'errors'     => $validator->errors()
                ], 200 );
            }

            if ( ! empty( $permissions ) )
            {
                foreach ( $permissions as $permission )
                {
                    $p       = Permission::firstOrNew( [ 'slug' => $permission ] );
                    $p->name = $permission;
                    $p->slug = $permission;
                    $p->save();
                }
            }
            $role_permissions = Permission::whereIn( 'slug', $permissions )->get();

            $role->name = $name;
            $role->slug = strtolower( str_replace( ' ', '-', $name ) );
            $role->save();
            $role->permissions()->sync( $role_permissions );

            if ( $role->user_ids )
            {
                $users = User::whereIn( '_id', $role->user_ids )->get();
                if ( $users )
                {
                    foreach ( $users as $user )
                    {
                        $user->permissions()->sync( $role_permissions );
                    }
                }
            }


            return response()->json( [
                'error_code' => 0,
                'data'       => $role,
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
            $role = Role::find( $id );
            if ( ! $role )
            {
                return response()->json( [
                    'error_code' => 1,
                    'message'    => trans( 'This role not exist' ),
                ], 200 );
            }
            $role->delete();

            return response()->json( [
                'error_code' => 0,
                'message'    => trans( 'Destroyed' ),
            ], 200 );
        }

        public function get_all_permissions( Request $request ) {
            return response()->json( config( 'permissions' ), 200 );
        }

    }
