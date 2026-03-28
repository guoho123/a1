<?php
header("Content-Type: application/json; charset=utf-8");
date_default_timezone_set("Asia/Shanghai");

class DB {
    private static $root = __DIR__ . "/../data/";

    public static function get($file) {
        $f = self::$root . $file . ".json";
        if (!file_exists($f)) return [];
        
        clearstatcache(true, $f);
        $fp = fopen($f, "r");
        if ($fp) {
            flock($fp, LOCK_SH);
            $str = fread($fp, filesize($f));
            flock($fp, LOCK_UN);
            fclose($fp);
            clearstatcache(true, $f);
            return json_decode($str, true) ?: [];
        }
        return [];
    }

    public static function set($file, $data) {
        $f = self::$root . $file . ".json";
        clearstatcache(true, $f);
        $fp = fopen($f, "w");
        if ($fp) {
            flock($fp, LOCK_EX);
            fwrite($fp, json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
            flock($fp, LOCK_UN);
            fclose($fp);
            clearstatcache(true, $f);
        }
    }
}
?>
