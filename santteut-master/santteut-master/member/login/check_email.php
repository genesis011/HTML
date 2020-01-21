<?php
include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/db_connector.php";
include '../join/Sendmail.php';

$email =$_POST["email"];


  if(empty($_POST["email"])){
    echo "이메일이 없습니다 이메일을 입력해주세요";
    return;
  }else{
    $sql="SELECT * FROM member where email = '$email'";
    $result = mysqli_query($conn,$sql);
    if (!$result) {
      die('Error: ' . mysqli_error($conn));
    }
    $rowcount=mysqli_num_rows($result);
    // var_dump($rowcount);
    if ($rowcount) {
      srand((double)microtime()*1000000); //난수값 초기화
      $code=rand(100000,999999);
      echo $code;
      $count=1;
      $to=$email;
      $from="관리자";
      $subject="산뜻 회원 가입 인증번호입니다.";
      $body="산뜻 회원가입 인증번호 입니다.\n인증번호 : ".$code."\n정확히 입력해주세요.";
      $cc_mail="";
      $bcc_mail=""; /* 메일 보내기*/

      $sendmail->send_mail($to, $from, $subject, $body,$cc_mail,$bcc_mail);
     } else {
       echo "등록되지않은 이메일입니다.";
       return false;
     }
   }



?>
