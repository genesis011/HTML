<?php
  include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/db_connector.php";

  session_start();
  if(!(isset($_SESSION['id']) &&  $_SESSION['id']=="admin")){
    echo "<script>alert('권한없음!');history.go(-1);</script>";
    exit;
  }
?>
<meta charset="utf-8">
<?php
$sql= $result = $name="";
$name = $_SESSION['name'];
if(isset($_GET["mode"]) && $_GET["mode"]=="delete"){
    // ex )  admin/wooju00/minji00/
    $del_value= $_POST["del_value"];
    // 삭제할 아이디를 배열로 생성
    $del_ids = explode("/",$del_value);
  for ($i=0; $i < count($del_ids); $i++) {
      $sql ="DELETE FROM `member` WHERE `id`='$del_ids[$i]'";
      $result = mysqli_query($conn,$sql);
      if (!$result) {die('Error: ' . mysqli_error($conn));}
      $row=mysqli_fetch_array($result);
      $sql1= "DELETE FROM `bill` WHERE `b_id`='$del_ids[$i]';";                     mysqli_query($conn,$sql1);
      $sql2= "DELETE FROM `bus` WHERE `b_id`='$del_ids[$i]';";                      mysqli_query($conn,$sql2);
      $sql3= "DELETE FROM `cart` WHERE `c_id`='$del_ids[$i]';";                     mysqli_query($conn,$sql3);
      $sql4= "DELETE FROM `free` WHERE `id`='$del_ids[$i]';";                       mysqli_query($conn,$sql4);
      $sql5= "DELETE FROM `free_ripple` WHERE `id`='$del_ids[$i]';";                mysqli_query($conn,$sql5);
      $sql7= "DELETE FROM `member_review` WHERE `id`='$del_ids[$i]';";              mysqli_query($conn,$sql7);
      $sql8= "DELETE FROM `message` WHERE `recv_id`='$del_ids[$i]';";               mysqli_query($conn,$sql8);
      $sql9= "DELETE FROM `message` WHERE `send_id`='$del_ids[$i]';";               mysqli_query($conn,$sql9);
      $sql10="DELETE FROM `mt_information_ripple` WHERE `id`='$del_ids[$i]';";      mysqli_query($conn,$sql10);
      $sql11="DELETE FROM `official_review_ripple` WHERE `id`='$del_ids[$i]';";     mysqli_query($conn,$sql11);
      $sql12="DELETE FROM `qna` WHERE `id`='$del_ids[$i]';";                        mysqli_query($conn,$sql12);
      $sql13="DELETE FROM `reserve` WHERE `r_id`='$del_ids[$i]';";                  mysqli_query($conn,$sql13);
      $sql14="DELETE FROM `member` WHERE `id`='$del_ids[$i]';";                     mysqli_query($conn,$sql14);
  }
    mysqli_close($conn);
    echo "<script>location.href='./member_admin_list.php?num=$num';</script>";
}
?>
