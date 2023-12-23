<?php

namespace App\Http\Middleware;

use Closure;

class CheckPermission {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     *
     * @return mixed
     */
    public function handle( $request, Closure $next, $permission ) {

        if ( ! $request->user()->can( $permission ) ) {
            return $request->expectsJson() ? response()->json(array('message'=>'You are not authorized to access.'), 403) :abort(403, 'You are not authorized to access.');
        }
        return $next( $request );
    }
}
