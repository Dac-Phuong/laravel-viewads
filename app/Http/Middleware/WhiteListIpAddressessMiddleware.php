<?php
	
	namespace App\Http\Middleware;
	
	use App\Models\WhileIp;
	use Closure;
	use Illuminate\Http\Request;
	use Illuminate\Http\Response;
	use Illuminate\Log\Logger;
	use Illuminate\Support\Facades\Http;
	
	class WhiteListIpAddressessMiddleware {
		
		
		public function handle( Request $request, Closure $next ) {
			$white_list_country = config( 'white_list_country' );
			$ip                 = $request->getClientIp();
			$res                = Http::get( 'http://www.geoplugin.net/json.gp?ip=' . $ip );
			$ipinfo             = $res->json();
			$country            = $ipinfo['geoplugin_countryCode'] ?? 'N/A';
			if ( ! isset( $white_list_country[ $country ] ) ) {
				$whitelistIps = WhileIp::where( 'status', '=', 'on' )->pluck( 'ip' )->toArray();
				if ( ! in_array( $request->getClientIp(), $whitelistIps ) ) {
					return response()->json( array( 'message' => 'Forbidden' ), 403 );
				}
			}
			
			return $next( $request );
		}
	}
