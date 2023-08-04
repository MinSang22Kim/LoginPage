<?php
session_start();
$conn = mysqli_connect('localhost', 'root', 'alstkd9031', 'realMSDB') or die("connect failed");

$cate = $_GET['cate'];
$search = $_GET['search'];
$date1 = $_GET['date1'];
$date2 = $_GET['date2'];

// 데이터베이스에서 검색 쿼리 수행
if ($date1 && $date2) {
    $sql = "SELECT * FROM board WHERE $cate LIKE '%$search%' AND written BETWEEN '$date1' AND '$date2'";
} else {
    $sql = "SELECT * FROM board WHERE $cate LIKE '%$search%'";
}
$result = mysqli_query($conn, $sql);

// 검색 결과 수 계산
$total_post = mysqli_num_rows($result);
$per = 5;

// 페이지 번호 가져오기
if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}

// 페이지 시작 위치 계산
$start = ($page - 1) * $per;

// 페이지에 따른 데이터베이스 검색 쿼리 수행
if ($date1 && $date2) {
    $sql_page = "SELECT * FROM board WHERE $cate LIKE '%$search%' AND written BETWEEN '$date1' AND '$date2' ORDER BY number DESC LIMIT $start, $per";
} else {
    $sql_page = "SELECT * FROM board WHERE $cate LIKE '%$search%' ORDER BY number DESC LIMIT $start, $per";
}
$res_page = mysqli_query($conn, $sql_page);

// 검색 결과 출력
$total = $total_post;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>검색 결과창</title>
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
            var info = "";
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
    if (isset($_SESSION['userid'])) {
        ?>
        <b>사랑하는
            <?php echo $_SESSION['userid']; ?>
        </b>님 반가워요
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
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($res_page)) {
                if ($total % 2 == 0) {
                    echo '<tr class="even">';
                } else {
                    echo '<tr>';
                }
                ?>
                <td width="50" align="center">
                    <?php echo $total ?>
                </td>
                <td width="500" align="center">
                    <a href="read.php?number=<?php echo $row['number'] ?>">
                        <?php echo $row['title'] ?>
                    </a>
                </td>
                <td width="100" align="center">
                    <?php echo $row['id'] ?>
                </td>
                <td width="200" align="center">
                    <?php echo $row['date'] ?>
                </td>
                <td width="50" align="center">
                    <?php echo $row['hit'] ?>
                </td>
                </tr>
                <?php
                $total--;
            }
            ?>
            <?php
            if (!$total_post) {
                echo '
                    <tr style="color:black;" align="center">
                        <td></td>
                        <td>검색결과없음</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                ';
            }
            ?>
        </tbody>
    </table>
    <div class=bottom>
        <?php
        if ($page > 1) {
            echo "<a href=\"search.php?page=1&cate=$cate&search=$search&date1=$date1&date2=$date2\">[처음] </a>";
        }
        if ($page > 1) {
            $pre = $page - 1;
            echo "<a href=\"search.php?page=$pre&cate=$cate&search=$search&date1=$date1&date2=$date2\">이전 </a>";
        }
        $total_page = ceil($total_post / $per);
        $page_num = 1;
        while ($page_num <= $total_page) {
            if ($page == $page_num) {
                echo "<a style=\"color:hotpink;\" href=\"search.php?page=$page_num&cate=$cate&search=$search&date1=$date1&date2=$date2\">$page_num </a>";
            } else {
                echo "<a href=\"search.php?page=$page_num&cate=$cate&search=$search&date1=$date1&date2=$date2\">$page_num </a>";
            }
            $page_num++;
        }
        if ($page < $total_page) {
            $next = $page + 1;
            echo "<a href=\"search.php?page=$next&cate=$cate&search=$search&date1=$date1&date2=$date2\">다음 </a>";
        }
        if ($page < $total_page) {
            echo "<a href=\"search.php?page=$total_page&cate=$cate&search=$search&date1=$date1&date2=$date2\">[끝]</a>";
        }
        ?>
    </div>
    <form class="search-form" method="get" action="search.php">
        <select name="cate" id="search_opt" onchange="info()">
            <option value="title">제목</option>
            <option value="content">내용</option>
            <option value="name">작성자</option>
        </select>
        <input class="textform" type="text" name="search" id="search_box" autocomplete="off" value="<?= $search ?>"
            placeholder="제목을 입력하세요." required>
        <input class="submit" type="submit" value="검색">
        <p>
            <input type="date" value="<?= $date1 ?>" name="date1">
            ~
            <input type="date" value="<?= $date2 ?>" name="date2">
        </p>
    </form>
    <div class=text>
        <font style="cursor: hand" onClick="location.href='./write.php'">글쓰기</font>
    </div>
</body>

</html>
