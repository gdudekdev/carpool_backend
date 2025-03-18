<?php
namespace Core;

class Auth {
    public static function checkAuth() {
        $headers = getallheaders();

        if (!isset($headers['Authorization'])) {
            http_response_code(401);
            echo json_encode(["error" => "Token manquant"]);
            exit;
        }

        $token = str_replace("Bearer ", "", $headers['Authorization']);
        $decoded = JWTService::verifyToken($token);

        if (!$decoded) {
            http_response_code(403);
            echo json_encode(["error" => "Token invalide ou expiré"]);
            exit;
        }

        return $decoded;
    }
}
