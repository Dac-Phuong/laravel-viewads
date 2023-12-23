<?php

namespace App;

use App\Models\Option;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class Helpers {
    public static function is_serialized( $data, $strict = true ) {
        // if it isn't a string, it isn't serialized.
        if ( ! is_string( $data ) ) {
            return false;
        }
        $data = trim( $data );
        if ( 'N;' == $data ) {
            return true;
        }
        if ( strlen( $data ) < 4 ) {
            return false;
        }
        if ( ':' !== $data[1] ) {
            return false;
        }
        if ( $strict ) {
            $lastc = substr( $data, - 1 );
            if ( ';' !== $lastc && '}' !== $lastc ) {
                return false;
            }
        } else {
            $semicolon = strpos( $data, ';' );
            $brace     = strpos( $data, '}' );
            // Either ; or } must exist.
            if ( false === $semicolon && false === $brace ) {
                return false;
            }
            // But neither must be in the first X characters.
            if ( false !== $semicolon && $semicolon < 3 ) {
                return false;
            }
            if ( false !== $brace && $brace < 4 ) {
                return false;
            }
        }
        $token = $data[0];
        switch ( $token ) {
            case 's':
                if ( $strict ) {
                    if ( '"' !== substr( $data, - 2, 1 ) ) {
                        return false;
                    }
                } elseif ( false === strpos( $data, '"' ) ) {
                    return false;
                }
            // or else fall through
            case 'a':
            case 'O':
                return (bool) preg_match( "/^{$token}:[0-9]+:/s", $data );
            case 'b':
            case 'i':
            case 'd':
                $end = $strict ? '$' : '';

                return (bool) preg_match( "/^{$token}:[0-9.E-]+;$end/", $data );
        }

        return false;
    }

    public static function convert_vi_to_en( $str ) {
        $str = preg_replace( "/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", "a", $str );
        $str = preg_replace( "/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", "e", $str );
        $str = preg_replace( "/(ì|í|ị|ỉ|ĩ)/", "i", $str );
        $str = preg_replace( "/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", "o", $str );
        $str = preg_replace( "/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", "u", $str );
        $str = preg_replace( "/(ỳ|ý|ỵ|ỷ|ỹ)/", "y", $str );
        $str = preg_replace( "/(đ)/", "d", $str );
        $str = preg_replace( "/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", "A", $str );
        $str = preg_replace( "/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", "E", $str );
        $str = preg_replace( "/(Ì|Í|Ị|Ỉ|Ĩ)/", "I", $str );
        $str = preg_replace( "/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", "O", $str );
        $str = preg_replace( "/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", "U", $str );
        $str = preg_replace( "/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", "Y", $str );
        $str = preg_replace( "/(Đ)/", "D", $str );
        $str = preg_replace( '/\s+/', ' ', $str );
        return trim( $str );
    }

    public static function shortcode_atts( $pairs, $atts ) {
        $atts = (array) $atts;
        $out  = array();
        foreach ( $pairs as $name => $default ) {
            if ( array_key_exists( $name, $atts ) ) {
                $out[ $name ] = $atts[ $name ];
            } else {
                $out[ $name ] = $default;
            }
        }

        return $out;
    }

    public static function make_ref_number() {
       // return strtoupper(self::generateRandomString(5));
        $prefix      = config( 'app.currency' );
        $prefix      = substr( $prefix, 0, 2 );
        $prefix_char = strtoupper( substr( str_shuffle( str_repeat( "abcdefghijklmnopqrstuvwxyz", 2 ) ), 0, 2 ) );

        return $prefix . $prefix_char . str_pad( mt_rand( 1, 999999 ), 6, '0', STR_PAD_LEFT );
    }

    public static function convert_phone_number( $phone ) {
        if( strlen($phone) == 10){
            return  $phone;
        }
        $first_numbers = [
            '0162' => '032',
            '0163' => '033',
            '0164' => '034',
            '0165' => '035',
            '0166' => '036',
            '0167' => '037',
            '0168' => '038',
            '0169' => '039',
            '0120' => '070',
            '0121' => '079',
            '0122' => '077',
            '0126' => '076',
            '0128' => '078',
            '0123' => '083',
            '0124' => '084',
            '0125' => '085',
            '0127' => '081',
            '0129' => '082',
            '0186' => '056',
            '0188' => '058',
            '0199' => '059',
        ];
        $first         = substr( $phone, 0, 2 );
        $last          = substr( $phone, 2, strlen( $phone ) );
        if ( $first == '84' ) {
            return '0' . $last;
        }
        $first = substr( $phone, 0, 4 );
        $last  = substr( $phone, 4, strlen( $phone ) );
        foreach ( $first_numbers as $key => $value ) {
            if ( $key == $first ) {
                return $value . $last;
            }
        }
    }

    public static function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function otpCreate($timestamp='', $microtime=''){
        if (!$timestamp)
            $timestamp = time();
        if (!$microtime)
            $microtime = microtime(true);
        $bases = [
            '00:00:00'=>1577833200,
            //'00:30:00'=>1577835000,
            '01:00:00'=>1577836800,
           // '01:30:00'=>1577838600,
            '02:00:00'=>1577840400,
           // '02:30:00'=>1577842200,
            '03:00:00'=>1577844000,
          //  '03:30:00'=>1577845800,
            '04:00:00'=>1577847600,
           // '04:30:00'=>1577849400,
            '05:00:00'=>1577851200,
           // '05:30:00'=>1577853000,
            '06:00:00'=>1577854800,
           // '06:30:00'=>1577856600,
            '07:00:00'=>1577858400,
           // '07:30:00'=>1577860200,
            '08:00:00'=>1577862000,
           // '08:30:00'=>1577863800,
            '09:00:00'=>1577865600,
           // '09:30:00'=>1577867400,
            '10:00:00'=>1577869200,
           // '10:30:00'=>1577871000,
            '11:00:00'=>1577872800,
            //'11:30:00'=>1577874600,
            '12:00:00'=>1577876400,
           // '12:30:00'=>1577878200,
            '13:00:00'=>1577880000,
           // '13:30:00'=>1577881800,
            '14:00:00'=>1577883600,
           // '14:30:00'=>1577885400,
            '15:00:00'=>1577887200,
           // '15:30:00'=>1577889000,
            '16:00:00'=>1577890800,
           // '16:30:00'=>1577892600,
            '17:00:00'=>1577894400,
            //'17:30:00'=>1577896200,
            '18:00:00'=>1577898000,
           // '18:30:00'=>1577899800,
            '19:00:00'=>1577901600,
           // '19:30:00'=>1577903400,
            '20:00:00'=>1577905200,
           // '20:30:00'=>1577907000,
            '21:00:00'=>1577908800,
           // '21:30:00'=>1577910600,
            '22:00:00'=>1577912400,
           // '22:30:00'=>1577914200,
            '23:00:00'=>1577916000,
            //'23:30:00'=>1577917800,
        ];
        $c = '2020-01-01'.' '.date('H:i:s', $timestamp);
        $y = date('ymd', $timestamp);
        $t = strtotime($c);
        $m = round($microtime-$timestamp, 2)*100;
        $block = '00:00:00';
        foreach ($bases as $basis=>$value){
            if ($t>=$value){
                $block = $basis;
            }else{
                break;
            }
        }
        return str_pad((string)(1000 + ($t - $bases[$block])).$m + $y, 6, '0', STR_PAD_LEFT) ;
    }
}
