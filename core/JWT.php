<?php
namespace Core;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTService {
    private static $secretKey = "VOTRE_CLE_SECRETE"; // Changez cette clé secrète !!!

    public static function generateToken($user) {
        $payload = [
            "iss" => "localhost", // Émetteur
            "aud" => "localhost", // Destinataire
            "iat" => time(), // Émis à
            "exp" => time() + 3600, // Expiration (1 heure)
            "user_id" => $user['id'],
            "email" => $user['email']
        ];

        return JWT::encode($payload, self::$secretKey, 'HS256');
    }

    public static function verifyToken($token) {
        try {
            return JWT::decode($token, new Key(self::$secretKey, 'HS256'));
        } catch (\Exception $e) {
            return null;
        }
    }
}
