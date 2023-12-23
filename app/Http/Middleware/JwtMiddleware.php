<?php
	
	namespace App\Http\Middleware;
	
	use Closure;
	use Illuminate\Http\Request;
	use JWTAuth;
	use Exception;
	
	class JwtMiddleware {
		/**
		 * Handle an incoming request.
		 *
		 * @param  \Illuminate\Http\Request  $request
		 * @param  \Closure  $next
		 *
		 * @return mixed
		 */
		public function handle( Request $request, Closure $next ) {
			try {
				$user = JWTAuth::parseToken()->authenticate();
				if ( ! $user ) {
					return $request->expectsJson() ? response()->json( array( 'message' => 'Unauthorized' ),
						401 ) : abort( 401, 'Unauthorized' );
				}
			} catch ( Exception $e ) {
				if ( $e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException ) {
					return response()->json( [ 'status' => 'Token is Invalid' ], 401 );
				} elseif ( $e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException ) {
					return response()->json( [ 'status' => 'Token is Expired' ], 401 );
				} else {
					return response()->json( [ 'status' => 'Authorization Token not found' ], 401 );
				}
			}
			
			return $next( $request );
		}
	}
