<?php
// db_conn.php를 통해 데이터베이스 연결
include('./db_conn.php');

// 게시글 id 가져오기
$id = isset($_GET['id']) ? $_GET['id'] : 0;  // URL에서 'id' 값 가져오기

if ($id > 0) {
    // 게시글 조회수 증가 쿼리
    $update_views_sql = "UPDATE board SET views = views + 1 WHERE id = $id";
    mysqli_query($conn, $update_views_sql);

    // 게시글 조회 쿼리
    $sql = "SELECT * FROM board WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // 게시글 데이터 가져오기
        $row = mysqli_fetch_assoc($result);
        $title = $row['title'];
        $name = $row['name'];
        $created_at = $row['created_at'];
        $content = nl2br($row['content']);  // 줄바꿈 처리
        $views = $row['views'];  // 조회수
    } else {
        echo "<script>alert('존재하지 않는 게시글입니다.');</script>";
        echo "<meta http-equiv='refresh' content='0;URL=boardindex.php'>"; // 게시판 목록 페이지로 돌아가기
        exit;
    }
} else {
    echo "<script>alert('잘못된 접근입니다.');</script>";
    echo "<meta http-equiv='refresh' content='0;URL=boardindex.php'>"; // 게시판 목록 페이지로 돌아가기
    exit;
}

// 데이터베이스 연결 종료
mysqli_close($conn);
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>게시글 상세보기</title>
    <link rel="stylesheet" href="board_detail.css">
  </head>
  <body>
      <div class="content-container">
          <h2>게시글 상세보기</h2>
          <table border=1>
              <tr>
                  <th>제목</th>
                  <td><?php echo htmlspecialchars($title); ?></td>
              </tr>
              <tr>
                  <th>작성자</th>
                  <td><?php echo htmlspecialchars($name); ?></td>
              </tr>
              <tr>
                  <th>작성일</th>
                  <td><?php echo $created_at; ?></td>
              </tr>
              <tr>
                  <th>내용</th>
                  <td><?php echo $content; ?></td>
              </tr>
          </table>
          <a href="boardindex.php">
                <input type="button" class="button" value="목록으로 돌아가기">
          </a>
          <a href="board_delete.php?id=<?php echo $id; ?>">
                <input type="button" class="button" value="삭제">
          </a>
          <a href="board_update.php?id=<?php echo $id; ?>">
                <input type="button" class="button" value="수정">
          </a>
      </div>
  </body>
</html>
