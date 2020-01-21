<?php
  include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/db_connector.php";
  if(isset($_GET['mode']) && $_GET['mode']=='pass'){
    $num = $_POST['num'];
    $pw = $_POST['pw'];
    $sql = "SELECT `pw`,`hit` FROM `qna` WHERE `num` = '$num';";
    $result = mysqli_query($conn,$sql);
    if (!$result) {die('Error: ' . mysqli_error($conn));}
    $row=mysqli_fetch_array($result);
    $real_pw=$row['pw'];
    $hit=$row['hit'];
    $hit = $hit +1;
    if($pw==$real_pw){
      echo "<script>location.href='./qna_view.php?num=$num&hit=$hit';</script>";
    }else{
      echo "<script>alert('비밀번호가 일치하지 않습니다.')</script>";
      echo "<script>history.go(-1);</script>";
    }
  }
?>
