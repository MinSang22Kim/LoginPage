<?php
session_start();

$connect = mysqli_connect('20.196.222.1', 'root', 'alstkd9031', 'realMSDB');
if (!$connect) {
    die("데이터베이스 연결에 실패하였습니다: " . mysqli_connect_error());
}

$bno = $_GET['idx'];
$userid = $_POST['id'];
$userpw = $_POST['pw'];
$content = $_POST['content'];

if ($bno && $userid && $userpw && $content) {
    $query = "INSERT INTO reply(con_num, id, pw, content) VALUES('$bno', '$userid', '$userpw', '$content')";
    $result = mysqli_query($connect, $query);
    if ($result) {
        echo "<script>alert('댓글이 작성되었습니다.'); location.href='/read.php?idx=$bno';</script>";
    } else {
        echo "<script>alert('댓글 작성에 실패했습니다! " . mysqli_error($connect) . "'); history.back();</script>";
    }
} else {
    echo "<script>alert('댓글 작성에 실패했습니다!!!'); history.back();</script>";
}

mysqli_close($connect);
?>
