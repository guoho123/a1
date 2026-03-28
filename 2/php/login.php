<?php
include "conn.php";

$sid = $_POST['sid'] ?? "";
if (!$sid) {
    echo json_encode(['code' => 0, 'msg' => '请输入学号']);
    exit;
}

$students = DB::get('students');
$user = null;
foreach ($students as $s) {
    if ($s['sid'] == $sid) {
        $user = $s;
        break;
    }
}

if (!$user) {
    echo json_encode(['code' => 0, 'msg' => '无此账号']);
    exit;
}

$today = date("Y-m-d");
$login_log = DB::get('login_log');

$is_logged = false;
foreach ($login_log as $log) {
    if ($log['sid'] == $sid && $log['date'] == $today) {
        $is_logged = true;
        break;
    }
}

if ($is_logged) {
    echo json_encode(['code' => 0, 'msg' => '已登录']);
    exit;
}

$login_log[] = [
    'sid' => $sid,
    'name' => $user['name'],
    'date' => $today,
    'time' => date("H:i:s")
];

DB::set('login_log', $login_log);

setcookie("hw_sid", $sid, time() + 86400, "/");

echo json_encode(['code' => 1, 'msg' => '登录成功', 'sid' => $sid, 'name' => $user['name']]);
?>
