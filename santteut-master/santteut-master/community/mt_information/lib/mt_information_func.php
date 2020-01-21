<?php
  function mt_information_ripple_delete($id1,$num1,$page1,$parent){
    $message="";
    // if($_SESSION['id']=="106841109129803@g"||$_SESSION['id']==$id1){
    $message = '<form style="display:inline;" action="'.$page1.'?mode=delete_ripple" method="post">
      <input type="hidden" name="num" value="'.$num1.'">
      <input type="hidden" name="parent" value="'.$parent.'">
      <input type="submit" value="삭제" style="background-color: #2F9D27; border: 1px solid #2F9D27; color: white;">
      </form>';
    // }
      return $message;
  }
?>
