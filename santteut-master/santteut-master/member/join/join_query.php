<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/db_connector.php";
if($_GET['mode']=="update"){

$id = $_GET['id'];
$join_passwd = $_POST["join_passwd"];
$join_passwdconfirm = $_POST["join_passwdconfirm"];
$join_name= $_POST["join_name"];
$join_zip= $_POST["join_zip"];
$join_foundational= $_POST["join_foundational"];
$join_detail= $_POST["join_detail"];

$sql="UPDATE `member` SET `passwd`='$join_passwd', `passwd_confirm` ='$join_passwdconfirm' , `name` ='$join_name', `zip` ='$join_zip' , `address1` ='$join_foundational' , `address2` ='$join_detail' WHERE `id`='$id';";

$result = mysqli_query($conn,$sql);

//이우주 6를 지운다
session_destroy();
mysqli_close($conn);


header('Location:http://'.$_SERVER['HTTP_HOST'].'/santteut/member/login/login.php?mode=update');


}else{
  $id = $_POST['join_id'];
  $join_passwd = $_POST["join_passwd"];
  $join_passwdconfirm = $_POST["join_passwdconfirm"];
  $join_name= $_POST["join_name"];
  $join_zip= $_POST["join_zip"];
  $join_foundational= $_POST["join_foundational"];
  $join_detail= $_POST["join_detail"];
  $join_landline1= $_POST["join_landline1"];
  $join_landline2= $_POST["join_landline2"];
  $join_landline3= $_POST["join_landline3"];
  $join_landline = $join_landline1."-".$join_landline2."-".$join_landline3;
  $hp1 = $_POST["join_select"];
  $hp2 = $_POST["join_cellphone"];
  $hp = $hp2;
  if(isset($_POST['email'])){
      $email = $_POST['email'];
  }else{
    $email1 = $_POST["e_mail_id"];
    $email2 = $_POST["e_mail_adress_2"];
    $email = $email1."@".$email2;
  }
$q_id = mysqli_real_escape_string($conn, $id);


if(isset($_POST['mode'])){
  switch ($_POST['mode']) {
    case 'facebook':
      $q_id = $q_id."@f";
      break;
    case 'kakao':
      $q_id = $q_id."@f";
      break;
    case 'naver':
      $q_id = $q_id."@n";
      break;
    case 'google':
    // 21자리 아이디 -> too long
      $q_id = substr($q_id,0,15);
      $q_id = $q_id."@g";
      break;

    // 보류중 구현 아직안됨
    // case 'update':
    // $sql = "UPDATE `member` SET `passwd` = $join_passwd, `passwd_confirm` = $join_passwdconfirm, `name` =$join_name, ";
    // $sql.= "`zip` = $join_zip, `address1` = $join_foundational, `address2` = $join_detail,`hp1` = $hp1,`hp2` = '$hp2', `email` = '$email' ";
    // $sql.= "where `id`= $q_id;"
    // $result = mysqli_query($conn,$sql);
    // if (!$result) {die('Error: ' . mysqli_error($conn));}
    // echo "<script>location.href='./member_admin_list.php';</script>";
    //   break;
    default:
      break;
  }
}
$sql="select * from member where id = '$q_id'";
$result = mysqli_query($conn,$sql);
if (!$result) {
  die('Error: ' . mysqli_error($conn));
}
$rowcount=mysqli_num_rows($result);

if($rowcount){
  //kakao OR facebook OR naver OR google
  if(isset($_POST['mode'])){
    $_SESSION['name'] =$join_name;
    $_SESSION['id'] =$q_id;

    if($_POST['mode']==='naver'){
      echo '<script>window.close();window.opener.location.replace("http://localhost/santteut/index.php"); </script>';
    }
    echo "<script>location.href='../../index.php';</script>";
    exit;
  }
  echo "<script>alert('존재하는 아이디입니다.');history.go(-1);</script>";
  exit;
}

$sql="INSERT INTO member (id,passwd,passwd_confirm,name,zip,address1,address2,hp1,hp2,email) ";
$sql.=" VALUES ('$q_id','$join_passwd','$join_passwdconfirm','$join_name','$join_zip','$join_foundational','$join_detail','$hp1','$hp','$email')";
$result = mysqli_query($conn,$sql);
if (!$result) {
  die('Error: ' . mysqli_error($conn));
}

$_SESSION['name'] =$join_name;
$_SESSION['id'] =$q_id;
}
echo "<script>location.href='../../index.php';</script>";
mysqli_close($conn);

?>
