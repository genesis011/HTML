<?php
  $cookie_id=$_POST['cookie_id'];
  if($cookie_id!="none"){
  setcookie("cookie_id",$cookie_id);
  }else{
    setcookie("cookie_id");
  }
 ?>
