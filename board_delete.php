<?php
// db_conn.php를 통해 데이터베이스 연결
include('./db_conn.php');

// 게시글 id 가져오기
$id = isset($_GET['id']) ? $_GET['id'] : 0;

if ($id > 0) {
    // 게시글 조회 쿼리
    $sql = "SELECT * FROM board WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // 게시글 데이터 가져오기
        $row = mysqli_fetch_assoc($result);
        $stored_password = $row['password'];  // 게시글에 저장된 비밀번호
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

// 비밀번호 확인 후 삭제 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'])) {
    $password = $_POST['password'];

    // 비밀번호가 맞으면 삭제
    if ($password === $stored_password) {
        $delete_sql = "DELETE FROM board WHERE id = $id";
        if (mysqli_query($conn, $delete_sql)) {
            echo "<script>alert('게시글이 삭제되었습니다.');</script>";
            echo "<meta http-equiv='refresh' content='0;URL=boardindex.php'>"; // 게시판 목록으로 리다이렉트
        } else {
            echo "<script>alert('게시글 삭제 실패');</script>";
            echo "<meta http-equiv='refresh' content='0;URL=boardindex.php'>"; // 게시판 목록으로 리다이렉트
        }
    } else {
        echo "<script>alert('비밀번호가 틀렸습니다.');</script>";
        echo "<meta http-equiv='refresh' content='0;URL=boardindex.php'>"; // 게시판 목록으로 리다이렉트
    }
}

// 데이터베이스 연결 종료
mysqli_close($conn);
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>게시글 삭제</title>
    <link rel="stylesheet" href="board_delete.css">
  </head>
  <body>
      <div class="content-container">
          <h2>게시글 삭제</h2>
          <form action="board_delete.php?id=<?php echo $id; ?>" method="POST">
              <input type="password" name="password" placeholder="비밀번호 확인" required>
              <input type="submit" value="삭제">
          </form>
      </div>
  </body>
</html>
