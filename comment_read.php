<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        .comment-info {
            text-align: center;
            margin-bottom: 20px;
        }

        .comment-info span {
            margin-right: 10px;
            cursor: pointer;
        }

        .comment-content {
            padding: 20px;
            border: 1px solid #444444;
            margin-bottom: 20px;
        }

        .comment-buttons {
            text-align: center;
        }

        .comment-buttons button {
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <?php
    // 댓글 ID를 GET 방식으로 전달 받음
    $commentId = $_GET['name'];

    // 데이터베이스 연결
    $connect = mysqli_connect('20.196.222.1', 'root', 'alstkd9031', 'realMSDB');
    if (!$connect) {
        die("데이터베이스 연결에 실패했습니다.");
    }

    // 댓글 정보를 가져오는 쿼리
    $query = "SELECT * FROM reply WHERE idx = $commentId";
    $result = mysqli_query($connect, $query);

    // 쿼리 실행 결과를 확인하여 댓글 정보를 가져옴
    if ($result) {
        $comment = mysqli_fetch_assoc($result);

        // 댓글 정보를 출력
        if ($comment) {
            echo "<div class='comment-info'>";
            echo "<span>작성자: " . $comment['name'] . "</span>";
            echo "<span>작성일: " . $comment['date'] . "</span>";
            echo "</div>";

            echo "<div class='comment-content'>";
            echo $comment['content'];
            echo "</div>";

            echo "<div class='comment-buttons'>";
            echo "<button onclick='editComment()'>수정</button>";
            echo "<button onclick='deleteComment()'>삭제</button>";
            echo "</div>";

            echo "<div class='edit-comment-form' id='editCommentForm' style='display: none;'>";
            echo "<form action='edit_reply.php' method='post'>";
            echo "<textarea name='editedContent'></textarea>";
            echo "<div class='edit-comment-buttons'>";
            echo "<button type='submit'>수정 완료</button>";
            echo "<button onclick='cancelEdit()'>취소</button>";
            echo "</div>";
            echo "</form>";
            echo "</div>";
        }
    } else {
        echo "댓글 정보를 가져오는데 실패했습니다.";
    }

    // 데이터베이스 연결 종료
    mysqli_close($connect);
    ?>

    <script>
        // 댓글 수정
        function editComment() {
            var editForm = document.getElementById('editCommentForm');
            var commentContent = document.querySelector('.comment-content');

            // 댓글 내용 텍스트 영역 생성
            var textarea = document.createElement('textarea');
            textarea.name = 'editedContent';
            textarea.value = commentContent.innerText;

            // 수정 완료 버튼 생성
            var editButton = document.createElement('button');
            editButton.type = 'submit';
            editButton.textContent = '수정 완료';

            // 취소 버튼 생성
            var cancelButton = document.createElement('button');
            cancelButton.textContent = '취소';
            cancelButton.addEventListener('click', function () {
                editForm.style.display = 'none';
            });

            // 수정 폼에 내용 추가
            editForm.innerHTML = '';
            editForm.appendChild(textarea);
            editForm.appendChild(document.createElement('br'));
            editForm.appendChild(editButton);
            editForm.appendChild(cancelButton);

            // 수정 폼 표시
            editForm.style.display = 'block';

            // 댓글 내용 숨기기
            commentContent.style.display = 'none';
        }

        // 댓글 삭제
        function deleteComment() {
            if (confirm('댓글을 삭제하시겠습니까?')) {
                location.href = 'delete_reply.php?comment_id=<?php echo $commentId; ?>';
            }
        }

        // 팝업창 닫기
        function cancelEdit() {
            window.close();
        }
    </script>
</body>

</html>
