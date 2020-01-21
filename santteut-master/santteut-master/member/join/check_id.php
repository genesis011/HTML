<?php
include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/db_connector.php";
$join_id =$_POST["join_id"];
  if(empty($_POST["join_id"])){
    echo "아이디값이 없습니다. 아이디값을 입력하세요";
    return;
  }else{
    $sql="SELECT * FROM member where id = '$join_id'";
    $result = mysqli_query($conn,$sql);
    if (!$result) {
      die('Error: ' . mysqli_error($conn));
    }
    $rowcount=mysqli_num_rows($result);
    // var_dump($rowcount);
    if ($rowcount) {
       $s = '아이디가 이미 존재합니다.';
     } else {
      $s = '사용가능합니다.';
     }
      echo $s;
   }
 ?>
