<?php
namespace App\Controllers;

class FileController {
    public function upload() {
        if (!isset($_FILES['file'])) {
            return json_encode(["error" => "Aucun fichier envoyé."]);
        }

        $targetDir = __DIR__ . "/../../storage/uploads/";
        $targetFile = $targetDir . basename($_FILES["file"]["name"]);

        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
            return json_encode(["message" => "Fichier uploadé avec succès", "path" => $targetFile]);
        } else {
            return json_encode(["error" => "Erreur lors de l'upload"]);
        }
    }
}
