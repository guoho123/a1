<?php
include "conn.php";

$id = $_POST['id'] ?? 0;
if (!is_numeric($id) || $id < 0) {
    echo json_encode(['code' => 0, 'msg' => '参数错误']);
    exit;
}

clearstatcache();
$login_log = DB::get('login_log');

if (isset($login_log[$id])) {
    array_splice($login_log, $id, 1);
    DB::set('login_log', $login_log);
    echo json_encode(['code' => 1, 'msg' => '删除成功']);
} else {
    echo json_encode(['code' => 0, 'msg' => '记录不存在']);
}
?>
