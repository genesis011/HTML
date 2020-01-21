<?php
  session_start();

  if(!isset($_SESSION['id'])){
    echo "<script>alert('회원가입 후 이용해주세요.');history.go(-1);</script>";
    exit;
  }
  if(!isset($conn)){
    include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/db_connector.php";
  }

  $num=$name=$title=$content=$regist_day=$hit=$secret="";
  if(empty($_GET['page'])){$page=1;}else{$page=$_GET['page'];}
  if(empty($_GET['hit'])){$hit=1;}else{$hit=$_GET['hit'];}
  if(isset($_GET["num"]) && !empty($_GET["num"])){
      $num = test_input($_GET["num"]);
      $hit = test_input($_GET["hit"]);
      $q_num = mysqli_real_escape_string($conn, $num);
      $sql="UPDATE `qna` SET `hit`=$hit WHERE `num`='$q_num';";
      $result = mysqli_query($conn,$sql);
      if (!$result) {die('Error: ' . mysqli_error($conn));}
      $sql="SELECT num, groupnum, depth, ord, name, `qna`.id, title, content, regist_day, hit, pw FROM `qna` inner join member on `qna`.`id` = `member`.`id` WHERE num=$q_num;";
      $result = mysqli_query($conn,$sql);
      if (!$result) {die('Error: ' . mysqli_error($conn));}
      $row=mysqli_fetch_array($result);
      $hit=$row['hit'];
      $pw=$row['pw'];
      $id=$row['id'];
      $name1=$row['name'];
      $title= htmlspecialchars($row['title']);
      $content= $row['content'];
      $title=str_replace("\n", "<br>",$title);
      $title=str_replace(" ", "&nbsp;",$title);
      $regist_day=$row['regist_day'];
  }
?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/common/css/login_menu.css">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/customer_support/qna/css/qna_view.css?ver=1">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/common/css/side_bar.css">
    <script type="text/javascript" src="./js/qna_view.js?ver=1"></script>
    <title>문의하기</title>
    <style media="screen">
      #qna img{
        max-width:400px;
      }
    </style>
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function() {
        $("#qna_mini").css("font-weight","bold");
        $("#qna_mini").css("color","black");
      });
    </script>
  </head>
  <body>
    <header>
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/login_menu.php";?>
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/custom_menu.php";?>
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/side_bar.php";?>
    </header>
    <br><br><br>
    <section id="qna">
      <table border="1">
        <tr><th>작성자</th><td style=><?=$name1?></td></tr>
        <tr><th>제목</th><td><?=$title?></td></tr>
        <tr style="height:400px;">
          <th>내용</th>
          <?php
            $content=str_replace('<p>','', $content);
            $content=str_replace('</p>','', $content);
          ?>
          <td><?=$content?></td>
        </tr>
        <tr>
          <?php
            if(empty($pw)){
              $secret = "공개글";
            }else{
              $secret = "비밀글";
            }
           ?>
          <th>공개여부</th>
          <td><?=$secret?></td>
        </tr>
      </table>
      <div class="admin">
      <?php
        if($_SESSION['id']=="admin"){
          echo "<a href='./qna_form.php?mode=response&num=$num' ><button id='admin_write_btn' type='button' name='button' >답글</button></a>";
        }
      ?>
      <a href="./qna_form.php?mode=update&num=<?=$num?>"><button id="admin_write_btn" type="button" name="button">수정</button></a>
      <button id="admin_write_btn" type="button" name="button" onclick="check_delete(<?=$num?>)">삭제</button>
      <a href="./qna_list.php?page=<?=$page?>"><button id="admin_write_btn" type="button" name="button">목록</button></a>
    </div>
    </section>
    <br>
    <br>
    <footer>
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/footer.php";?>
    </footer>
  </body>
</html>
