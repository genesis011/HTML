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
    <div id="head">
      <h2>받은 메세지</h2>
    </div>
    <hr>
    <div style="text-align: left; margin-top: 8px;">
    <?=$send_name."님"?>&nbsp;<?="(".$send_id.") 이 보낸 메세지 "?>
    </div>
    <textarea name="message_content" rows="6" cols="60" style="margin-top: 10px;" readonly><?=$message_cont?></textarea>
