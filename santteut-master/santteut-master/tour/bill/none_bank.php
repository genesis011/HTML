<?php
  include $_SERVER['DOCUMENT_ROOT']."/santteut/tour/bill/bil_query.php";
  include $_SERVER['DOCUMENT_ROOT']."/santteut/tour/bill/bill_insert_query.php";
  $b_seat1=str_replace("/", ",", $b_seat);
  $b_seat1=substr($b_seat1, 1);
?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/tour/reserve/css/reserve_simple_view.css?ver=1">
    <title></title>
  </head>
  <body>
    <div class="">
    <table>
      <tr>
        <td class="change_grey">패키지 코드</td>
        <td class="info"> <p><?=$p_code?></p> </td>
        <td class="change_grey">패키지 이름</td>
        <td class="info"> <p><?=$p_name?></p> </td>
      </tr>
      <tr>
        <td class="change_grey">결제 날짜</td>
        <td class="info"> <p><?=$date?></p> </td>
        <td class="change_grey">좌석 번호</td>
        <td class="info"> <p><?=$b_seat1?></p></td>
      </tr>
      <tr>
        <td class="change_grey">예금주</td>
        <td class="info"> <p>(주)산뜻</p> </td>
        <td class="change_grey">계좌번호</td>
        <td class="info"> <p>(<?=$bank?>)90890200004548</p> </td>
      </tr>
      <tr>
        <td class="change_grey">총 금액</td>
        <td colspan="3" class="info2"> <p id="pay_view"><?=$r_pay?> 원</p> </td>
        <td></td>
        <td></td>
      </tr>
    </table>
    <button onclick="bye();" type="button" name="button"  style="margin-left:30%; width:100px; height:30px; margin-top:10px; ">완료</button>
    <script type="text/javascript">
      function bye(){
        alert('결제가완료되었습니다.');
        // self.opener = self;
        opener.location.href="../../index.php";
        window.close();
      }
    </script>
    </div>
  </body>
</html>
