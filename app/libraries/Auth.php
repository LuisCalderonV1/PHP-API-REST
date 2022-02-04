<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Auth
{
    private static $secret_key = 'Sdw1s9x8@';
    private static $encrypt = ['HS256'];
    private static $aud = null;

    public static function SignIn($data)
    {
        $time = time();
        $payload = array(
            "iss" => "http://example.org",
            "aud" =>  self::Aud(),
            "iat" => $time,
            "nbf" => $time,
            'data' => $data,
        );
        
        return JWT::encode($payload, self::$secret_key, 'HS256');
    }

    public static function Check($token)
    {
        
        if(empty($token))
        {
            throw new Exception("Invalid token supplied.");
        }
        
        $decoded = JWT::decode($token, new Key(self::$secret_key, 'HS256'));

        if($decoded->aud !== self::Aud())
        {
            throw new Exception("Invalid user logged in.");
        }
        
        return true;
    }

    public static function GetData($token)
    {
        return JWT::decode($token, new Key(self::$secret_key, 'HS256'))->data;
    }

    private static function Aud()
    {
        $aud = '';

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $aud = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $aud = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $aud = $_SERVER['REMOTE_ADDR'];
        }

        $aud .= @$_SERVER['HTTP_USER_AGENT'];
        $aud .= gethostname();

        return sha1($aud);
    }
}