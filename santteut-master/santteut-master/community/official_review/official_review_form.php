<?php
//**********************************************************************
$mode=$num=$q_num=$sql=$result=$row="";
$file_name_0=$file_copied_0=$file_type_0="";
$file_name_1=$file_copied_1=$file_type_1="";
$file_name_2=$file_copied_2=$file_type_2="";
$file_name_3=$file_copied_3=$file_type_3="";
$file_name_4=$file_copied_4=$file_type_4="";
$title=$content=$regist_day=$checked="";
//**********************************************************************
session_start();
if($_SESSION['id']!="admin"){
  echo "<script>alert('관리자가 아닙니다.');history.go(-1);</script>";
  exit;
}
include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/db_connector.php";
$mode="insert";
if(isset($_GET["mode"]) && $_GET["mode"]=='update'){
  $mode = "update";
  $num = test_input($_GET["num"]);
  $q_num = mysqli_real_escape_string($conn, $num);

  $sql = "SELECT * FROM `official_review` WHERE num='$q_num';";
  $result = mysqli_query($conn, $sql);
  if(!$result){
    die('Error: '.mysqli_error($conn));
  }
  $row=mysqli_fetch_array($result);
  $file_name_0 = $row['file_name_0'];
  $file_copied_0 = $row['file_copied_0'];
  $file_type_0 = $row['file_type_0'];
  $file_name_1 = $row['file_name_1'];
  $file_copied_1 = $row['file_copied_1'];
  $file_type_1 = $row['file_type_1'];
  $file_name_2 = $row['file_name_2'];
  $file_copied_2 = $row['file_copied_2'];
  $file_type_2 = $row['file_type_2'];
  $file_name_3 = $row['file_name_3'];
  $file_copied_3 = $row['file_copied_3'];
  $file_type_3 = $row['file_type_3'];
  $file_name_4 = $row['file_name_4'];
  $file_copied_4 = $row['file_copied_4'];
  $file_type_4 = $row['file_type_4'];

  //script 오류 방어
  $title = htmlspecialchars($row['title']);
  $title = str_replace("\n", "<br>", $title);
  $title = str_replace(" ", "&nbsp;", $title);

  $content = $row['content'];
  $regist_day = $row['regist_day'];

}
?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/common/css/login_menu.css">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/community/official_review/css/official_review_form.css">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/common/css/side_bar.css">
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function() {
        $("#official_mini").css("font-weight","bold");
        $("#official_mini").css("color","black");
      });
      </script>
    <!-- include libraries(jQuery,bootstrap) -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.css" rel="stylesheet">
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script>
    <!-- include summernote css/js -->
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.js"></script>
    <script src="./js/official_review_form.js?ver=0"></script>
    <script type="text/javascript">
    </script>
    <title>공식산행후기</title>
  </head>
  <body>
    <header>
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/login_menu.php";?>
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/commu_menu.php";?>
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/side_bar.php";?>
    </header>

    <section id="notice">
      <form name="board_form" action="official_review_query.php?mode=<?=$mode?>" method="post" enctype="multipart/form-data">
      <input type="hidden" name="num" value="<?=$num?>">
      <table border="1">
        <tr>
          <th>작성자</th>
          <td style="width:600px; text-align:center;">관리자</td>
        </tr>
        <tr>
          <th>제목</th>
          <td><input type="text" name="title" value="<?=$title?>" style="font-size:15px; width:700px;"></td>
        </tr>
        <tr>
          <th>내용</th>
          <td><textarea style="width:700px;" name="content" id="summernote"><?=$content?></textarea></td>
        </tr>
        <tr>
          <th>파일</th>
          <td style="text-align: center;">
            <?php
            if($mode=="insert"){
             echo '<input type="file" name="upfile[]">';
              echo '<input type="file" name="upfile[]">';
              echo '<input type="file" name="upfile[]">';
              echo '<input type="file" name="upfile[]">';
              echo '<input type="file" name="upfile[]">';
            }else{
             ?>
             <input type="file" name="upfile[]" onclick='document.getElementById("del_file_0").checked=true;'>
             <?php
             if($mode=="update" && !empty($file_name_0)){
               echo "$file_name_0 파일등록";
               echo '<input type="checkbox" id="del_file_0" name="del_file_0" value="1">삭제';
               echo '<div class="clear"></div>';
             }
             ?>
             <input type="file" name="upfile[]" onclick='document.getElementById("del_file_1").checked=true;'>
             <?php
               if($mode=="update" && !empty($file_name_1)){
                 echo "$file_name_1 파일등록";
                 echo '<input type="checkbox" id="del_file_1" name="del_file_1" value="1">삭제';
                 echo '<div class="clear"></div>';
               }
              ?>
              <input type="file" name="upfile[]" onclick='document.getElementById("del_file_2").checked=true;'>
              <?php
                if($mode=="update" && !empty($file_name_2)){
                  echo "$file_name_2 파일등록";
                  echo '<input type="checkbox" id="del_file_2" name="del_file_2" value="1">삭제';
                  echo '<div class="clear"></div>';
                }
               ?>
               <input type="file" name="upfile[]" onclick='document.getElementById("del_file_3").checked=true;'>
               <?php
                 if($mode=="update" && !empty($file_name_3)){
                   echo "$file_name_3 파일등록";
                   echo '<input type="checkbox" id="del_file_3" name="del_file_3" value="1">삭제';
                   echo '<div class="clear"></div>';
                 }
                ?>
                <input type="file" name="upfile[]" onclick='document.getElementById("del_file_4").checked=true;'>
                <?php
                  if($mode=="update" && !empty($file_name_4)){
                    echo "$file_name_4 파일등록";
                    echo '<input type="checkbox" id="del_file_4" name="del_file_4" value="1">삭제';
                    echo '<div class="clear"></div>';
                  }
                }
               ?>
          </td>
        </tr>
      </table>
      <div id="write_button">
        <input id="submit_ok" type="submit" value="완료">&nbsp;
        <a href="./official_review_list.php"><input type="button" value="목록"></a>
      </div><!--end of write_button-->
    </form>
    </section>
    <br>

    <br>
    <footer>
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/footer.php"; ?>
    </footer>
  </body>
</html>
