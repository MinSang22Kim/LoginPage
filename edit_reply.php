<?php
$connect = mysqli_connect('localhost', 'root', 'alstkd9031', 'realMSDB') or die("connect failed");

// POST 방식으로 전달된 댓글 ID와 게시물 번호, 비밀번호, 수정된 내용을 변수에 저장합니다.
$replyId = $_POST['name'];
$number = $_GET['con_num'];
$password = $_POST['pw'];
$content = $_POST['content'];

// 비밀번호 검사를 위한 쿼리문을 작성합니다.
$query = "SELECT pw FROM reply WHERE idx = '$replyId'";

// 쿼리를 실행하고 결과를 가져옵니다.
$result = mysqli_query($connect, $query);

// 쿼리 실행 결과를 확인하여 비밀번호를 가져옵니다.
if ($result) {
    $row = mysqli_fetch_assoc($result);

    if ($row && $row['pw'] === $password) {
        // 비밀번호가 일치하는 경우, 댓글 수정을 위한 쿼리문을 작성합니다.
        $updateQuery = "UPDATE reply SET content = '$content' WHERE idx = '$replyId'";

        // 쿼리를 실행하고 결과를 확인합니다.
        $updateResult = mysqli_query($connect, $updateQuery);

        if ($updateResult) {
            // 댓글 수정이 성공한 경우, 팝업창을 띄우고 확인을 누르면 해당 글의 상세 페이지로 리다이렉트합니다.
            echo "<script>
                    alert('댓글 수정에 성공했습니다!!');
                    window.location.href = 'read.php?number=$number';
                 </script>";
            exit();
        } else {
            // 댓글 수정이 실패한 경우, 오류 메시지를 출력합니다.
            echo "댓글 수정에 실패했습니다.";
        }
    } else {
        // 비밀번호가 일치하지 않는 경우, 오류 메시지를 출력합니다.
        echo "비밀번호가 일치하지 않습니다.";
    }
} else {
    // 쿼리 실행이 실패한 경우, 오류 메시지를 출력합니다.
    echo "댓글 정보를 가져오는데 실패했습니다.";
}

// DB 연결을 닫습니다.
mysqli_close($connect);
?>
