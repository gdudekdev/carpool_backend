<?php
namespace App\Controllers;

use Core\Database;
use PDO;
use Core\Logger;

class UserController {
    public function index() {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT * FROM users");
        Logger::info("Liste des utilisateurs récupérée");
        return json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public function store() {
        $db = Database::getConnection();
        $data = json_decode(file_get_contents("php://input"), true);

        $stmt = $db->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
        $stmt->execute([$data['name'], $data['email']]);
        Logger::info("Nouvel utilisateur ajouté: " . $data['name']);
        return json_encode(["message" => "Utilisateur ajouté"]);
    }

    public function show($id) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return json_encode($stmt->fetch(PDO::FETCH_ASSOC));
    }

    public function update($id) {
        $db = Database::getConnection();
        $data = json_decode(file_get_contents("php://input"), true);

        $stmt = $db->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
        $stmt->execute([$data['name'], $data['email'], $id]);

        return json_encode(["message" => "Utilisateur mis à jour"]);
    }

    public function destroy($id) {
        $db = Database::getConnection();
        $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);

        return json_encode(["message" => "Utilisateur supprimé"]);
    }
}
