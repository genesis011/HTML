<?php
session_start();
if(isset($_SESSION['id'])){
  $id = $_SESSION['id'];
}else{
  $id = "";
}
if(isset($_SESSION['name'])){
  $name = $_SESSION['name'];
}else{
  $name = "";
}
if(isset($_GET['send_id'])){
  $receive_id = $_GET['send_id'];
}else{
  $receive_id = "";
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>메세지</title>
    <link rel="stylesheet" href="./css/message_list.css?ver=0">
    <script type="text/javascript">
      window.onload = function(){
        document.getElementById('self_write').onclick = function(){
          var check = document.getElementById('self_write');
          check = check.checked;
          var receive_id = document.getElementById('receive_id');
          if(check){
            receive_id.value = '<?=$id?>';
          }else{
            receive_id.value = '<?=$receive_id?>';
          }
        }
      }
    </script>
  </head>
  <body>
    <div id="head">
      <h2>메세지 보내기</h2>
    </div>
    <hr>
    <form action="message_check.php" method="post">
      <div style="text-align: left;">
        <b>보내는 메세지</b>
      </div>
      <textarea name="message_content" rows="10" cols="75" style="margin-top:10px;"></textarea>
      <div style="margin-top: 9px; text-align: right;">
        <b>내게 쓰기</b> : <input type="checkbox" id="self_write" name="self_write" value="">
        <b>받는 사람</b> : <input type="text" size="12px;" id="receive_id" name="receive_id" value="<?=$receive_id?>" style="height: 19px;">
      </div>
      <div style="margin-top: 14px;">
      <input type="submit" value="메세지 보내기" style="width: 95px; height:30px; background-color: #2F9D27; border: 1px solid #2F9D27; color: white; float: right;">
      </div>
    </form>
  </body>
</html>
