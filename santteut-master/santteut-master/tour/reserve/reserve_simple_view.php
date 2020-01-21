<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/tour/reserve/css/reserve_simple_view.css?ver=1">
    <title></title>
  </head>
  <body>
    <table>
      <tr>
        <td class="change_grey">패키지 코드</td>
        <td class="info"> <p>RE456712</p> </td>
        <td class="change_grey">예약날짜</td>
        <td class="info"> <p>2019-05-26</p> </td>
      </tr>

      <tr>
        <td class="change_grey">패키지 이름</td>
        <td class="info"> <p>지리지리</p> </td>
        <td class="change_grey">총 인원</td>
        <td class="info"> <p>5명(성인:1명 아동:3명 유아:1명)</p> </td>
      </tr>

      <tr>
        <td class="change_grey">예약 상태</td>
        <td class="info"> <p>결제대기</p> </td>
        <td class="change_grey">예약자 이름</td>
        <td class="info"> <p>조민수</p> </td>
      </tr>

      <tr>
        <td class="change_grey">예약자 이메일</td>
        <td class="info"> <p>ms960719@naver.com</p> </td>
        <td class="change_grey">예약자 휴대폰</td>
        <td class="info"> <p>01052062758</p> </td>
      </tr>

      <tr>
        <td class="change_grey">버스 좌석</td>
        <td colspan="3" class="info2"> <p id="bus_view">14,15,16,17</p> </td>
        <td></td>
        <td></td>
      </tr>

      <tr>
        <td class="change_grey">총 금액</td>
        <td colspan="3" class="info2"> <p id="pay_view">2,300,000 원</p> </td>
        <td></td>
        <td></td>
      </tr>
    </table>
  </body>
</html>
