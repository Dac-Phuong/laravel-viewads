<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole {
	/**
	 * Handle an incoming request.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \Closure $next
	 *
	 * @return mixed
	 */
	public function handle( $request, Closure $next, $role ) {
		if ( ! $request->user()->hasRole( $role ) ) {
			return $request->expectsJson() ? response()->json( array( 'message' => 'You are not authorized to access.' ), 403 ) : abort( 403, 'You are not authorized to access.' );
		}
		return $next( $request );
	}
}
