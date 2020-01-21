<?php
@session_start();
  if(isset($_SESSION['id'])){$id=$_SESSION['id'];}else{$id='';}
  if(isset($_SESSION['name'])){$name=$_SESSION['name'];}else{$name='';}
  if(!isset($conn)){
    include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/db_connector.php";
  }
  $message_mode = "receive";
  if(isset($_GET['message_mode'])){ $message_mode = $_GET['message_mode'];}
  if(isset($_GET['send_id'])){
    $receive_id = $_GET['send_id'];
  }else{
    $receive_id = "";
  }
  if($message_mode=="receive"){
    $message_sql = "SELECT * FROM `message` WHERE recv_id = '$id' ORDER BY num DESC;";
    $message_result = mysqli_query($conn, $message_sql) or die(mysqli_error($conn));
    $message_total_record = mysqli_num_rows($message_result);
  }else{
    $message_sql = "SELECT * FROM `message` WHERE send_id = '$id' ORDER BY num DESC;";
    $message_result = mysqli_query($conn, $message_sql) or die(mysqli_error($conn));
    $message_total_record = mysqli_num_rows($message_result);
  }

?>
  <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/common/css/message.css?ver=1">
    <script type="text/javascript">
    $(document).ready(function() {
      var receive_id = '<?=json_encode($receive_id)?>';
      $("#message").click(function(event) {
        message_list();
      });
    });
    function message_list(){
      var div_val = $("#div_val").html();
      var modal = document.getElementById('myModal');
      $("#modal-content").html("");
      $("#modal-content").append("<h2>메세지</h2><hr>");
      $("#modal-content").append("<div style='height:400px; overflow:scroll;'>"+div_val+"</div>");
      $("#modal-content").append('<div class="button-8" id="button-3"><br>');
      $("#button-3").append("<a class='btn' onclick='message_form(\"\");'><span>글쓰기</span></a>");
      $("#button-3").append("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class='btn' onclick='modal_close();'><span>취소</span></a>");
      $("#modal-content").append("</div>");
      modal.style.display="block";

    }
    function chat_view(num){
      $.ajax({
        url:'http://localhost/santteut/common/lib/message_chat_view.php',
        type: 'GET',
        data: {item_num: num}
      })
      .done(function(result) {
        modal_close();
        var modal = document.getElementById('myModal');
        $("#modal-content").html("");
        $("#modal-content").append(result);
        $("#modal-content").append('<div class="button-8" id="button-3"><br>');
        $("#button-3").append("<a class='btn' onclick='modal_close();'><span>확인</span></a>&nbsp;&nbsp;&nbsp;");
        $("#button-3").append("<a class='btn' onclick='chat_del("+num+");'><span>삭제</span></a>&nbsp;&nbsp;&nbsp;");
        modal.style.display="block";
      })
      .fail(function() {
        console.log("error");
      })
      .always(function() {
        console.log("complete");
      });
    }
    function chat_del(num) {
      $.ajax({
        url:'http://localhost/santteut/common/lib/message_chat_query.php',
        type: 'GET',
        data: {item_num: num, message_mode:'delete'}
      })
      .done(function(result) {
        modal_close();
        location.reload();
      })
    }
    function message_form(receive_id){
      modal_close();
      var modal = document.getElementById('myModal');
      $("#modal-content").html("");
      $("#modal-content").append("<h2>메세지</h2><hr>");
      $("#modal-content").append("<form name='message_form' id='message_form' action='http://localhost/santteut/common/lib/message_chat_query.php?message_mode=insert' method='post'>");
      $("#message_form").append("<h3 style='text-align:left;'>보내는 메세지</h3>");
      $("#message_form").append("<textarea name='message_content' rows='10' cols='67' style='margin-top:10px;'></textarea>");
      $("#message_form").append("<div style='margin-top: 9px;margin-bottom:10px; text-align:right'><b>내게 쓰기</b> : <input type='checkbox' id='self_write' name='self_write'><b>받는 사람</b> : <input type='text' size='12px;' id='receive_id' name='receive_id' value='"+receive_id+"' style='height: 19px;'></div>");
      $("#message_form").append('<div class="button-8" id="button-3" >');
      $("#button-3").append("<a class='btn' onclick='document.message_form.submit()' ><span>확인</span></a>");
      $("#button-3").append("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class='btn' onclick='modal_close();' ><span>취소</span></a>");
      $("#message_form").append("</div>");
      $("#modal-content").append("</form>");
      modal.style.display="block";

      $("#self_write").click(function(event) {
        var check = document.getElementById('self_write');
        check = check.checked;
        var receive_id = document.getElementById('receive_id');
        if(check){ receive_id.value = '<?=$id?>'; }
      });
    }


    function modal_close(){
      var modal = document.getElementById('myModal');
      modal.style.display="none";
    }
    function modal_alert_cancel(msg1,msg2,msg3){
      var modal = document.getElementById('myModal');
      modal.style.display="block";
      $("#modal-content").html("<i class='fas fa-exclamation-circle 9x'></i>");
      $("#modal-content").append("<h2>"+msg1+"</h2>");
      $("#modal-content").append("<h3>"+msg2+"</h3>");
      $("#modal-content").append("<div class='button-8' id='button-3' onclick='alert_confirm(\""+msg3+"\")'>");
      $("#button-3").append("<div class='eff-8'></div>");
      $("#button-3").append("<a href='#'><span>확인</span></a>");
      $("#modal-content").append("</div>");
      $("#modal-content").append("<div class='button-8' id='button-4'>");
      $("#button-3").append("<div class='eff-8'></div>");
      $("#button-3").append("<a href='#'><span>취소</span></a>");
      $("#modal-content").append("</div>");
    }

    function alert_confirm(local){
      var modal = document.getElementById('myModal');
      modal.style.display = "none";
      if(local!="undefined"){
        window.location.href=local;
      }
    }

    window.onclick = function(event) {
      if (event.target == "modal") {
        var modal = document.getElementById('myModal');
        modal.style.display = "none";
      }
    };
  </script>
<div style="display:none;" id="div_val" >
  <?php
  for($i=0; $i<$message_total_record; $i++){

    $row = mysqli_fetch_array($message_result);
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
  if($message_mode == "receive"){
    if($recv_read == "N"){
   ?>
  <div id="list2" style="margin-top: 10px;"><b><?=$send_name."님"?></b>&nbsp;<b><?="( ".$send_id." ) 에게 받은 메세지"?></b>&nbsp;</div>
  <div id="list2" style="margin-top: 10px; "><a id="messageLink"  onclick="chat_view('<?=$item_num?>')" style="text-decoration: none; "><b><?=$message_cont?></b></a></div>
  <div id="list_item4" style="margin-top: 10px;"><b><?=$item_date?> 안읽음</b></div>
  <?php
  }else{
   ?>
  <div id="list2" style="margin-top: 10px;"><?=$send_name."님"?>&nbsp<?="( ".$send_id." ) 에게 받은  메세지 "?>&nbsp</a></div>
  <div id="list2" style="margin-top: 10px;"><a id="messageLink" onclick="chat_view('<?=$item_num ?>')" style="text-decoration: none; "><?=$message_cont?></a></div>
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
  <?php
  }
  ?>

</div>

<div id="myModal" class="modal">
  <div class="modal-content" id="modal-content">
  </div>
</div>

<div id="logo" >
  <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/index.php">
    <img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/common/img/sanlogo.png" border=0></a>
  <div id="menus">
    <div id="top_menu_div">
      <ul id="top_menu">
        <li><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/tour/package/package_list.php?divide=domestic">국내산행</a></li>
        <li><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/tour/package/package_list.php?divide=abroad">해외산행</a></li>
      </ul>
    </div>
  <!-- </div> end of menus div -->
  <div id="login_menu" >
    <ul id="login_menu_ul" >
      <?php
      // 비회원일때
      if(empty($id)){
         echo ('<li ><a href="http://'.$_SERVER['HTTP_HOST'].'/santteut/member/login/login.php" class="hov">로그인</a></li>');
        echo ('<li><a href="http://'.$_SERVER['HTTP_HOST'].'/santteut/member/join/join_member.php" class="hov">회원가입</a></li>');
        echo ('<li id="top_my" class="hov">커뮤니티<small style="font-size:10px;"> ▼</small>
          <div id="top_my_content">
            <ul id="top_my_content_ul">
              <li><a href="http://'.$_SERVER['HTTP_HOST'].'/santteut/community/free/free_list.php" class="hov">자유게시판</a></li>
              <li><a href="http://'.$_SERVER['HTTP_HOST'].'/santteut/community/mt_information/mt_information_list.php" class="hov">명산정보</a></li>
              <li><a href="http://'.$_SERVER['HTTP_HOST'].'/santteut/community/official_review/official_review_list.php" class="hov">공식산행후기</a></li>
            </ul>
          </div>
        </li> ');

        //관리자일때
      }else if($id=="admin"){
        $name = $_SESSION['name'];
        echo ("<b> {$name} </b> 님 환영합니다. ");
        echo ('<li id="logout">[<a href="http://'.$_SERVER['HTTP_HOST'].'/santteut/member/login/logout.php">로그아웃</a>]</li> ');
        echo ('<li id="top_my" class="hov">관리자모드<small style="font-size:10px;"> ▼</small>
          <div id="top_my_content">
            <ul id="top_my_content_ul">
              <li><a href="http://'.$_SERVER['HTTP_HOST'].'/santteut/tour/admin/admin_add_package.php" class="hov">패키지등록</a></li>
              <li><a href="http://'.$_SERVER['HTTP_HOST'].'/santteut/tour/admin/admin_manage_package.php" class="hov">패키지관리</a></li>
              <li><a href="http://'.$_SERVER['HTTP_HOST'].'/santteut/tour/reserve/reserve_list.php" class="hov">예약/결제목록</a></li>
              <li><a href="http://'.$_SERVER['HTTP_HOST'].'/santteut/customer_support/qna/qna_list.php" class="hov">답변글관리</a></li>
              <li><a href="http://'.$_SERVER['HTTP_HOST'].'/santteut/revenue/revenue_management.php" class="hov">매출관리</a></li>
              <li><a href="http://'.$_SERVER['HTTP_HOST'].'/santteut/member/admin/member_admin_list.php" class="hov">회원관리</a></li>
              <li><a id="message" class="hov">쪽지</a></li>
            </ul>
          </div>
        </li>&nbsp;&nbsp;');
        echo ('<li id="top_my" class="hov">커뮤니티<small style="font-size:10px;"> ▼</small>
          <div id="top_my_content">
            <ul id="top_my_content_ul">
              <li><a href="http://'.$_SERVER['HTTP_HOST'].'/santteut/community/free/free_list.php" class="hov">자유게시판</a></li>
              <li><a href="http://'.$_SERVER['HTTP_HOST'].'/santteut/community/mt_information/mt_information_list.php" class="hov">명산정보</a></li>
              <li><a href="http://'.$_SERVER['HTTP_HOST'].'/santteut/community/official_review/official_review_list.php" class="hov">공식산행후기</a></li>
            </ul>
          </div>
        </li>&nbsp;');

        //회원일때
      }else{
        if(isset($_SESSION['name'])){$name = $_SESSION['name'];}else{$name ='';}
        echo ("<b> {$name} </b> 님 환영합니다. ");
        echo ('<li id="logout">[<a href="http://'.$_SERVER['HTTP_HOST'].'/santteut/member/login/logout.php">로그아웃</a>]</li> ');
        echo ('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<li id="top_my" class="hov">My<small style="font-size:10px;">▼</small>
          <div id="top_my_content">
            <ul id="top_my_content_ul">
              <li><a href="http://'.$_SERVER['HTTP_HOST'].'/santteut/tour/reserve/reserve_list.php" class="hov">예약/결제내역</a></li>
              <li><a href="http://'.$_SERVER['HTTP_HOST'].'/santteut/tour/cart/cart_list.php" class="hov">장바구니</a></li>
              <li><a href="http://'.$_SERVER['HTTP_HOST'].'/santteut/mypage/myboard/myboard.php" class="hov">참여내역</a></li>
              <li><a href="http://'.$_SERVER['HTTP_HOST'].'/santteut/customer_support/qna/qna_form.php" class="hov">상담문의</a></li>
              <li><a id="message" class="hov">쪽지</a></li>
              <li><a href="http://'.$_SERVER['HTTP_HOST'].'/santteut/member/join/join_edit.php?id='.$id.'" class="hov">정보수정</a></li>
            </ul>
          </div>
        </li> ');
        echo ('<li id="top_my" class="hov">커뮤니티<small style="font-size:10px;">▼</small>
          <div id="top_my_content">
            <ul id="top_my_content_ul">
              <li><a href="http://'.$_SERVER['HTTP_HOST'].'/santteut/community/free/free_list.php" class="hov">자유게시판</a></li>
              <li><a href="http://'.$_SERVER['HTTP_HOST'].'/santteut/community/mt_information/mt_information_list.php" class="hov">명산정보</a></li>
              <li><a href="http://'.$_SERVER['HTTP_HOST'].'/santteut/community/official_review/official_review_list.php" class="hov">공식산행후기</a></li>
            </ul>
          </div>
        </li> ');
      }
      ?>
  </ul>
  </div>
  </div>
</div>
