<?php
include "conn.php";

$act = $_GET['act'] ?? '';

if ($act == 'import_students') {
    $list = json_decode($_POST['list'], true);
    $students = DB::get('students');

    foreach ($list as $item) {
        $exist = false;
        foreach ($students as $s) {
            if ($s['sid'] == $item['sid']) {
                $exist = true;
                break;
            }
        }
        if (!$exist) {
            $students[] = $item;
        }
    }

    DB::set('students', $students);
    echo json_encode(['code' => 1]);
}


if ($act == 'del_student') {
    $sid = $_POST['sid'] ?? '';
    $students = DB::get('students');
    $res = [];
    foreach ($students as $s) {
        if ($s['sid'] != $sid) $res[] = $s;
    }
    DB::set('students', $res);
    echo json_encode(['code' => 1]);
}

if ($act == 'del_login') {
    $sid = $_POST['sid'] ?? '';
    $date = $_POST['date'] ?? '';
    $log = DB::get('login_log');
    $res = [];
    foreach ($log as $item) {
        if (!($item['sid'] == $sid && $item['date'] == $date)) {
            $res[] = $item;
        }
    }
    DB::set('login_log', $res);
    echo json_encode(['code' => 1]);
}
if ($act == 'del_homework') {
    $sid = $_POST['sid'] ?? '';
    $date = $_POST['date'] ?? '';
    $homework = DB::get('homework');
    $res = [];

    foreach ($homework as $h) {
        if ($h['sid'] == $sid && $h['date'] == $date) {
            $file = __DIR__ . '/../uploads/' . $h['file'];
            if (file_exists($file)) {
                unlink($file);
            }
        } else {
            $res[] = $h;
        }
    }

    DB::set('homework', $res);
    echo json_encode(['code' => 1]);
}


?>
