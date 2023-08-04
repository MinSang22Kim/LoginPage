<?php
$connect = mysqli_connect('localhost', 'root', 'alstkd9031', 'realMSDB') or die("connect failed");
$num = $_GET['idx']; // 댓글 번호
$con_num = $_GET['con_num']; // 댓글 번호
$sql = query("select * from reply where idx='" . $num . "'"); //reply테이블에서 idx가 num변수에 저장된 값을 찾음
$reply = $sql->fetch_array();

$con_num = $_POST['con_num']; //게시글 번호
// 쿼리를 실행하고 결과를 가져옵니다.
$result = $connect->query($query);
$row = mysqli_fetch_assoc($result);

session_start();

if (!isset($_SESSION['name'])) {
    $URL = "read.php?number=$con_num";
    echo "<script>
        alert('권한이 없습니다!');
        location.replace('$URL');
    </script>";
} else if ($_SESSION['name'] == $name) {
    $deleteQuery = "DELETE FROM reply WHERE idx = '$idx'";

    // 쿼리를 실행하고 결과를 확인합니다.
    $deleteResult = mysqli_query($connect, $deleteQuery);

    if ($deleteResult) {
        $URL = "read.php?number=$con_num";
        header("Location: $URL");
    } else {
        // 댓글 삭제가 실패한 경우, 오류 메시지를 출력합니다.
        echo "해당 댓글 삭제에 실패했습니다!";
    }
} else {
    $URL = "read.php?number=$con_num";
    echo "<script>
        alert('권한이 없습니다!');
        location.replace('$URL');
    </script>";
}
?>