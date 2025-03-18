<?php
namespace Core;

use PDO;
use PDOException;

class Database {
    private static $instance = null;
    
    public static function getConnection() {
        if (self::$instance === null) {
            $config = require __DIR__ . '/../config/database.php';
            try {
                self::$instance = new PDO(
                    "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}",
                    $config['user'],
                    $config['password'],
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
                );
            } catch (PDOException $e) {
                Logger::error("Erreur de connexion à la BDD: " . $e->getMessage());
                die("Erreur de connexion : " . $e->getMessage());
            }
        }
        return self::$instance;
    }
}
