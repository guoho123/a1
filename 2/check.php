<?php
include __DIR__ . "/php/conn.php";

$sid = $_GET["sid"] ?? "";
$today = date("Y-m-d");
$homework = DB::get("homework");

foreach ($homework as $h) {
    if ($h["sid"] === $sid && $h["date"] === $today) {
        echo "ok";
        exit;
    }
}
echo "no";
?>
