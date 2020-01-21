<?php
include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/db_connector.php";
$num = $_GET['item_num'];
$sql = "DELETE FROM `message` WHERE num = '$num'";
mysqli_query($conn, $sql);
mysqli_close($conn);
echo "<script>alert('삭제 되었습니다.');
      window.close();
      window.opener.location.reload(true);
      </script>";
?>
