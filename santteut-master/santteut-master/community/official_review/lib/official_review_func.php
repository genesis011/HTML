<?php
  function official_review_ripple_delete($id1,$num1,$page1,$parent){
    $message="";
    $message = '<form style="display:inline;" action="'.$page1.'?mode=delete_ripple" method="post">
      <input type="hidden" name="num" value="'.$num1.'">
      <input type="hidden" name="parent" value="'.$parent.'">
      <input type="submit" value="삭제" style="background-color: #2F9D27; border: 1px solid #2F9D27; color: white;">
      </form>';
      return $message;
  }
?>
