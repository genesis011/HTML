<!DOCTYPE html>
<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/db_connector.php";
?>

<html lang="ko" dir="ltr">
<?php
function free_ripple_delete($id1,$num1,$page1,$page,$hit,$parent){
  $message="";
  if($_SESSION['id']=="admin"||$_SESSION['id']==$id1){
    $message='<form style="display:inline" action="'.$page1.'?mode=delete_ripple&page='.$page.'&hit='.$hit.'" method="post">
    <input type="hidden" name="num" value="'.$num1.'">
    <input type="hidden" name="parent" value="'.$parent.'">
    <input type="submit" value="삭제">
    </form>';
  }
  return $message;
}
$num = test_input($_GET["num"]);
$page = test_input($_GET["page"]);
$hit = test_input($_GET["hit"]);
$q_num = mysqli_real_escape_string($conn, $num);

$sql="UPDATE `free` SET `hit`=$hit WHERE `num`=$q_num;";
$result = mysqli_query($conn,$sql);
if (!$result) {
  die('Error: ' . mysqli_error($conn));
}

 ?>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/common/css/login_menu.css">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/community/free/css/free_view.css">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/common/css/side_bar.css">
    <script type="text/javascript" src="./js/free_view.js?ver=1"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function() {
        $("#free_mini").css("font-weight","bold");
        $("#free_mini").css("color","black");
      });
      function check_delete(num) {
        var result=confirm("삭제하시겠습니까?");
        if(result){
              window.location.href='./free_query.php?mode=delete&num='+num;
        }
      }
      </script>
    <title>자유게시판</title>
  </head>
  <body>
    <header>
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/login_menu.php";?>
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/commu_menu.php";?>
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/side_bar.php";?>
    </header>
    <?php $sql="SELECT * from `free` where num ='$q_num';";
    $result = mysqli_query($conn,$sql);
    if (!$result) {
      die('Error: ' . mysqli_error($conn));
    }
    $row=mysqli_fetch_array($result);
    $id=$row['id'];
    $name=$row['name'];
    $title=$row['title'];
    $content= $row['content'];
    $destination= $row['destination'];
    $file_name= $row['file_name'];
    $update= $row['del'];
    $day=$row['regist_day'];
    $hit=$row['hit']; ?>

    <section id="free">
      <table border="1">
        <tr>
          <th>작성자</th>
          <td style="width:600px; text-align:center;"><?=$name?></td>
        </tr>
        <tr>
          <th>제목</th>
          <td><?=$title?></td>
        </tr>

        <tr style="height:400px;">
          <th>내용</th>
          <td>

            <?=$content?>
          </td>
        </tr>
        <tr>
          <th>파일</th>
          <td style="text-align:center; text-decoration: none;">
          <?php
          if(!empty($_SESSION['id'])&&!empty($destination)){
          $file_size = filesize($destination)/1024;
          $file_size = floor($file_size);
            echo ("
              첨부파일 : $file_nsame &nbsp; [ $file_size KB]
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <a href='free_download.php?mode=download&num=$num'>저장</a><br><br>
            ");
          }
             ?>
          </td>
        </tr>
      </table>

    <div class="admin">
      <?php
      //관리자일경우 수정,삭제가 가능하도록 설정
      if($_SESSION['id']=="admin" || $_SESSION['id']==$id){
        echo ('<a href="./free_form.php?mode=update&num='.$num.'"><input type="button" value="수정">&nbsp;</a>&nbsp;');
        echo ('<input type="button" value="삭제" onclick="check_delete('.$num.')">&nbsp;</a>&nbsp;');
        echo ('<a href="./free_list.php?page='.$page.'"><input type="button" value="목록">&nbsp;</a>');
      }else{
        echo ('<div class="mt_list" style="margin-left: 25.5%;">
        <a href="./free_list.php?page='.$page.'"><input type="button" value="목록">&nbsp;</a>
        </div>');
      }
      ?>
    </div>

<!--여기서부터 댓글 ui추가됨 -->
 <!-- 댓글부분  -->
    <table id="ripple_tb" border="1">
      <th>댓글</th>
      <td>
        <?php
        $sql="select * from `free_ripple` where parent='$q_num' ";
        $ripple_result= mysqli_query($conn,$sql);
        while($ripple_row=mysqli_fetch_array($ripple_result)){
          $ripple_num=$ripple_row['num'];
          $ripple_id=$ripple_row['id'];
          $ripple_date=$ripple_row['regist_day'];
          $ripple_name=$ripple_row['name'];
          $ripple_content=$ripple_row['content'];
          $ripple_content=str_replace("\n", "<br>",$ripple_content);
          $ripple_content=str_replace(" ", "&nbsp;",$ripple_content);
        ?>
        <div id="ripple_title">
            <ul>
              <li><?=$ripple_name."&nbsp;&nbsp;".$ripple_date?></li>
              <li id="mdi_del">
              <?php
              $message=free_ripple_delete($ripple_id,$ripple_num,'free_query.php',$page,$hit,$q_num);
              echo $message;
              ?>
              </li>
            </ul>
          </div>
          <div id="ripple_content">
            <?=$ripple_content?>
          </div>
          <?php
          }//end of while
          mysqli_close($conn);
          ?>
          <form name="ripple_form" action="free_query.php?mode=insert_ripple" method="post">
          <input type="hidden" name="parent" value="<?=$q_num?>">
          <input type="hidden" name="page" value="<?=$page?>">
          <input type="hidden" name="hit" value="<?=$hit?>">
          <div class="ripple_textarea">

  <textarea name="ripple_content" rows="3" cols="80"></textarea>

<input id="ripple_button" type="submit" value="댓글입력">

          </div>
          </form>
      </td>
    </table>
<!--댓글의 끝-->

    </section>
    <br>
    <br>
    <footer>
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/footer.php";?>
    </footer>
  </body>
</html>
