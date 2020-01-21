<?php
/*
=================================================================
+ [DESC] 내가 쓴 글 목록 확인
+ [DATE] 2019-05-29
+ [NAME] 김민지
=================================================================
*/
if(!session_id()) {session_start();}
?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/common/css/login_menu.css">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/mypage/myboard/css/myboard.css?ver=0.1">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/common/css/side_bar.css">
    <title>산뜻 :: 즐거운 산행</title>
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
    <script type="text/javascript">
    function review_form(pk){
      var popupX = (window.screen.width/2) - (600/2);
      var popupY = (window.screen.height/2) - (400/2);
      window.open('../../tour/member_review/member_review2.php?mode=view&r_pk='+ pk ,'','left='+popupX+',top='+popupY+', width=800, height=430, status=no, scrollbars=no');
    }
      $(document).ready(function() {
        // tap 메뉴 onclick action
        //1. 상담문의 /2. 여행후기 /3. 자유게시판
        for (var i = 1; i < 4; i++) {
          $("#list_head"+i).click(function(){
            if($(this).css("background-color")!=="white"){
              $("#list_head_tr").children('td').css('background-color', '#f2f2f2');
              $("#list_head_tr").children('td').css('border', '1px solid #dedede');
              $(this).css('background-color', 'white');
              $(this).css('border', '1px solid black');
              $(this).css('border-bottom-color', 'white');
              $(this).css('border-left-color', 'black');
            }
            $.ajax({
              url: 'myboard_btn_action.php',
              type: 'POST',
              data: {category: $(this).attr('id')}
            })
            .done(function(result) {
              var output = $.parseJSON(result);
              $("#list_tbl_body").html('');
              $("#no_result").html('');
              $("#list_tbl_body").append('<tr><td style="width:60%;">'+output[0].th1+'</td><td>'+output[0].th2+'</td><td>'+output[0].th3+'</td></tr>');
              $("#list_tbl_body").append(output[0].output);
              if(output[0].output == ''){
                $("#no_result").html('<p id="no_result" style="text-align:center; padding:2%;margin-bottom:3%;">해당 게시물의 내역이 없습니다.</p><hr><br>');
              }
            })
            .fail(function() {
              console.log("error");
            })
            .always(function() {
              console.log("complete");
            });
          });
        }
        $.ajax({
          url: 'myboard_btn_action.php',
          type: 'POST',
          data: {category: 'list_head1'}
        })
        .done(function(result) {
          var output = $.parseJSON(result);
          $("#list_tbl_body").html('');
          $("#list_tbl_body").append('<tr><td style="width:60%;">'+output[0].th1+'</td><td>'+output[0].th2+'</td><td>'+output[0].th3+'</td></tr>');
          $("#list_tbl_body").append(output[0].output);
          if(output[0].output == ''){
            $("#no_result").html('<p id="no_result" style="text-align:center; padding:2%;margin-bottom:3%;">해당 게시물의 내역이 없습니다.</p><hr><br>');
          }
        })
      });
    </script>
  </head>
  <body >
    <div id="wrap">
    <header>
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/login_menu.php";?>
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/side_bar.php";?>
    </header>
    <hr>
    <!--마이페이지 리스트-->
    <div id="myboard_list">
        <h3 id="title" >참여내역</h3>
      <fieldset id="list_field">
        <table id="list_tbl_head">
          <tr id="list_head_tr">
            <td id="list_head1">상담문의</td>
            <td id="list_head2">여행후기</td>
            <td id="list_head3">자유게시판</td>
          </tr></table>
        <table id="list_tbl_body">
        </table>
          <output id="no_result">
         </output>
      </fieldset>
    </div> <!-- end of div "reserve_list" -->
    <footer> <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/footer.php";?> </footer>
    </div>  <!-- end of div "wrap" -->
  </body>
</html>
