<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/db_connector.php";

if(isset($_SESSION['id'])){
  $id = $_SESSION['id'];
}
if(isset($_GET['item_num'])){
  $num = $_GET['item_num'];
}
$sql = "SELECT * FROM `message` WHERE num='$num'";
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_array($result);
$send_id = $row["send_id"];
$send_name = $row["name"];
$message_cont = $row["message"];
$sql = "UPDATE `message` SET `recv_read` = 'Y' WHERE num = '$num'";
mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>메시지</title>
    <link rel="stylesheet" href="./css/message_list.css?ver=0">
    <script>
    function receive_message_close(){
      window.close();
      window.opener.location.reload(true);
    }
    </script>
  </head>
  <body>
    <div id="head">
      <h2>받은 메세지</h2>
    </div>
    <hr>
    <div style="text-align: left; margin-top: 8px;">
    <?=$send_name."님"?>&nbsp;<?="(".$send_id.") 이 보낸 메세지 "?>
    </div>
    <textarea name="message_content" rows="10" cols="75" style="margin-top: 10px;" readonly><?=$message_cont?></textarea>
    <div style="margin-top: 10px;">
      <a onclick="receive_message_close();"><input type="button" value="확인" style="width: 50px; height:30px; background-color: #2F9D27; border: 1px solid #2F9D27; color: white; margin-left:1px; float: left;"></a>
      <a href="./message_delete.php?item_num=<?=$num?>"><input type="button" value="삭제" style="width: 50px; height:30px; background-color: #2F9D27; border: 1px solid #2F9D27; color: white; margin-left: 6px;  float: left;"></a>
      <a href="./message_form.php?send_id=<?=$send_id?>"><input type="button" value="답장 보내기" style="width: 95px; height:30px; background-color: #2F9D27; border: 1px solid #2F9D27; color: white; margin-right: 2px; float: right;"></a>
    </div>
  </body>
</html>
