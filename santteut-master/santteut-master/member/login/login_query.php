<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/db_connector.php";

$login_id =$_POST["login_id"];
$login_id = mysqli_real_escape_string($conn, test_input($login_id));
$login_passwd =$_POST["login_passwd"];
$login_passwd = mysqli_real_escape_string($conn, test_input($login_passwd));

  if(empty($_POST["login_id"])){
    echo '<script>alert("ID를 입력하세요.");</script>';
    return;
  }else if(empty($_POST["login_passwd"])){
    echo '<script>alert("패스워드를 입력하세요.");</script>';
    return;
  }else{
    $sql="SELECT `id`, `name` FROM member where `id` = '$login_id' and `passwd`= '$login_passwd'";
    $result = mysqli_query($conn,$sql);
    if (!$result) {
      die('Error: ' . mysqli_error($conn));
    }

    $row=mysqli_fetch_array($result);

    if(empty($row['id'])){
      echo '<script>alert("아이디 또는 패스워드 오류입니다.");history.go(-1);</script>';
      exit;
    }

    $_SESSION['id']= $row['id'];
    $_SESSION['name']= $row['name'];

    header("Location:../../index.php");
 }

 ?>
