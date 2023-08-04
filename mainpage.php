<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <style>
        table {
            border-top: 1px solid #444444;
            border-collapse: collapse;
        }

        tr {
            border-bottom: 1px solid #444444;
            padding: 10px;
        }

        td {
            border-bottom: 1px solid #efefef;
            padding: 10px;
        }

        table .even {
            background: #efefef;
        }

        .text {
            text-align: center;
            padding-top: 20px;
            color: #000000
        }

        .text:hover {
            text-decoration: underline;
        }

        a:link {
            color: #57A0EE;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
    <script>
        function info() {
            var opt = document.getElementById("search_opt");
            var opt_val = opt.options[opt.selectedIndex].value;
            var info = ""
            if (opt_val == 'title') {
                info = "제목을 입력하세요.";
            } else if (opt_val == 'content') {
                info = "내용을 입력하세요.";
            } else if (opt_val == 'name') {
                info = "작성자를 입력하세요.";
            }
            document.getElementById("search_box").placeholder = info;
        }
    </script>
    <style>
        .search-form {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }

        .search-form select,
        .search-form input[type="text"],
        .search-form input[type="submit"] {
            height: 30px;
        }

        .search-form select {
            margin-right: 10px;
        }

        .search-form input[type="text"] {
            flex-grow: 1;
        }

        .search-form input[type="submit"] {
            width: 70px;
            background-color: #57A0EE;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <?php
    $connect = mysqli_connect('20.196.222.1', 'root', 'alstkd9031', 'realMSDB') or die("connect failed");
    $query = "select board.*, count(reply.idx) as reply_count from board left join reply on board.number = reply.con_num group by board.number order by board.number desc"; // 게시글과 댓글 개수를 함께 가져오는 쿼리
    $result = mysqli_query($connect, $query);
    $total = mysqli_num_rows($result);

    session_start();

    if (isset($_SESSION['userid'])) {
        ?><b>사랑하는
        <?php echo $_SESSION['userid']; ?>
    </b>님 반가워용
    <button onclick="location.href='./logout_action.php'" style="float:right; font-size:15.5px;">로그아웃</button>
    <br />
    <?php
    } else {
        ?>
        <button onclick="location.href='./login.php'" style="float:right; font-size:15.5px;">로그인</button>
        <br />
        <?php
    }
    ?>

    <p style="font-size:25px; text-align:center"><b> MS게시판</b></p>

    <table align=center>
        <thead align="center">
            <tr>
                <td width="50" align="center">번호</td>
                <td width="500" align="center">제목</td>
                <td width="100" align="center">작성자</td>
                <td width="200" align="center">날짜</td>
                <td width="50" align="center">조회수</td>
                <td width="50" align="center">댓글수</td> <!-- 추가된 부분 -->
            </tr>
        </thead>

        <tbody>
            <?php
            while ($rows = mysqli_fetch_assoc($result)) {
                if ($total % 2 == 0) {
                    ?>
                    <tr class="even">
                    <?php } else {
                    ?>
                    <tr>
                    <?php } ?>
                <td width="50" align="center">
                    <?php echo $total ?>
                </td>
                <td width="500" align="center">
                    <a href="read.php?number=<?php echo $rows['number'] ?>">
                        <?php echo $rows['title'] ?>
                    </a>
                </td>
                <td width="100" align="center">
                    <?php echo $rows['id'] ?>
                </td>
                <td width="200" align="center">
                    <?php echo $rows['date'] ?>
                </td>
                <td width="50" align="center">
                    <?php echo $rows['hit'] ?>
                </td>
                <td width="50" align="center">
                    <?php echo $rows['reply_count'] ?>
                </td> <!-- 추가된 부분 -->
            </tr>
            <?php
            $total--;
            }
            ?>
        </tbody>
    </table>

    <form class="search-form" method="get" action="search.php">
        <select name="cate" id="search_opt" onchange="info()">
            <option value=title>제목</option>
            <option value=content>내용</option>
            <option value=name>작성자</option>
        </select>
        <input class="textform" type="text" name="search" id="search_box" autocomplete="off" placeholder="제목을 입력하세요."
            required>
        <input class="submit" type="submit" value="검색">
        <p>
            <input type="date" name="date1">
            ~
            <input type="date" name="date2">
        </p>
    </form>

    <div class=text>
        <font style="cursor: hand" onClick="location.href='./write.php'">글쓰기</font>
    </div>

</body>

</html>
