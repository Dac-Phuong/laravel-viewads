<?php
	namespace App\Http\Controllers;
	
	use App\Models\WhileIp;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Validator;
	
	class WhileIpController extends Controller {
		public function __construct( Request $request ) {
			$this->middleware( 'permission:view-while-ips' )->only( 'index' );
			$this->middleware( 'permission:add-while-ips' )->only( 'store' );
			$this->middleware( 'permission:edit-while-ips' )->only( 'update' );
			$this->middleware( 'permission:delete-while-ips' )->only( 'destroy' );
		}
		
		/**
		 * Display a listing of the resource.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function index( Request $request ) {
			$keyword = (string) $request->input( 'keyword' );
			$query   = WhileIp::query();
			if ( $keyword != '' ) {
				$query = $query->where( function ( $query ) use ( $keyword ) {
					$query = $query->orWhere( 'ip', 'like', '%' . $keyword . '%' );
				} );
			}
			
			$query    = $query->orderBy( 'created_at', 'DESC' );
			$whileIps = $query->paginate( 20 );
			
			return response()->json( $whileIps, 200 );
		}
		
		/**
		 * Store a newly created resource in storage.
		 *
		 * @param \Illuminate\Http\Request $request
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function store( Request $request ) {
			$ip        = $request->input( 'ip' );
			$status    = $request->input( 'status' );
			$desc      = (string) $request->input( 'desc' );
			$validator = Validator::make( $request->all(), [
				'ip'     => [ 'required', 'string', 'ip', 'unique:while_ips' ],
				'status' => [ 'required', 'string', 'in:on,off' ],
			] );
			if ( $validator->fails() ) {
				return response()->json( [
					'error_code' => 1,
					'message'    => trans( 'The given data is invalid' ),
					'errors'     => $validator->errors()
				], 200 );
			}
			
			$whileIp         = new WhileIp();
			$whileIp->ip     = $ip;
			$whileIp->status = $status;
			$whileIp->desc   = $desc;
			$whileIp->save();
			
			return response()->json( [
				'error_code' => 0,
				'data'       => $whileIp,
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
			$ip = WhileIp::find( $id );
			if ( ! $ip ) {
				return response()->json( [
					'error_code' => 1,
					'message'    => trans( 'This user not exist' ),
				], 200 );
			}
			
			return response()->json( [
				'error_code' => 0,
				'data'       => $ip,
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
			
			$whileIp = WhileIp::find( $id );
			if ( ! $whileIp ) {
				return response()->json( [
					'error_code' => 1,
					'message'    => trans( 'This user not exist' ),
				], 200 );
			}
			$ip        = $request->input( 'ip' );
			$status    = $request->input( 'status' );
			$desc      = (string) $request->input( 'desc' );
			$validator = Validator::make( $request->all(), [
				'ip'     => [ 'required', 'string', 'ip' ],
				'status' => [ 'required', 'string', 'in:on,off' ],
			] );
			if ( $validator->fails() ) {
				return response()->json( [
					'error_code' => 1,
					'message'    => trans( 'The given data is invalid' ),
					'errors'     => $validator->errors()
				], 200 );
			}
			$whileIp->ip     = $ip;
			$whileIp->status = $status;
			$whileIp->desc   = $desc;
			$whileIp->save();
			
			return response()->json( [
				'error_code' => 0,
				'data'       => $whileIp,
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
			$whileIp = WhileIp::find( $id );
			if ( ! $whileIp ) {
				return response()->json( [
					'error_code' => 1,
					'message'    => trans( 'This user not exist' ),
				], 200 );
			}
			$whileIp->delete();
			
			return response()->json( [
				'error_code' => 0,
				'message'    => trans( 'Destroyed' ),
			], 200 );
		}
	}

