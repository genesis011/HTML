<?php
  session_start();
  //********************************************************************
  $sql1=$sql2=$sql3=$sql4=$sql5=$sql6=$sql7=$sql8=$sql9=$sql10=$sql11=$sql12="";
  //********************************************************************
  include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/db_connector.php";

  if(!empty($_SESSION['id'])){
    $id = $_SESSION['id'];
  }else{
    $id = "";
  }
  if(!empty($_POST['find'])){
    $find = $_POST['find'];
  }else{
    $find = "";
  }
  $jan = "01";
  $feb = "02";
  $mar = "03";
  $apr = "04";
  $may = "05";
  $jun = "06";
  $jul = "07";
  $aug = "08";
  $sep = "09";
  $oct = "10";
  $nov = "11";
  $dec = "12";

  $jan_price = 0;
  $feb_price = 0;
  $mar_price = 0;
  $apr_price = 0;
  $may_price = 0;
  $jun_price = 0;
  $jul_price = 0;
  $aug_price = 0;
  $sep_price = 0;
  $oct_price = 0;
  $nov_price = 0;
  $dec_price = 0;

  $current_date = 2019; //현재년도
  if(!empty($find)){
    $sql = "SELECT * FROM `bill` WHERE b_date like '$find%';";
  }else{
    $sql = "SELECT * FROM `bill` WHERE b_date like '$current_date%';";
  }

  $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

  while($row=mysqli_fetch_array($result)){
    $b_pay = $row['b_pay'];
    $b_date = $row['b_date'];

    $b_date = substr($b_date, 0,5);

    $sql1 = "SELECT sum(b_pay) FROM `bill` WHERE b_date like '$b_date$jan%'";
    $result1 = mysqli_query($conn, $sql1) or die(mysqli_error($conn));
    $row = mysqli_fetch_array($result1);
    $jan_price = $row[0];
    if(!$jan_price){
      $jan_price = 0;
    }

    $sql2 = "SELECT sum(b_pay) FROM `bill` WHERE b_date like '$b_date$feb%'";
    $result2 = mysqli_query($conn, $sql2) or die(mysqli_error($conn));
    $row = mysqli_fetch_array($result2);
    $feb_price = $row[0];
    if(!$feb_price){
      $feb_price = 0;
    }

    $sql3 = "SELECT sum(b_pay) FROM `bill` WHERE b_date like '$b_date$mar%'";
    $result3 = mysqli_query($conn, $sql3) or die(mysqli_error($conn));
    $row = mysqli_fetch_array($result3);
    $mar_price = $row[0];
    if(!$mar_price){
      $mar_price = 0;
    }

    $sql4 = "SELECT sum(b_pay) FROM `bill` WHERE b_date like '$b_date$apr%'";
    $result4 = mysqli_query($conn, $sql4) or die(mysqli_error($conn));
    $row = mysqli_fetch_array($result4);
    $apr_price = $row[0];
    if(!$apr_price){
      $apr_price = 0;
    }

    $sql5 = "SELECT sum(b_pay) FROM `bill` WHERE b_date like '$b_date$may%'";
    $result5 = mysqli_query($conn, $sql5) or die(mysqli_error($conn));
    $row = mysqli_fetch_array($result5);
    $may_price = $row[0];
    if(!$may_price){
      $may_price = 0;
    }

    $sql6 = "SELECT sum(b_pay) FROM `bill` WHERE b_date like '$b_date$jun%'";
    $result6 = mysqli_query($conn, $sql6) or die(mysqli_error($conn));
    $row = mysqli_fetch_array($result6);
    $jun_price = $row[0];
    if(!$jun_price){
      $jun_price = 0;
    }

    $sql7 = "SELECT sum(b_pay) FROM `bill` WHERE b_date like '$b_date$jul%'";
    $result7 = mysqli_query($conn, $sql7) or die(mysqli_error($conn));
    $row = mysqli_fetch_array($result7);
    $jul_price = $row[0];
    if(!$jul_price){
      $jul_price = 0;
    }

    $sql8 = "SELECT sum(b_pay) FROM `bill` WHERE b_date like '$b_date$aug%'";
    $result8 = mysqli_query($conn, $sql8) or die(mysqli_error($conn));
    $row = mysqli_fetch_array($result8);
    $aug_price = $row[0];
    if(!$aug_price){
      $aug_price = 0;
    }

    $sql9 = "SELECT sum(b_pay) FROM `bill` WHERE b_date like '$b_date$sep%'";
    $result9 = mysqli_query($conn, $sql9) or die(mysqli_error($conn));
    $row = mysqli_fetch_array($result9);
    $sep_price = $row[0];
    if(!$sep_price){
      $sep_price = 0;
    }

    $sql10 = "SELECT sum(b_pay) FROM `bill` WHERE b_date like '$b_date$oct%'";
    $result10 = mysqli_query($conn, $sql10) or die(mysqli_error($conn));
    $row = mysqli_fetch_array($result10);
    $oct_price = $row[0];
    if(!$oct_price){
      $oct_price = 0;
    }

    $sql11 = "SELECT sum(b_pay) FROM `bill` WHERE b_date like '$b_date$nov%'";
    $result11 = mysqli_query($conn, $sql11) or die(mysqli_error($conn));
    $row = mysqli_fetch_array($result11);
    $nov_price = $row[0];
    if(!$nov_price){
      $nov_price = 0;
    }

    $sql12 = "SELECT sum(b_pay) FROM `bill` WHERE b_date like '$b_date$dec%'";
    $result12 = mysqli_query($conn, $sql12) or die(mysqli_error($conn));
    $row = mysqli_fetch_array($result12);
    $dec_price = $row[0];
    if(!$dec_price){
      $dec_price = 0;
    }
  }

?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/common/css/login_menu.css">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/revenue/css/revenue_management.css?ver=0">
    <title>매출관리</title>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.8.18/themes/base/jquery-ui.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script src="//code.jquery.com/ui/1.8.18/jquery-ui.min.js"></script>

    <script type="text/javascript">

    google.charts.load('current', {'packages':['line']}); /* LINE 차트를 사용하기 위한 준비 */
    google.charts.setOnLoadCallback(drawChart); /* 로딩 완료시 함수 실행하여 차트 생성 */

    function drawChart(){
      var data = new google.visualization.DataTable();
      data.addColumn('number', 'Month');
      data.addColumn('number', '매출');

      data.addRows([
        [1, <?=$jan_price?>],
        [2, <?=$feb_price?>],
        [3, <?=$mar_price?>],
        [4, <?=$apr_price?>],
        [5, <?=$may_price?>],
        [6, <?=$jun_price?>],
        [7, <?=$jul_price?>],
        [8, <?=$aug_price?>],
        [9, <?=$sep_price?>],
        [10, <?=$oct_price?>],
        [11, <?=$nov_price?>],
        [12, <?=$dec_price?>]

      ]);

      var options = {
        'title': 'Monthly revenue history',
        'subtitle': 'in won (KRW)',
        //'legend': 'none',
        //'lineWidth': 50,
        'colors': 'green',
        'hAxis': {
                minValue: 1,
                maxValue: 12
              },
        'width': 770,
        'height': 500
      };

      var chart = new google.charts.Line(document.getElementById('linechart'));
      chart.draw(data, google.charts.Line.convertOptions(options));

    }

    $(document).ready(function(){
      $("#btnExport").click(function(e){
        window.open('data:application/vnd.ms-excel;chsarset=utf-8,\uFEFF' + encodeURI($('#dvData').html()));
        e.preventDefault();
      });
    });
    </script>
  </head>
  <header>
    <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/login_menu.php";?>
  </header>
    <!-- <h1 style="padding-top:40px; margin:0 auto; margin-top:20px; text-align: center;">매출관리</h1> -->
    <div id="ticket_box45">
    <div id="select_ticket" style="margin-top:10%;"><h4>매출 관리</h4></div>
    <form name="month_form" action="revenue_management.php" method="post">
      <select name="find" style="width: 100px; height:30px;">
        <option value="" hidden>년도</option>
        <option value="<?=$current_date?>"><?=$current_date?>년</option>
        <option value="<?=$current_date-1?>"><?=$current_date-1?>년</option>
        <option value="<?=$current_date-2?>"><?=$current_date-2?>년</option>
        <option value="<?=$current_date-3?>"><?=$current_date-3?>년</option>
        <option value="<?=$current_date-4?>"><?=$current_date-4?>년</option>
        <option value="<?=$current_date-5?>"><?=$current_date-5?>년</option>
        <option value="<?=$current_date-6?>"><?=$current_date-6?>년</option>
      </select>
      <input type="submit" value="검색" style="width: 60px; height:30px; background-color: #2F9D27; border: 1px solid #2F9D27; color: white;">
    </form>
    <?php
      if($find){
        $sql = "SELECT b_pay, b_date FROM `bill` WHERE b_date like '$find%'";
      }else{
        $sql = "SELECT b_pay, b_date FROM `bill` WHERE b_date like '$current_date%'";
      }
      $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
      $total = 0;
      while($row=mysqli_fetch_array($result)){
        $b_pay = $row['b_pay'];
        $total = $total + $b_pay;
      }
      $total = number_format($total);
      if($find){
     ?>
      <div style="float:right; margin-right:40px;"><span style="font-size: 17pt; font-weight: 550;"><?=$find?>년도 전체 매출 내역 : <?=$total?> 원</span></div><br><br>

      <?php
    }else{
       ?>
       <div style="float:right;"><span style="font-size: 17pt; font-weight: 550;"><?=$current_date?>년도 전체 매출 내역 : <?=$total?> 원</span></div><br><br>
       <?php
    }
        ?>
        <?php
        $jan_price = number_format($jan_price);
        $feb_price = number_format($feb_price);
        $mar_price = number_format($mar_price);
        $apr_price = number_format($apr_price);
        $may_price = number_format($may_price);
        $jun_price = number_format($jun_price);
        $jul_price = number_format($jul_price);
        $aug_price = number_format($aug_price);
        $sep_price = number_format($sep_price);
        $oct_price = number_format($oct_price);
        $nov_price = number_format($nov_price);
        $dec_price  = number_format($dec_price);
        ?>
        <div id="linechart"></div>
        <div style="float:right;  margin: -440px 30px; 0 0;">
          <ul style="list-style:none;">
            <li>01월  : <?= $jan_price ?> 원</li>
            <li>02월  : <?= $feb_price ?> 원</li>
            <li>03월  : <?= $mar_price ?> 원</li>
            <li>04월  : <?= $apr_price ?> 원</li>
            <li>05월  : <?= $may_price ?> 원</li>
            <li>06월  : <?= $jun_price ?> 원</li>
            <li>07월  : <?= $jul_price ?> 원</li>
            <li>08월  : <?= $aug_price ?> 원</li>
            <li>09월  : <?= $sep_price ?> 원</li>
            <li>10월  : <?= $oct_price ?> 원</li>
            <li>11월  : <?= $nov_price ?> 원</li>
            <li>12월  : <?= $dec_price ?> 원</li>
          </ul>
          <hr style="width:150px; border:2px solid gray; margin-left: 28px;">
          <span style="float:right; margin-right:10px;">총액 : <?=$total?> 원</span>
        </div>
        <button type="button" id="btnExport" style="height:33px;float:right; background-color: #2F9D27; border: 1px solid #2F9D27; color: white; margin-top:-100px; margin-right: 60px;">매출내역(엑셀)</button>
        <div id="dvData">
          <table style="visibility: hidden; border-collapse: collapse;
          font-family: "Trebuchet MS", Helvetica, sans-serif;">
          <tr>
            <td style="border: 1px solid black; text-align: center;">번호</td>
            <td style="border: 1px solid black; text-align: center;">예약번호</td>
            <td style="border: 1px solid black; text-align: center;">패키지코드</td>
            <td style="border: 1px solid black; text-align: center;">아이디</td>
            <td style="border: 1px solid black; text-align: center;">결제일</td>
            <td style="border: 1px solid black; text-align: center;">결제수단</td>
            <td style="border: 1px solid black; text-align: center;">결제금액(원)</td>
          </tr>
          <?php
            $i=0;
            $total2=0;
            $sql = "SELECT * FROM `bill` WHERE b_date like '$find%'";
            $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            while($row = mysqli_fetch_array($result)){
              $b_pk1 = $row['b_pk'];
              $b_code1 = $row['b_code'];
              $b_id1 = $row['b_id'];
              $b_date1 = $row['b_date'];
              $b_way1 = $row['b_way'];
              if($b_way1==1){
                $b_way2 ="무통장입금";
              }else if($b_way1==2){
                $b_way2 ="카카오페이";
              }
              $b_pay1 = $row['b_pay'];
              $total2 = $total2 + $b_pay1;
          ?>
          <tr>
             <td style="border: 1px solid black; text-align: center;" ><?= $i+1 ?></td>
             <td style="border: 1px solid black;text-align: center;"><?= $b_pk1 ?></td>
             <td style="border: 1px solid black;text-align: center;"><?= $b_code1 ?></td>
             <td style="border: 1px solid black;text-align: center;"><?= $b_id1 ?></td>
             <td style="border: 1px solid black;text-align: center;"><?= $b_date1 ?></td>
             <td style="border: 1px solid black;text-align: center;"><?= $b_way2 ?></td>
             <td style="border: 1px solid black;text-align: center;"><?= number_format($b_pay1)?></td>
        </tr>
          <?php
            $i++;
            }
          ?>
          <tr>
            <td colspan="3" style="border: 1px solid black; text-align: center;">총매출</td>
            <td colspan="4" style="border: 1px solid black;text-align: center;"><?=number_format($total2)?>원</td>
          </tr>
          </table>
        </div><!--end of dvData -->
     </div><!--ticket_box45 -->
     <footer>
       <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/footer.php";
       ?>
     </footer>
  </body>
</html>
