<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <style>
        table.table2 {
            border-collapse: separate;
            border-spacing: 1px;
            text-align: left;
            line-height: 1.5;
            border-top: 1px solid #ccc;
            margin: 20px 10px;
        }

        table.table2 tr {
            width: 50px;
            padding: 10px;
            font-weight: bold;
            vertical-align: top;
            border-bottom: 1px solid #ccc;
        }

        table.table2 td {
            width: 100px;
            padding: 10px;
            vertical-align: top;
            border-bottom: 1px solid #ccc;
        }
    </style>
</head>

<body>
    <?php
    session_start();
    $URL = "./login.php";
    if (!isset($_SESSION['userid'])) {
        ?>

        <script>
            alert("로그인이 필요합니다.");
            location.replace("<?php echo $URL ?>");
        </script>
        <?php
    }
    ?>

    <form method="post" action="write_action.php">
        <!-- method를 get -> post로 바꿔야됨!! -->
        <table style="padding-top:50px" align=center width=auto border=0 cellpadding=2>
            <tr>
                <td style="height:40; float:center; background-color:#3C3C3C">
                    <p style="font-size:25px; text-align:center; color:white; margin-top:15px; margin-bottom:15px">
                        <b>게시글 작성하기</b></p>
                </td>
            </tr>
            <tr>
                <td bgcolor=white>
                    <table class="table2">
                        <tr>
                            <td>작성자</td>
                            <td><input type="hidden" name="name" value="<?= $_SESSION['userid'] ?>"><?= $_SESSION['userid'] ?></td>
                        </tr>

                        <tr>
                            <td>제목</td>
                            <td><input type="text" name="title" size=87></td>
                        </tr>

                        <tr>
                            <td>내용</td>
                            <td><textarea name="content" cols=75 rows=15></textarea></td>
                        </tr>
                        <tr>
                            <td>업로드</td>
                            <td><input type='file' name='myfile' enctype='multipart/form-data' action='upload_ok.php'
                                    method='post' size=87></td>
                        </tr>
                    </table>

                    <center>
                        <input style="height:26px; width:47px; font-size:16px;" type="submit" value="작성">
                    </center>
                </td>
            </tr>
        </table>
    </form>
</body>

</html>