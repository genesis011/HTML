<?php
include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/db_connector.php";
$id=$_GET['id'];
$sql1= "DELETE FROM `bill` WHERE `b_id`='$id';";                     mysqli_query($conn,$sql1);
$sql2= "DELETE FROM `bus` WHERE `b_id`='$id';";                      mysqli_query($conn,$sql2);
$sql3= "DELETE FROM `cart` WHERE `c_id`='$id';";                     mysqli_query($conn,$sql3);
$sql4= "DELETE FROM `free` WHERE `id`='$id';";                       mysqli_query($conn,$sql4);
$sql5= "DELETE FROM `free_ripple` WHERE `id`='$id';";                mysqli_query($conn,$sql5);
$sql6= "DELETE FROM `member` WHERE `id`='$id';";                     mysqli_query($conn,$sql6);
$sql7= "DELETE FROM `member_review` WHERE `id`='$id';";              mysqli_query($conn,$sql7);
$sql8= "DELETE FROM `message` WHERE `recv_id`='$id';";               mysqli_query($conn,$sql8);
$sql9= "DELETE FROM `message` WHERE `send_id`='$id';";               mysqli_query($conn,$sql9);
$sql10="DELETE FROM `mt_information_ripple` WHERE `id`='$id';";      mysqli_query($conn,$sql10);
$sql11="DELETE FROM `official_review_ripple` WHERE `id`='$id';";     mysqli_query($conn,$sql11);
$sql12="DELETE FROM `qna` WHERE `id`='$id';";                        mysqli_query($conn,$sql12);
$sql13="DELETE FROM `reserve` WHERE `r_id`='$id';";                  mysqli_query($conn,$sql13);
$sql14="DELETE FROM `member` WHERE `id`='$id';";                     mysqli_query($conn,$sql14);
mysqli_close($conn);
session_start();
session_destroy();
header("Location:../../index.php?");
?>
