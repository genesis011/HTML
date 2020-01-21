<?php
  //세션아이디가 관리자인지 확인
  session_start();

  // isset함수는 불리언값을 리턴 true or false
  // 회원 or 비회원이면 권한없음, 관리자일때만 입장
  if(!(isset($_SESSION['id']) &&  $_SESSION['id']=="admin")){
    echo "<script>alert('권한없음!');history.go(-1);</script>";
    exit;
  }

  // 인클루드 디비코넥터
  include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/db_connector.php";

  // 변수선언(번호 관리자 제목 내용 작성일 조회수 파일이름 파일실제주소 파일확장자)   // 체크 // 액션
  $num=$name=$title=$content=$regist_day=$hit=$file_name=$file_copied=$file_type=$checked=$actaction="";

  // 모드가 기본적으로 insert일때,
  $mode="insert";

  // 관리자이름 가져옴
  $name=$_SESSION['name'];
  if (isset($_GET["mode"]) && $_GET["mode"]=="update") {
    $mode="update";

    // num값을 문자열로 받아옴
    $num = test_input($_GET["num"]);

    // num을 방어해줌
    $q_num = mysqli_real_escape_string($conn, $num);

    //쿼리문
    $sql="SELECT * from `notice` where num ='$q_num';";

    //쿼리문 실행
    $result = mysqli_query($conn,$sql);

    //쿼리문 실행오류
    if (!$result) alert_back("Error: " . mysqli_error($conn));

    $row=mysqli_fetch_array($result);
    $title= htmlspecialchars($row['title']);
    $title=str_replace("\n", "<br>",$title);
    $title=str_replace(" ", "&nbsp;",$title);
    $content= htmlspecialchars($row['content']);
    $content=str_replace("\n", "<br>",$content);
    $content=str_replace(" ", "&nbsp;",$content);
    $file_name=$row['file_name'];
    $file_copied=$row['file_copied'];
    $file_type=$row['file_type'];
    $regist_day=$row['regist_day'];
    $hit=$row['hit'];
  }
?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/common/css/login_menu.css">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/customer_support/notice/css/notice_form.css">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/common/css/side_bar.css">
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function() {
        $("#not_mini").css("font-weight","bold");
        $("#not_mini").css("color","black");
      });
    </script>
    <!-- include libraries(jQuery, bootstrap) -->
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.css" rel="stylesheet">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script>
    <!-- include summernote css/js -->
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css" rel="stylesheet">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.js"></script>
    <script src="./js/notice_form.js?ver=0"></script>
    <title>공지사항</title>
  </head>
  <body>
    <header>
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/login_menu.php";?>
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/custom_menu.php";?>
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/side_bar.php";?>
    </header>
    <section id="notice">
      <form class="notice_insert_form" action="notice_query.php?mode=<?php echo $mode; ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="num" value="<?=$num?>">
        <input type="hidden" name="hit" value="<?=$hit?>">
        <table border="1">
          <tr><th>작성자</th><td style="width:600px; text-align:center;"><?php echo $name; ?></td></tr>
          <tr><th>제목</th><td><input type="text" style="font-size:15px; width:700px;" name="title" value="<?=$title?>"></td></tr>
          <tr><th>내용</th><td><textarea style="width:700px;" name="content" id="summernote"><?=$content?></textarea></td></tr>
          <tr><th>파일</th><td style="text-align:center;">
              <?php
                if($mode=="insert"){
                  echo '<input type="file" name="upfile" value="<?=$file_name?>">';
                }else{
              ?>
                <input type="file" name="upfile" onclick='document.getElementById("del_file").checked=true;'>
              <?php
                }
              ?>
              <?php
                if($mode=="update" && !empty($file_name)){
                  echo "$file_name 파일등록";
                  echo '<input type="checkbox" id="del_file" name="del_file" value="1" '.$checked.' >삭제';
                }
              ?>
            </td>
          </tr>
        </table>
        <div class="admin">
          <?php
            if (isset($_GET["mode"]) && $_GET["mode"]=="update") {
              $action='document.getElementById("del_file").disabled=false;';
            }
           ?>
          <button id="admin_write_btn" style="margin-left: 64%;" onclick='<?=$action?> document.notice_insert_form.submit();" type="button" name="button'>완료</button>
          <a href="./notice_list.php"><button id="admin_write_btn" type="button" name="button">목록</button></a>
        </div>
      </form>
    </section>
    <br><br>
    <footer>
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/footer.php";?>
    </footer>
  </body>
</html>
