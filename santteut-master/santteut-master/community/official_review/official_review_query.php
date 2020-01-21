<?php
//*************************************************************************
$id=$name=$mode=$title=$content=$q_title=$q_content=$regist_day=$main_img="";
$files=$count=$upload_dir="";
$q_num=$num=$file_extension="";
$file_copied_0=$file_copied_1=$file_copied_2=$file_copied_3=$file_copied_4="";
for($i=0;$i<5;$i++){
  $upfile_name[$i]="";
  $upfile_tmp_name[$i]="";
  $upfile_type[$i]="";
  $upfile_size[$i]="";
  $upfile_error[$i]="";
  $copied_file_name[$i]="";
  $type[$i][0]="";
}
//*************************************************************************
  include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/db_connector.php";
  session_start();
if(isset($_GET["mode"])&&$_GET["mode"]=="insert"){
  $title = trim($_POST["title"]);
  $content = trim($_POST["content"]);
  if(empty($content)||empty($title)){
    alert_back('제목과 내용 입력요망!');
  }
  $title = test_input($_POST["title"]);
  $content = $_POST["content"];
  $q_title = mysqli_real_escape_string($conn, $title);
  $q_content = mysqli_real_escape_string($conn, $content);
  $regist_day=date("Y-m-d (H:i)");
  $main_img = explode('<img src=', $_POST["content"]);
  if(count($main_img)<2){
      alert_back('이미지를 하나 이상 넣어주시기 바랍니다.');
  }
  $main_img = explode('/img/',$main_img[1]);
  $main_img = explode('"', $main_img[1]);
  $main_img =  $main_img[0];

  //include 파일업로드기능
  include $_SERVER['DOCUMENT_ROOT']."/santteut/community/official_review/lib/file_upload.php";

  //파일의 실제명과 저장된 파일명을 삽입한다.
  $sql = "INSERT INTO `official_review` VALUES (null, '$q_title', '$q_content', '$regist_day', '$main_img',
    '$upfile_name[0]', '$copied_file_name[0]', 'text',
    '$upfile_name[1]', '$copied_file_name[1]', 'text',
    '$upfile_name[2]', '$copied_file_name[2]', 'text',
    '$upfile_name[3]', '$copied_file_name[3]', 'text',
    '$upfile_name[4]', '$copied_file_name[4]', 'text');";

  $result = mysqli_query($conn,$sql);
  if(!$result){
    alert_back('Error: '.mysqli_error($conn));
  }

  $sql = "SELECT num FROM `official_review` ORDER BY num desc limit 1;";
  $result = mysqli_query($conn, $sql);
  if(!$result){
    alert_back('Error: ' .mysqli_error($conn));
  }
  $row = mysqli_fetch_array($result);
  $num = $row['num'];
  mysqli_close($conn);

  echo "<script>location.href='./official_review_view.php?num=$num';</script>";

}else if(isset($_GET["mode"])&&$_GET["mode"]=="delete"){
  if($_SESSION["id"]!=admin){
    alert_back('관리자가 아닙니다.');
  }
  $num = test_input($_GET["num"]);
  $q_num = mysqli_real_escape_string($conn, $num);

  //삭제할 파일의 파일명을 가져와서 삭제한다.
  $sql = "SELECT `file_copied_0`,`file_copied_1`,`file_copied_2`,`file_copied_3`,`file_copied_4` FROM `official_review` WHERE num='$q_num';";
  $result = mysqli_query($conn,$sql);
  if (!$result) {
    alert_back('Error: '.mysqli_error($conn));
  }
  $row = mysqli_fetch_array($result);
  $file_copied_0 = $row['file_copied_0'];
  $file_copied_1 = $row['file_copied_1'];
  $file_copied_2 = $row['file_copied_2'];
  $file_copied_3 = $row['file_copied_3'];
  $file_copied_4 = $row['file_copied_4'];

  if(!empty($file_copied_0)){
    unlink("./data/".$filed_copied_0);
  }
  if(!empty($file_copied_1)){
    unlink("./data/".$filed_copied_1);
  }
  if(!empty($file_copied_2)){
    unlink("./data/".$filed_copied_2);
  }
  if(!empty($file_copied_3)){
    unlink("./data/".$filed_copied_3);
  }
  if(!empty($file_copied_4)){
    unlink("./data/".$filed_copied_4);
  }

  $sql ="DELETE FROM `official_review` WHERE num='$q_num'";
  $result = mysqli_query($conn,$sql);
  if(!$result){
    die('Error:' .mysqli_error($conn));
  }
  mysqli_close($conn);
  echo "<script>location.href='./official_review_list.php';</script>";

}else if(isset($_GET["mode"]) && $_GET["mode"]=="update"){
  $content = trim($_POST["content"]);
  $title = trim($_POST["title"]);
  if(empty($content)||empty($title)){
    echo "<script>alert('내용이나 제목 입력요망!');history.go(-1);</script>";
    exit;
  }
  $num = test_input($_POST["num"]);
  $q_num = mysqli_real_escape_string($conn, $num);
  $title = test_input($_POST["title"]);
  $content = $_POST["content"];
  $q_title = mysqli_real_escape_string($conn, $title);
  $q_content = mysqli_real_escape_string($conn, $content);
  $regist_day=date("Y-m-d (H:i)");
  $main_img = explode('<img src=', $_POST["content"]);
  if(count($main_img)<2){
      alert_back('이미지를 하나 이상 넣어주시기 바랍니다.');
  }
  $main_img = explode('/img/',$main_img[1]);
  $main_img = explode('"', $main_img[1]);
  $main_img =  $main_img[0];

  include $_SERVER['DOCUMENT_ROOT']."/santteut/community/official_review/lib/file_upload.php";

  if(isset($_POST['del_file_0']) && $_POST['del_file_0'] =='1'){

    $sql = "UPDATE `official_review` SET `file_name_0` = '', `file_copied_0` = '' WHERE num = $q_num;";
    $result = mysqli_query($conn,$sql);
    if(!$result){
      die('Error: '. mysqli_error($conn));
    }

  }

  if(!empty($upfile_name[0])){
    $sql = "UPDATE `official_review` SET `file_name_0` = '$upfile_name[0]', `file_copied_0` = '$copied_file_name[0]' WHERE `num` = '$q_num';";
    $result = mysqli_query($conn, $sql);
    if(!$result){
      die('Error: '. mysqli_error($conn));
    }
  }

  if(isset($_POST['del_file_1']) && $_POST['del_file_1'] =='1'){

    $sql = "UPDATE `official_review` SET `file_name_1` = '', `file_copied_1` = '' WHERE `num` = '$q_num';";
    $result = mysqli_query($conn,$sql);
    if(!$result){
      die('Error: '. mysqli_error($conn));
    }
  }

  if(!empty($upfile_name[1])){
    $sql = "UPDATE `official_review` SET `file_name_1` = '$upfile_name[1]', `file_copied_1` = '$copied_file_name[1]' WHERE `num` = '$q_num';";
    $result = mysqli_query($conn, $sql);
    if(!$result){
      die('Error: '. mysqli_error($conn));
    }
  }

  if(isset($_POST['del_file_2']) && $_POST['del_file_2'] =='1'){


    $sql = "UPDATE `official_review` SET `file_name_2` = '', `file_copied_2` = '' WHERE `num` = '$q_num';";
    $result = mysqli_query($conn,$sql);
    if(!$result){
      die('Error: '. mysqli_error($conn));
    }

  }

  if(!empty($upfile_name[2])){
    $sql = "UPDATE `official_review` SET `file_name_2` = '$upfile_name[2]', `file_copied_2` = '$copied_file_name[2]' WHERE `num` = '$q_num';";
    $result = mysqli_query($conn, $sql);
    if(!$result){
      die('Error: '. mysqli_error($conn));
    }
  }

  if(isset($_POST['del_file_3']) && $_POST['del_file_3'] =='1'){

    $sql = "UPDATE `official_review` SET `file_name_3` = '', `file_copied_3` = '' WHERE `num` = '$q_num';";
    $result = mysqli_query($conn,$sql);
    if(!$result){
      die('Error: '. mysqli_error($conn));
    }

  }

  if(!empty($upfile_name[3])){
    $sql = "UPDATE `official_review` SET `file_name_3` = '$upfile_name[3]', `file_copied_3` = '$copied_file_name[3]' WHERE `num` = '$q_num';";
    $result = mysqli_query($conn, $sql);
    if(!$result){
      die('Error: '. mysqli_error($conn));
    }
  }

  if(isset($_POST['del_file_4']) && $_POST['del_file_4'] =='1'){

    $sql = "UPDATE `official_review` SET `file_name_4` = '', `file_copied_4` = '' WHERE `num` = '$q_num';";
    $result = mysqli_query($conn,$sql);
    if(!$result){
      die('Error: '. mysqli_error($conn));
    }

  }

  if(!empty($upfile_name[4])){
    $sql = "UPDATE `official_review` SET `file_name_4` = '$upfile_name[4]', `file_copied_4` = '$copied_file_name[4]' WHERE `num` = '$q_num';";
    $result = mysqli_query($conn, $sql);
    if(!$result){
      die('Error: '. mysqli_error($conn));
    }
  }

  $sql = "UPDATE `official_review` SET `title` = '$q_title', `content` = '$q_content', `regist_day` = '$regist_day', `main_img` = '$main_img' WHERE num = '$q_num';";
  $result = mysqli_query($conn, $sql);
  if (!$result){
    die('Error: '.mysqli_error($conn));
  }

  echo "<script>location.href='./official_review_view.php?num=$num';</script>";
}else if(isset($_GET["mode"]) && $_GET["mode"] == "insert_ripple"){
  if(empty($_POST["ripple_content"])){
    echo "<script>alert('댓글 내용을 입력하세요.');history.go(-1);</script>";
    exit;
  }
  if(empty($_SESSION['id']) || empty($_SESSION['name'])){
    echo "<script>alert('로그인 후 이용해주세요.');history.go(-1);</script>";
    exit;
  }else{
  $content = test_input($_POST["ripple_content"]);
  $parent = test_input($_POST["parent"]);
  $q_id = mysqli_real_escape_string($conn, $_SESSION['id']);
  $q_name = mysqli_real_escape_string($conn, $_SESSION['name']);
  $q_content = mysqli_real_escape_string($conn, $content);
  $q_parent = mysqli_real_escape_string($conn, $parent);
  $regist_day = date("Y-m-d (H:i)");

  $sql = "INSERT INTO `official_review_ripple` VALUES (null, '$q_parent', '$q_id', '$q_name', '$q_content', '$regist_day')";
  $result = mysqli_query($conn, $sql);
  if(!$result){
    die('Error: ' . mysqli_error($conn));
  }
  mysqli_close($conn);
  echo "<script>location.href='./official_review_view.php?num=$parent';</script>";
}

}else if(isset($_GET["mode"]) && $_GET["mode"] == "delete_ripple"){
  $ripple_num = $_POST['num'];
  $sql = "SELECT * FROM `official_review_ripple` WHERE num='$ripple_num';";
  $result = mysqli_query($conn, $sql);
  if(!$result){
    alert_back('Error: ' .mysqli_error($conn));
  }
  $row = mysqli_fetch_array($result);
  $id = $row['id'];

  if(!($_SESSION["id"]=="admin" || $id==$_SESSION["id"])){
    alert_back('삭제 권한이 없습니다.');
  }
  $num = test_input($_POST["num"]);
  $parent = test_input($_POST["parent"]);
  $q_num = mysqli_real_escape_string($conn, $num);
  $sql = "DELETE FROM `official_review_ripple` WHERE num=$q_num";
  $result = mysqli_query($conn, $sql);
  if(!$result){
    die('Error: '.mysqli_error($conn));
  }
  mysqli_close($conn);
  echo "<script>location.href='official_review_view.php?num=$parent';</script>";
}
?>
