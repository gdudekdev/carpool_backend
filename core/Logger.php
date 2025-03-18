<?php
namespace Core;

class Logger {
    private static function writeLog($file, $message) {
        $date = date('Y-m-d H:i:s');
        $logMessage = "[$date] $message" . PHP_EOL;
        file_put_contents(__DIR__ . "/../storage/logs/$file", $logMessage, FILE_APPEND);
    }

    public static function info($message) {
        self::writeLog('app.log', "[INFO] $message");
    }

    public static function error($message) {
        self::writeLog('error.log', "[ERROR] $message");
    }

    public static function request($method, $url, $body = null) {
        $message = "[REQUEST] $method $url";
        if ($body) {
            $message .= " - Body: " . json_encode($body);
        }
        self::writeLog('requests.log', $message);
    }
}
