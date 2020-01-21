<?php
  session_start();
  include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/db_connector.php";
  if(isset($_SESSION['id'])){
    $id = $_SESSION['id'];
  }
  if(isset($_SESSION['name'])){
    $name = $_SESSION['name'];
  }
  $receive_id = $_POST['receive_id'];
  $message_content = $_POST['message_content'];
  $regist_day = date("Y-m-d (H:i)");
  $sql = "SELECT * FROM `member` WHERE id='$receive_id'";
  $result = mysqli_query($conn, $sql);
  //$row = mysqli_fetch_array($result);
  if(mysqli_num_rows($result)==0){
    echo "<script>
          alert('없는 아이디 입니다.');
          window.history.go(-1);
          </script>";
  }else if(empty($message_content)){
    echo "<script>
          alert('메세지를 입력해 주세요.');
          window.history.go(-1);
        </script>";
  }else{
    $sql = "INSERT INTO `message` (recv_id,send_id,name,message,regist_day) VALUES ('$receive_id', '$id', '$name', '$message_content', '$regist_day')";
    mysqli_query($conn,$sql) or die(mysqli_error($conn));
    echo "<script>
          alert('전송 되었습니다.');
          window.close();
          </script>";
  }
?>
