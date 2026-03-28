<?php
include "conn.php";

$sid = $_POST['sid'] ?? '';
$name = $_POST['name'] ?? '';
if (!$sid || !$name) {
    echo json_encode(['code' => 0, 'msg' => '参数错误']);
    exit;
}

if (!isset($_FILES['file']) || $_FILES['file']['error'] != 0) {
    echo json_encode(['code' => 0, 'msg' => '上传失败']);
    exit;
}

$ext = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
if ($ext != 'docx') {
    echo json_encode(['code' => 0, 'msg' => '仅允许docx']);
    exit;
}

$filename = $sid . '_' . $name . '.docx';
$dest = __DIR__ . '/../uploads/' . $filename;
move_uploaded_file($_FILES['file']['tmp_name'], $dest);

$today = date('Y-m-d');
$homework = DB::get('homework');
$new_list = [];
foreach ($homework as $h) {
    if (!($h['sid'] == $sid && $h['date'] == $today)) {
        $new_list[] = $h;
    }
}

$new_list[] = [
    'sid' => $sid,
    'name' => $name,
    'date' => $today,
    'file' => $filename,
    'time' => date('H:i:s')
];

DB::set('homework', $new_list);
echo json_encode(['code' => 1, 'msg' => '上传成功']);
?>
