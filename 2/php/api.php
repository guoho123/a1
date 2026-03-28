<?php
header("Cache-Control: no-cache, no-store, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");
header("Content-Type: application/json; charset=utf-8");

error_reporting(E_ALL);
ini_set('display_errors', 0);

include "conn.php";

$type = $_GET['type'] ?? "";

if ($type == 'students') {
    clearstatcache();
    echo json_encode(DB::get('students'));
    exit;
}
if ($type == 'login_log') {
    clearstatcache();
    echo json_encode(DB::get('login_log'));
    exit;
}
if ($type == 'homework') {
    clearstatcache();
    echo json_encode(DB::get('homework'));
    exit;
}
if ($type == 'check_student') {
    $sid = $_GET['sid'] ?? "";
    clearstatcache();
    $students = DB::get('students');
    
    $exists = false;
    foreach ($students as $s) {
        if (isset($s['sid']) && $s['sid'] == $sid) {
            $exists = true;
            break;
        }
    }
    echo json_encode(['exists' => $exists]);
    exit;
}

echo json_encode(['code' => 400, 'msg' => '无效请求']);
?>
