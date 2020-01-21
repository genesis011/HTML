<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/db_connector.php";
?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/common/css/login_menu.css?ver=1">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/customer_support/faq/css/faq.css?ver=7">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/common/css/side_bar.css">
    <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.0/css/all.css' integrity='sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ' crossorigin='anonymous'>
    <title>FAQ</title>
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        $("#faq_mini").css("font-weight","bold");
        $("#faq_mini").css("color","black");
        for (var i = 1; i <= 8; i++) {
          $("#li"+i).click(function(){
            $("#"+this.id +"_1").slideToggle("fast");
            if($(this).css("color")=="rgb(0, 0, 0)"){
              $(this).css("color","#2F9D27");
              $(this).css("font-weight","bold");
            }else{
              $(this).css("color","rgb(0, 0, 0)");
              $(this).css("font-weight","normal");
            }
          });
        }
      });
    </script>
    <style media="screen">
      #faq_mini{color: red;}
    </style>
  </head>
  <body>
    <div id="wrap">
    <header>
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/login_menu.php";?>
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/custom_menu.php";?>
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/side_bar.php";?>
    <!--FAQ 자주 찾는 질문 페이지-->
    <div id="faq_main" style="height: 1050px; max-height: 2000px;">
     <br>
     <table id="table1">
       <tr id="faq"><td id="faq_td1"></td><td ><br></td></tr>
       <tr><td></br></td><td></td></tr>
       <!-- slidetoggle 액션  -->
       <tr><td id="li1" style="cursor: pointer;">Q.&nbsp;등산 시 속도를 못 쫓아갈까봐 걱정이 됩니다. 괜찮을까요?</td></tr>
       <tr id="li1_1" style="display: none;">
         <td>&nbsp;<small>&nbsp;&nbsp;&nbsp;&nbsp;<b>A. </b>사람들마다 각자 산행의 속도 차이가 있습니다.<br>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;그래서 보통 선두 그룹과 후미 그룹
          으로 나뉘어 진행되는 경우가 많으며, 일정표상의 소요시간은 후미그룹을 기준으로 패키지정보에 기재되어
          있습니다.<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;최종 목적지에 도착할
          때까지 다른 일행들보다 너무 뒤쳐지지 않게 신경써서 이동 해 주시고, 등산 스틱을 사용 하시면 보행시간
          단축에 도움을 받으실 수 있습니다.</small></td>
        </tr>
       <tr><td id="li2" style="cursor: pointer;">Q.&nbsp;패키지마다 인솔자가 계시나요?</td></tr>
       <tr id="li2_1" style="display: none;"><td >&nbsp;<small>&nbsp;&nbsp;&nbsp;&nbsp;<b>A. </b>산악회 직원이 인솔자로 동행하게 됩니다.</small></td></tr>
       <tr><td id="li3"  style="cursor: pointer;">Q.&nbsp;등산 중 화장실은 어떻게 사용 하나요?</td></tr>
       <tr id="li3_1" style="display:none;">
         <td>&nbsp;<small>&nbsp;&nbsp;&nbsp;&nbsp;<b>A. </b>지역에 따라 상이하나 보통 산장 또는 간이 화장실을 사용하며, 1회용 휴대 화장실을 사용해야 하는 경우도 있습니다.</small></td>
       </tr>
       <tr><td id="li4"  style="cursor: pointer;">Q.&nbsp;신용 불량자도 해외여행을 할 수 있나요?</td></tr>
       <tr id="li4_1" style="display: none;"><td >
         &nbsp;<small>&nbsp;&nbsp;&nbsp;&nbsp;<b>A. </b>신용 불량자는 금융 불량자입니다.<br>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;그러나 단지 신용 불량자라고 해서 출국까지 금지 되는 것은 아닙니다.<br>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;다만 신용 불량자가 되면서 거액으로 또는 민,형사 고소가 남아 있든지 하는 관계로 상대자가 출국금지를 요청 했을 때는 제외 사항입니다.<br>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;참고로, 출국금지여부는 본인이 직접 가까운 출입국관리사무소를 방문하시면 확인이 가능함을 말씀 드립니다.</small></td>
       </tr>
       <tr><td id="li5" style="cursor: pointer;">Q.&nbsp;회원탈퇴는 어떻게 하나요?</td></tr>
       <tr id="li5_1" style="display:none;"><td >
        &nbsp;<small>&nbsp;&nbsp;&nbsp;&nbsp;<b>A. </b>상단의 오른쪽메뉴에서 MY > 정보수정에서 탈퇴를 하실수 있습니다.</small></td></tr>
       <tr><td id="li6" style="cursor: pointer;">Q.&nbsp;여행 경비는 얼마정도 가져가야 할까요?</td></tr>
       <tr id="li6_1" style="display: none;"><td >
         &nbsp;<small>&nbsp;&nbsp;&nbsp;&nbsp;<b>A. </b>상품정보에 포함 되어 있지 않은 사항을 확인 하시고 여행 일수 별로 개인 경비를 준비하시면 됩니다.<br>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;자유시간이 없는 경우 선택관광이나 쇼핑은 할 수 없습니다.</small></td>
       </tr>
       <tr><td id="li7" style="cursor: pointer;">Q.&nbsp;비회원도 사이트 이용이 가능한가요?</td></tr>
       <tr id="li7_1" style="display: none;"><td>
        &nbsp;<small>&nbsp;&nbsp;&nbsp;&nbsp;<b>A. </b>자유게시판과 공지사항만 보기가 가능하며 그 외 기능은 회원가입후 이용가능하십니다.</small></td>
      </tr>
       <tr><td id="li8" style="cursor: pointer;">Q.&nbsp;숙식이랑 항공권은 개인부담인가요?</td></tr>
       <tr id="li8_1" style="display: none;"><td>
        &nbsp;<small>&nbsp;&nbsp;&nbsp;&nbsp;<b>A. </b>모든 패키지가 숙식과 항공권이 포함되어있는 금액입니다.</small></td>
      </tr>
       <tr id="faq"><td id="faq_td1"></td><td width=""><br></td></tr>
     </table>
    </div>
      <footer> <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/footer.php";?> </footer>
    </div>
  </body>
</html>
