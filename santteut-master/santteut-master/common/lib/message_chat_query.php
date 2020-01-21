<?php
if(!isset($_SESSION['id'])){session_start();}

include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/db_connector.php";

if(isset($_GET['message_mode'])){
  switch ($_GET['message_mode']) {
    case 'delete':
      $num = $_GET['item_num'];
      $message_sql = "DELETE FROM `message` WHERE num = '$num'";
      mysqli_query($conn, $message_sql);
      break;

    case 'insert':
      if(isset($_SESSION['id'])){
        $id = $_SESSION['id'];
      }
      if(isset($_SESSION['name'])){
        $name = $_SESSION['name'];
      }
      $receive_id = $_POST['receive_id'];
      $message_content = $_POST['message_content'];
      $regist_day = date("Y-m-d (H:i)");
      $message_sql = "SELECT * FROM `member` WHERE id='$receive_id'";
      $message_result = mysqli_query($conn, $message_sql);
      if(mysqli_num_rows($message_result)==0){
        echo "<script>
              alert('없는 아이디 입니다.');
              </script>";
      }else if(empty($message_content)){
        echo "<script>
              alert('메세지를 입력해 주세요.');
            </script>";
      }else{
        $message_sql = "INSERT INTO `message` (recv_id,send_id,name,message,regist_day) VALUES ('$receive_id', '$id', '$name', '$message_content', '$regist_day')";
        mysqli_query($conn,$message_sql) or die(mysqli_error($conn));
        echo "<script>alert('전송 되었습니다.');history.go(-1);</script>";
      }
    break;
    default:
    break;
  }
}
 ?>
