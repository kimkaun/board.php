<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>게시판 명단</title>
    <link rel="stylesheet" href="boardindex.css">
</head>
<body>
    <div class="table-container">
        <h2>게시판 명단</h2>
        <table border=1>
            <thead>
                <tr>
                    <th>글번호</th>
                    <th>글제목</th>
                    <th>작성자</th>
                    <th>작성날짜</th>
                    <th>이미지</th>
                    <th>조회수</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    // 데이터베이스 연결
                    include('./db_conn.php');

                    // board 테이블에서 필요한 데이터만 가져오기 (최신 게시물 순으로)
                    $sql = "SELECT id, title, name, DATE_FORMAT(created_at, '%Y-%m-%d') AS created_date, file_name, views FROM board ORDER BY id DESC";
                    $result = mysqli_query($conn, $sql);

                    $cnt = mysqli_num_rows($result);

                    // 게시물 데이터를 테이블에 출력
                    for ($i = 0; $i < $cnt; $i++) {
                        $a = mysqli_fetch_assoc($result);  // 한 행씩 가져옴
                        $file_name = $a['file_name'];
                        $image_html = "";

                        // 파일이 있을 경우 이미지 태그 생성
                        if (!empty($file_name)) {
                            $image_path = "uploads/" . $file_name; // 업로드된 파일 경로
                            $image_html = "<img src='$image_path' alt='첨부 이미지' class='thumbnail'>"; // 이미지 스타일 설정
                        }

                        // 게시글 제목을 클릭할 수 있게 링크로 만듦
                        echo "<tr>
                                <td>{$a['id']}</td>  <!-- 글번호 -->
                                <td><a href='board_detail.php?id={$a['id']}'>{$a['title']}</a></td>  <!-- 글제목 (링크로 연결) -->
                                <td>{$a['name']}</td>  <!-- 작성자 -->
                                <td>{$a['created_date']}</td>  <!-- 작성날짜 -->
                                <td>$image_html</td>  <!-- 이미지 -->
                                <td>{$a['views']}</td>  <!-- 조회수 -->
                            </tr>";
                    }

                    // 데이터베이스 연결 종료
                    mysqli_close($conn);
                ?>
            </tbody>
        </table>
        <div class="button-container">
            <a href="board.html">
                <input type="submit" class="button" value="게시물 작성">
            </a>
        </div>
    </div>
</body>
</html>
