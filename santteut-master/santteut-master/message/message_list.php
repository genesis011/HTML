<?php
  session_start();
  include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/db_connector.php";

  if(isset($_SESSION['id'])){
    $id = $_SESSION['id'];
  }
  $mode = "receive";
  if(isset($_GET['mode'])){
    $mode = $_GET['mode'];
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>메세지</title>
    <?php
    if($mode=="receive"){
      $sql = "SELECT * FROM `message` WHERE recv_id = '$id' ORDER BY num DESC;";
      $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
      $total_record = mysqli_num_rows($result);
    }else{
      $sql = "SELECT * FROM `message` WHERE send_id = '$id' ORDER BY num DESC;";
      $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
      $total_record = mysqli_num_rows($result);
    }
    //페이지 당 글수, 블럭당 페이지 수
    $rows_scale = 3;
    $pages_scale = 5;
    // 전체 페이지 수 ($total_page) 계산
    $total_pages = ceil($total_record/$rows_scale);
    if(empty($_GET['page'])){
      $page =1;
    }else{
      $page = $_GET['page'];
    }
    $start_row =$rows_scale * ($page -1);
    $pre_page= $page>1 ? $page-1 : NULL;
    $next_page= $page < $total_pages ? $page+1 : NULL;
    $start_page= (ceil($page / $pages_scale ) -1 ) * $pages_scale +1 ;
    $end_page= ($total_pages >= ($start_page + $pages_scale)) ? $start_page + $pages_scale-1 : $total_pages;
    $number=$total_record- $start_row;
    ?>
    <link rel="stylesheet" href="./css/message_list.css?ver=0">
    <script>
      function message_form(){
        var popupX = (window.screen.width/2) - (600/2);
        var popupY = (window.screen.height/2) - (400/2);
        window.open('./message_form.php','','left='+popupX+',top='+popupY+', width=500, height=400, status=no, scrollbars=no');
      }
      function chat_view(url){
        var popupX = (window.screen.width/2) - (600/2);
        var popupY = (window.screen.height/2) - (400/2);
        window.open(url,'','left='+popupX+',top='+popupY+', width=500, height=400, status=no, scrollbars=no');
      }
      function message_close(){
        window.close();
        window.opener.location.reload(true);
      }
    </script>
  </head>
  <body>
    <article class="main">
      <div id="head">
        <h1 style="display:inline;">메세지</h1><div style="display:inline; float:right; margin-top: 10px;"><a href="./message_list.php?mode=receive">받은 메세지</a>&nbsp; | &nbsp;<a href="./message_list.php?mode=send">보낸 메세지</a></div>
      </div>
      <hr style="border: 1px solid black;">
      <div class="clear2"></div>
      <?php
      for($i=$start_row; ($i<$start_row+$rows_scale)&& ($i<$total_record); $i++){
        //가져올 레코드 위치 이동
        mysqli_data_seek($result,$i);

        //하나 레코드 가져오기
        $row = mysqli_fetch_array($result);
        $item_num = $row["num"];
        $recv_id = $row["recv_id"];
        $send_id = $row["send_id"];
        $send_name = $row["name"];
        $message_cont = $row["message"];
        $recv_read = $row["recv_read"];
        $item_date = $row["regist_day"];
        $item_date = substr($item_date, 0 ,10);
      ?>
      <div id="list0" style="display:inline;">
      <?php
      if($mode == "receive"){
        if($recv_read == "N"){
       ?>
      <div id="list2" style="margin-top: 10px;"><b><?=$send_name."님"?></b>&nbsp;<b><?="( ".$send_id." ) 에게 받은 메세지"?></b>&nbsp;</div>
      <div id="list2" style="margin-top: 10px;"><a id="messageLink" href="#" onclick="chat_view('message_view.php?item_num=<?=$item_num?>')" style="text-decoration: none; color:black;"><b><?=$message_cont?></b></a></div>
      <div id="list_item4" style="margin-top: 10px;"><b><?=$item_date?> 안읽음</b></div>
      <?php
      }else{
       ?>
      <div id="list2" style="margin-top: 10px;"><?=$send_name."님"?>&nbsp<?="( ".$send_id." ) 에게 받은  메세지 "?>&nbsp</a></div>
   		<div id="list2" style="margin-top: 10px;"><a id="messageLink" href="" onclick="chat_view('message_view.php?item_num=<?=$item_num ?>')" style="text-decoration: none; color: black;"><?=$message_cont?></a></div>
   		<div id="list_item4" style="margin-top: 10px;" ><?=$item_date?> 읽음 </div>
      <?php
      }
      }else{
        if($recv_read == "N"){
      ?>
      <div id="list2" style="margin-top: 10px;"><?=$recv_id."님"?> 에게 보낸 메세지&nbsp;</div>
      <div id="list2" style="margin-top: 10px;"><?=$message_cont?></div>
      <div id="list_item4" style="margin-top:10px;"><?=$item_date?> <b>안읽음</b></div>
      <?php
      }else{
       ?>
       <div id="list2" style="margin-top: 10px;"><?=$recv_id."님"?> 에게 보낸 메세지 &nbsp;</a></div>
       <div id="list2" style="margin-top: 10px;"><?=$message_cont?></div>
       <div id="list_item4" style="margin-top: 10px;" ><?=$item_date?> 읽음</div>
       <?php
      }
      }
      ?>
      </div><!--end of list0  -->
      <hr>
      <div class="clear2"></div>
      <?php
      }
      ?>
      <div id='page_box' style="text-align:center;">
        <?php
          #----------------이전블럭 존재시 링크------------------#
          if($start_page>$pages_scale){
            $go_page = $start_page - $pages_scale;
            echo "<a id='before_block' href='message_list.php?mode=$mode&page=$go_page'> << </a>";
          }
          #----------------이전페이지 존재시 링크------------------#
          if($pre_page){
            echo "<a id='before_page' href='message_list.php?mode=$mode&page=$pre_page'> < </a>";
          }
          #--------------바로이동하는 페이지를 나열---------------#
          for($dest_page=$start_page;$dest_page <= $end_page;$dest_page++){
             if($dest_page == $page){
                  echo( "&nbsp;<b id='present_page'>$dest_page</b>&nbsp" );
              }else{
                  echo "<a id='move_page' href='message_list.php?mode=$mode&page=$dest_page'>$dest_page</a>";
              }
           }
           #----------------다음페이지 존재시 링크------------------#
           if($next_page){
               echo "<a id='next_page' href='message_list.php?mode=$mode&page=$next_page'> > </a>";
           }
           #---------------다음페이지를 링크------------------#
          if($total_pages >= $start_page+ $pages_scale){
            $go_page= $start_page+ $pages_scale;
            echo "<a id='next_block' href='message_list.php?mode=$mode&page=$go_page'> >> </a>";
           }
         ?>
      </div><!--end of page_box -->
      <?php
      if(isset($id)){

       ?>
       <input type="button" onclick="message_close();" style="width: 65px; height: 30px; float: right; margin-top: 20px; background-color: #2F9D27; border: 1px solid #2F9D27; color: white;" value="닫기">
       <input type="button" onclick="message_form();" style="width: 65px; height: 30px; float: right; margin-top: 20px; background-color: #2F9D27; border: 1px solid #2F9D27; color: white; margin-right: 10px;" value="쓰기">
      <?php
      }
      ?>
    </article>
  </body>
</html>
