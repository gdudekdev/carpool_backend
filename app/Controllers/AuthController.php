<?php
namespace App\Controllers;

use Core\Database;
use Core\JWTService;
use Core\Logger;

class AuthController {
    public function register() {
        $db = Database::getConnection();
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['email'], $data['password'])) {
            http_response_code(400);
            echo json_encode(["error" => "Email et mot de passe requis"]);
            return;
        }

        $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);

        $stmt = $db->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
        if ($stmt->execute([$data['email'], $hashedPassword])) {
            Logger::info("Nouvel utilisateur inscrit: " . $data['email']);
            echo json_encode(["message" => "Inscription réussie"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Erreur lors de l'inscription"]);
        }
    }

    public function login() {
        $db = Database::getConnection();
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['email'], $data['password'])) {
            http_response_code(400);
            echo json_encode(["error" => "Email et mot de passe requis"]);
            return;
        }

        $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$data['email']]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($user && password_verify($data['password'], $user['password'])) {
            $token = JWTService::generateToken($user);
            Logger::info("Connexion réussie pour: " . $data['email']);
            echo json_encode(["token" => $token]);
        } else {
            Logger::error("Échec de connexion pour: " . $data['email']);
            http_response_code(401);
            echo json_encode(["error" => "Email ou mot de passe incorrect"]);
        }
    }
}
