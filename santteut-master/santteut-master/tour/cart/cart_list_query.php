<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/db_connector.php";
$c_id=$_SESSION['id'];
if(isset($_GET["mode"]) && isset($_GET["code"]) && $_GET["mode"]=="insert"){
  $c_code=$_GET["code"];
  $check_sql = "SELECT * FROM `cart` where `c_code`='$c_code' and `c_id`='$c_id';";
  $check_result = mysqli_query($conn,$check_sql);
  $check_rows=mysqli_num_rows($check_result);
  if($check_rows!=0){
    echo "<script>alert('이미 장바구니에 있습니다.');
        history.go(-1);
        </script>";
  }else{
    if(empty($c_id)){
      echo "<script>alert('로그인 해주세요.');
          location.href='../../member/login/login.php';
          </script>";
    }else{
      echo "<script>alert('장바구니에 담았습니다.');
          </script>";
      $sql = "INSERT INTO `cart` VALUES ('$c_code','$c_id');";

      $result = mysqli_query($conn,$sql);
      if (!$result) {
        alert_back('Error:5 ' . mysqli_error($conn));
        // die('Error: ' . mysqli_error($conn));
      }
    }
  }
}
if(isset($_POST['output'])){
  $output=$_POST['output'];
  $explode = explode("/", $output);

  for($i=1;$i<=count($explode); $i++){
    $del_sql = "DELETE FROM `cart` where `c_code`='$explode[$i]' and `c_id`='$c_id';";
    mysqli_query($conn,$del_sql);
  }
  if(count($explode)!=1){
      echo "<script>alert('삭제되었습니다.');location.href='cart_list.php';</script>";
  }else{
    echo "<script>alert('체크해주세요.');location.href='cart_list.php';</script>";
  }
}
$select_sql ="SELECT * from `package` join `cart` on `package`.`p_code`=`cart`.`c_code` where `cart`.`c_id`='$c_id';";
$s_result = mysqli_query($conn,$select_sql);
$total_record=mysqli_num_rows($s_result);

?>
