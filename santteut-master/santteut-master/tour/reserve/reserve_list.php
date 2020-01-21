<?php
/*
=================================================================
+ [DESC] 예약/결제 목록 확인
+ [DATE] 2019-05-26
+ [NAME] 김민지
=================================================================
*/
session_start();
$id=$_SESSION['id'];
include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/db_connector.php";
$sql=$result=$total_record=$total_pages=$start_record=$row="";
$total_record=0;
$alert = '';

define('ROW_SCALE', 10);
define('PAGE_SCALE', 10);
//r_cancel=0 -> 예약내역
//r_cancel=1 -> 취소내역
$reserve_flag =empty($_POST['reserve_flag']) ? 0 : $_POST['reserve_flag'];
if($reserve_flag){

}
$alert = ($reserve_flag==0) ? "예약 내역이 없습니다." : "취소내역이 없습니다.";

//검색모드
if(isset($_GET["mode"])&&$_GET["mode"]=="search"){
  $year1=$_POST["h_year1"];
  $year2=$_POST["h_year2"];
  $month1=$_POST["h_month1"];
  $month2=$_POST["h_month2"];
  $day1=$_POST["h_day1"];
  $day2=$_POST["h_day2"];

  if($month1>0 && $month1<10){
    $month1="0".$month1;
  }
  if($month2>0 && $month2<10){
    $month2="0".$month2;
  }
  if($day1>0 && $day1<10){
    $day1="0".$day1;
  }
  if($day2>0 && $day2<10){
    $day2="0".$day2;
  }
  $search_start = $year1."-".$month1."-".$day1;
  $search_end = $year2."-".$month2."-".$day2;
  if($id=="admin"){
    $sql="SELECT * from `reserve` join `package` on `reserve`.`r_code` = `package`.`p_code` where `package`.`p_dp_date` between '$search_start' and '$search_end' and `reserve`.`r_cancel`='$reserve_flag' order by `r_date` desc;";
  }else{
    $sql="SELECT * from `reserve` join `package` on `reserve`.`r_code` = `package`.`p_code` where `package`.`p_dp_date` between '$search_start' and '$search_end' and `reserve`.`r_id` = '$id' and `reserve`.`r_cancel`='$reserve_flag' order by `r_date` desc;";
  }
}else{
  if($id=="admin"){
    $sql="SELECT * from `reserve` join `package` on `reserve`.`r_code` = `package`.`p_code` where `reserve`.`r_cancel`='$reserve_flag' order by `r_date` desc;";
  }else{
    $sql="SELECT * from `reserve` join `package` on `reserve`.`r_code` = `package`.`p_code` where `reserve`.`r_id` = '$id' and `reserve`.`r_cancel`='$reserve_flag' order by `r_date` desc;";
  }

}
$result=mysqli_query($conn,$sql);
$total_record=mysqli_num_rows($result);
$total_pages=ceil($total_record/ROW_SCALE);
$page=(empty($_GET['page']))?1:$_GET['page'];
if(isset($_POST['page'])){
  $page=(empty($_POST['page']))?1:$_POST['page'];
}
// 현재 블럭의 시작 페이지 = (ceil(현재페이지/블럭당 페이지 제한 수)-1) * 블럭당 페이지 제한 수 +1
//[[  EX) 현재 페이지 5일 때 => ceil(5/3)-1 * 3  +1 =  (2-1)*3 +1 = 4 ]]
$start_page= (ceil($page / PAGE_SCALE ) -1 ) * PAGE_SCALE +1 ;
// 현재페이지 시작번호 계산함.
//[[  EX) 현재 페이지 1일 때 => (1 - 1)*10 -> 0   ]]
//[[  EX) 현재 페이지 5일 때 => (5 - 1)*10 -> 40  ]]
$start_record=($page -1) * ROW_SCALE;
// 현재 블럭 마지막 페이지
// 전체 페이지가 (시작 페이지+페이지 스케일) 보다 크거나 같으면 마지막 페이지는 (시작페이지 + 페이지 스케일) -1 / 아니면 전체페이지 수 .
//[[  EX) 현재 블럭 시작 페이지가 6/ 전체페이지 : 10 -> '10 >= (6+10)' 성립하지 않음 -> 10이 현재블럭의 가장 마지막 페이지 번호  ]]
$end_page= ($total_pages >= ($start_page + PAGE_SCALE)) ? $start_page + PAGE_SCALE-1 : $total_pages;

?>
<?php
  $now = new DateTime();
  $Y = $now -> format("Y");
  $m = $now -> format("m");
  $d = $now -> format("d");
  //t = the number of days in the given month
  $t = $now -> format("t");
 ?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/common/css/login_menu.css">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/tour/reserve/css/reserve_list.css">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/common/css/side_bar.css">
    <style media="screen">
      a{color:#000;}
      .modal {
      display: none; /* Hidden by default */
      position: fixed; /* Stay in place */
      z-index: 10; /* Sit on top */
      left: 0;
      top: 0;
      width: 1000px; /* Full width */
      height: 100%; /* Full height */
      overflow: auto; /* Enable scroll if needed */
      background-color: rgb(0,0,0); /* Fallback color */
      background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
      }

      /* Modal Content/Box */
      .modal-content {
      text-align: center;
      background-color: #fefefe;
      margin: 10% auto; /* 15% from the top and centered */
      padding: 20px;
      border: 1px solid #888;
      width: 500px; /* Could be more or less, depending on screen size */
      height: auto;
      border-radius: 10px;
      }
    </style>
    <title>산뜻 :: 즐거운 산행</title>
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
    <script type="text/javascript">
    // 예약내역 취소내역 선택 부분
      $(document).ready(function() {
        $("#reserve_flag").val(<?=json_encode($reserve_flag)?>);

        if($("#reserve_flag").val()*1){
          if($("#list_head_cancel").css('background-color')!="white"){
            $("#list_head_cancel").css('background-color', 'white');
            $("#list_head_cancel").css('border', '1px solid #3d3d3d');
            $("#list_head_cancel").css('border-bottom-color', 'white');
            $("#list_head_reserve").css('background-color', '#f2f2f2');
            $("#list_head_reserve").css('border', '1px solid #dedede');
            $("#list_head_reserve").css('border-right-color', '#3d3d3d');
            $("#after").html("취소일");
          }
        }
        //예약내역
        $("#list_head_reserve").click(function(){
          if($("#list_head_reserve").css("background-color")!="white"){
            $("#list_head_reserve").css('background-color', 'white');
            $("#list_head_reserve").css('border', '1px solid #3d3d3d');
            $("#list_head_reserve").css('border-bottom-color', 'white');
            $("#list_head_cancel").css('background-color', '#f2f2f2');
            $("#list_head_cancel").css('border', '1px solid #dedede');
            $("#list_head_reserve").css('border-right-color', '#3d3d3d');
            $("#reserve_flag").val('0');
            document.reserve_flag_form.submit();
          }
        });
        //결제
        $("#list_head_cancel").click(function(){
          if($("#list_head_cancel").css('background-color')!="white"){
            $("#list_head_cancel").css('background-color', 'white');
            $("#list_head_cancel").css('border', '1px solid #3d3d3d');
            $("#list_head_cancel").css('border-bottom-color', 'white');
            $("#list_head_reserve").css('background-color', '#f2f2f2');
            $("#list_head_reserve").css('border', '1px solid #dedede');
            $("#list_head_reserve").css('border-right-color', '#3d3d3d');
            $("#reserve_flag").val('1');
            document.reserve_flag_form.submit();
          }
        });
        //월 클릭 -> days 변화 이벤트
        $("#month1").click(function(event) {
          var days = lastday($("#year1").val(), $(this).val());
          $("#day1").html("");
          for(var i=1; i<=days; i++){
            $("#day1").append("<option value="+i+">"+i+"</option>");
          }
        });
        $("#month2").click(function(event) {
          var days = lastday($("#year2").val(), $(this).val());
          $("#day2").html("");
          for(var i=1; i<=days; i++){
          $("#day2").append("<option value="+i+">"+i+"</option>");
          }
        });

        $("input[name='review_btn']").click(function(event) {

          var modal = document.getElementById('myModal');
          var r_pk = $(this).attr('id');
          //후기작성 or 후기확인
          var flag = $(this).val();
          var mode = '';
          if(flag !== null){
            switch (flag) {
              case '후기작성':
                mode = 'insert';
                break;
              case '후기확인':
                mode = 'view';
                break;
              default:
                break;
            }
          }
          if(mode=="view"){
            $.ajax({
              url: '../member_review/member_review.php',
              type: 'GET',
              data: {
                mode:mode,
                r_pk:r_pk
              }
            })
            .done(function(result){
              var review_output=$.parseJSON(result);
              document.getElementById('name').innerHTML = review_output[0].id;
              document.getElementById('title').value = review_output[0].title;
              document.getElementById('date').innerHTML = review_output[0].write_date;
              document.getElementById('satisfaction_grade').value = review_output[0].satisfaction_grade;
              document.getElementById('schedule_grade').value = review_output[0].schedule_grade;
              document.getElementById('cost_grade').value = review_output[0].cost_grade;
              document.getElementById('meal_grade').value = review_output[0].meal_grade;
              document.getElementById('content').value = review_output[0].content;
              document.getElementById('title').disabled=true;
              document.getElementById('satisfaction_grade').disabled=true;
              document.getElementById('schedule_grade').disabled=true;
              document.getElementById('cost_grade').disabled=true;
              document.getElementById('meal_grade').disabled=true;
              document.getElementById('content').disabled=true;
            })
            .fail(function() {
              console.log("error");
            })
            .always(function() {
              console.log("complete");

            });
          }
          var review_section = $("#review_section").html();
          $("#modal-content").html("");
          $("#modal-content").append("<h2>후기작성</h2><hr>");
          // $("#modal-content").append("<div name='message_content' style='margin-top:10px; height: 400px;'></div>");
          $("#modal-content").append("<form id='member_review_insert_form' name='member_review_insert_form' action='../member_review/member_review_query.php?mode=insert&r_pk="+r_pk+"' method='post'>");
          $("#member_review_insert_form").append(review_section);
          $("#member_review_insert_form").append('<div class="button-8" id="button-3">');

          $("#button-3").append('<div class="btn" onclick="modal_close()"><span>확인</span></div>');
          if(mode=="insert"){
            $("#member_review_insert_form").append('<div class="btn" onclick="document.getElementById(\'member_review_insert_form\').submit();"><span>등록</span></div>');
          }
          $("#member_review_insert_form").append("</div>");
          $("#modal-content").append("</form>");
          modal.style.display="block";
        });
      });
      function lastday(year, month){
        var res = new Date(year, month,0);
        res = res.getDate();
        return res;
      }
    </script>
  </head>
  <body>
    <?php
    $date2 =date("Y-m-d");
    $name2 = $_SESSION['name'];
    $id2 = $_SESSION['id'];
    ?>
    <div id="myModal" class="modal">
       <div class="modal-content" id="modal-content" style="width: 670px;">
        </div>
      </div>
      <form name="member_review_insert_form" action="member_review_query.php?mode=<?php if(isset($mode)) echo $mode;?>" method="post">
      <section id="review_section" style="display:none;" >
          <input type="hidden" name="r_pk" id="r_pk" value="<?php if(isset($r_pk)) echo $r_pk;?>">
        <table id="review_tbl" border="1">
          <tr>
            <th style="padding:8px">작성자</th>
            <td colspan="3" id="name"><?php if(isset($name)) echo $name;else{echo $name2;}?></td>
          </tr>
          <tr>
            <th style="padding:0">제목</th>
            <td colspan="3"><input type="text" id="title" name="title" value="<?php if(isset($title)) echo $title;?>"  maxlength="30"></td>
          </tr>
          <tr>
            <th style="padding:0">작성일</th>
            <td colspan="3" id="date"><?php if(isset($date)) echo $date;else{echo $date2;}?></td>

          </tr>
          <tr>
            <th  style="padding:0"><b>평점</b></th>
            <td colspan="3">
              만족도:<select class="" name="satisfaction_grade" id="satisfaction_grade" style="margin:2% 1%; padding:1%;width:80px;" >
                <?php
                define('GRADE',5);
                for ($g=GRADE; $g > 0; $g--) {
                  $selected='';
                  if(isset($satisfaction_grade) && $satisfaction_grade==$g){
                    $selected='selected';
                  }
                  echo '<option value="'.$g.'" '.$selected.'>'.$g.'</option>';
                }
                 ?>
              </select>

              일정:<select class="" name="schedule_grade" id="schedule_grade" style="margin:2% 1%; padding:1%; width:80px;">
                <?php
                define('GRADE',5);
                for ($g=GRADE; $g > 0; $g--) {
                  $selected='';
                  if(isset($schedule_grade) && $schedule_grade==$g){
                    $selected='selected';
                  }
                  echo '<option value="'.$g.'" '.$selected.'>'.$g.'</option>';
                }
                 ?>
              </select>

              가격:<select class="" name="cost_grade" id="cost_grade" style="margin:2% 1%; padding:1%; width:80px;">
                <?php
                define('GRADE',5);
                for ($g=GRADE; $g > 0; $g--) {
                  $selected='';
                  if(isset($cost_grade) && $cost_grade==$g){
                    $selected='selected';
                  }
                  echo '<option value="'.$g.'" '.$selected.'>'.$g.'</option>';
                }
                 ?>
              </select>

              식사:<select class="" name="meal_grade" id="meal_grade" style="margin:2% 1%; padding:1%; width:80px;">
                <?php
                define('GRADE',5);
                for ($g=GRADE; $g > 0; $g--) {
                  $selected='';
                  if(isset($meal_grade) && $meal_grade==$g){
                    $selected='selected';
                  }
                  echo '<option value="'.$g.'" '.$selected.'>'.$g.'</option>';
                }
                 ?>
              </select>
            </td>
          </tr>
          <tr>
            <th>내용</th>
            <td colspan="3"><textarea name="content" id="content" cols="80" rows="10" maxlength="100" placeholder="100자 이내로 입력해주세요."><?php if(isset($content)) echo $content;?></textarea></td>
          </tr>
        </table>
        <br>
          <div>

          </div>
      </section>
    </form>

    <form name="reserve_flag_form" action="reserve_list.php" method="post">
      <input type="hidden" name="reserve_flag" id="reserve_flag">
    </form>
    <div id="wrap">
    <header><?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/login_menu.php";?></header>
  <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/side_bar.php";?>
    <hr>
    <!--예약 리스트 페이지-->
    <div id="reserve_list" style="height:1500px;max-height:5000px;">
      <h3 id="title" >예약 및 결제 확인</h3>
      <fieldset id="i_field">
        <div id="i"><b>ⓘ</b></div><!-- end of div "i" -->
        <div id="i_div_ul">
          <ul>
            <li>예약코드를 클릭하시면 예약상세 페이지 확인이 가능하시며, 개별상품별 결제가 가능합니다.</li>
            <li>미결제로 취소된 예약 건의 경우 취소일로부터 3개월 경과 시 조회되지 않습니다.</li>
            <li>안내사항3</li>
            <li>안내사항4</li>
          </ul>
        </div>
      </fieldset>
      <br>
      <fieldset id="search_field">
        <span id="search_date">출발일</span>&nbsp;&nbsp;&nbsp;
        <select class="date_select" name="year1" id="year1" >
        <?php
          // 현재 연도 +- 2
          for ($i=$Y+2; $i > $Y-2 ; $i--) {
            if($i==$Y){
              echo '<option value="'.$i.'" selected >'.$i.'</option>';
            }else {
              echo '<option value="'.$i.'">'.$i.'</option>';
            }
          }
        ?>
        </select>년
        <select class="date_select" name="month1" id="month1">
          <?php
            // MONTH
            for ($i=1; $i <= 12 ; $i++) {
              if($i==$m){
                echo '<option value="'.$i.'" selected >'.$i.'</option>';
              }else {
                echo '<option value="'.$i.'">'.$i.'</option>';
              }
            }
          ?>
        </select>월

        <select class="date_select" name="day1" id="day1">
          <?php
            // DAYS
            for ($i=1; $i <= $t ; $i++) {
              if($i==$d){
                echo '<option value="'.$i.'" selected >'.$i.'</option>';
              }else {
                echo '<option value="'.$i.'">'.$i.'</option>';
              }
            }
          ?>
        </select>일
        &nbsp;~&nbsp;

        <select class="date_select" name="year2" id="year2" >
        <?php
          // 현재 연도 +- 2
          for ($i=$Y+2; $i > $Y-2 ; $i--) {
            if($i==$Y){
              echo '<option value="'.$i.'" selected >'.$i.'</option>';
            }else {
              echo '<option value="'.$i.'">'.$i.'</option>';
            }
          }
        ?>
        </select>년
        <select class="date_select" name="month2" id="month2">
          <?php
            // MONTH
            for ($i=1; $i <= 12 ; $i++) {
              if($i==$m){
                echo '<option value="'.$i.'" selected >'.$i.'</option>';
              }else {
                echo '<option value="'.$i.'">'.$i.'</option>';
              }
            }
          ?>
        </select>월
        <select class="date_select" name="day2" id="day2" >
          <?php
            // DAYS
            for ($i=1; $i <= $t ; $i++) {
              if($i==$d){
                echo '<option value="'.$i.'" selected >'.$i.'</option>';
              }else {
                echo '<option value="'.$i.'">'.$i.'</option>';
              }
            }
          ?>
        </select>일
          &nbsp;&nbsp;
        <input type="button" id="search_btn" name="" onclick="reserve_search_submit()" value="검색하기" >
      </fieldset>
      <form name="reserve_search_form" action="reserve_list.php?mode=search" method="post">
      <input type="hidden" name="h_year1" id="h_year1" value="">
      <input type="hidden" name="h_year2" id="h_year2" value="">
      <input type="hidden" name="h_month1" id="h_month1" value="">
      <input type="hidden" name="h_month2" id="h_month2" value="">
      <input type="hidden" name="h_day1" id="h_day1" value="">
      <input type="hidden" name="h_day2" id="h_day2" value="">
      </form>
      <script type="text/javascript">
        function reserve_search_submit(){
          var year1 = document.getElementById('year1');
          var year2 = document.getElementById('year2');
          var month1 = document.getElementById('month1');
          var month2 = document.getElementById('month2');
          var day1 = document.getElementById('day1');
          var day2 = document.getElementById('day2');

          var h_year1 = document.getElementById('h_year1');
          var h_year2 = document.getElementById('h_year2');
          var h_month1 = document.getElementById('h_month1');
          var h_month2 = document.getElementById('h_month2');
          var h_day1 = document.getElementById('h_day1');
          var h_day2 = document.getElementById('h_day2');
          h_year1.value = year1.value;
          h_year2.value = year2.value;
          h_month1.value = month1.value;
          h_month2.value = month2.value;
          h_day1.value = day1.value;
          h_day2.value = day2.value;
          document.reserve_search_form.submit();
        }

        function cancel(mode,pk){
          var result=confirm("삭제하시겠습니까?");
          if(result){
            window.location.href="reserve_list_query.php?r_pk="+pk+"&mode="+mode;
          }
        }

      </script>
      <br><br>
      <fieldset id="list_field" >
         <h4 id="sub_title"><b class="symbol_greater_than">></b>산뜻 예약/결제</h4>
        <table id="list_tbl_head"><tr><td id="list_head_reserve">예약내역</td><td id="list_head_cancel">취소내역</td></tr></table>
        <table id="list_tbl_body">
          <?php
          if($id=="admin"){
            echo '<tr>
              <td>예약날짜</td>
              <td colspan="2">상품코드/상품명</td>
              <td>총 결제금액(원)</td>
              <td>(ID)</td>
              <td>출발일/귀국일</td>
              <td>예약/결제상태</td>
              <td>취소</td>
              <td id="after">후기</td>
            </tr>';
          }else{
            echo '<tr>
              <td>예약날짜</td>
              <td colspan="2">상품코드/상품명</td>
              <td>총 결제금액(원)</td>
              <td>인원</td>
              <td>출발일/귀국일</td>
              <td>예약/결제상태</td>
              <td>취소</td>
              <td id="after">후기</td>
            </tr>';
          }
          ?>

          <output id="list_tbl_body_output">
            <?php
            mysqli_data_seek($result,$start_record);
            for ($record = $start_record; $record  < $start_record+ROW_SCALE && $record<$total_record; $record++){
              $row=mysqli_fetch_array($result);
              //예약날짜/ 예약 코드/ 상품명/ 총 결제금액/ 인원/ 출발일*귀국일 / 예약/결제상태 /취소 / 후기
              //예약 pk 저장
              $r_pk = $row['r_pk'];
              $id = $_SESSION['id'];
              $r_id = $row['r_id'];
              $r_date = $row['r_date'];
              $r_code=$row['r_code'];
              $r_cancel=$row['r_cancel'];
              $r_cancel_date=$row['r_cancel_date'];
              //상품명
              $p_name=$row['p_name'];
              //총 결제금액(결제 해야할 금액 - reserve.r_pay)
              $r_pay=$row['r_pay'];
              //인원
              $r_adult=$row['r_adult'];

              $r_kid=$row['r_kid'];
              $r_baby=$row['r_baby'];
              $r_total = $r_adult + $r_kid + $r_baby;
              //출발일/귀국일
              $p_dp_date=$row['p_dp_date'];
              $p_period=$row['p_period'];
              $timestamp = strtotime("$p_dp_date +$p_period days");
              $p_arr_date1 = date('y-m-d', $timestamp);
              $p_arr_date2 = "20".$p_arr_date1;
              //예약상태
              //총 상품금액
              $b_pay=isset($row['b_pay']);

              $p_pay=$row['p_pay'];
              //후기

              $reserve_status_sql = "SELECT sum(`r_adult`+`r_kid`+`r_baby`),`p_bus` from `package` inner join `reserve` on `package`.`p_code` = `reserve`.`r_code` where `reserve`.`r_code` = '$r_code';";
              $result_status_sql=mysqli_query($conn,$reserve_status_sql);
              $total=0;
              $status="";
              for($i=0;$i<mysqli_num_rows($result_status_sql);$i++){
                $row1 = mysqli_fetch_array($result_status_sql);
                $sum = $row1['sum(`r_adult`+`r_kid`+`r_baby`)'];
                $p_bus = $row1['p_bus'];
                $p_bus_half =(ceil($p_bus / 2));
                $total+=$sum;
              }

              if($id=="admin"){
                $bill_sql = "SELECT * FROM `bill` where `b_code`='$r_code' and `b_pk`='$r_pk';";
              }else{
                $bill_sql = "SELECT * FROM `bill` where `b_code`='$r_code' and `b_pk`='$r_pk' and `b_id`='$id';";
              }

              //결제상태
              $bill_result=mysqli_query($conn,$bill_sql);
              $count=mysqli_num_rows($bill_result);
              $bill_row=mysqli_fetch_array($bill_result);

              if($total<$p_bus_half){
                $status="예약완료";
                $cancel_status = '<input type="button" class="cancel_btn" onclick="cancel(\'update\',\''.$r_pk.'\')" name="cancel_btn" id="'.$r_pk.'" value="취소">';
              }


              if($total>=$p_bus_half){
                if($count!=0){
                  $status = "<p style='color:green;'>결제완료</p>";
                  $cancel_status = '<input type="button" class="cancel_btn" onclick="cancel(\'delete\',\''.$r_pk.'\')" name="cancel_btn" id="'.$r_pk.'" value="취소">';
                }else{
                  $status="<a style='color:red;' href='../bill/bill_view.php?&r_pk=$r_pk'>결제대기</a>";
                  $cancel_status = '<input type="button" class="cancel_btn" onclick="cancel(\'update\',\''.$r_pk.'\')" name="cancel_btn" id="'.$r_pk.'" value="취소">';
                }

              }
              $review_sql = "SELECT * FROM `member_review` where `r_pk`='$r_pk'";
              //취소
              $review_result=mysqli_query($conn,$review_sql);
              $review_row=mysqli_fetch_array($review_result);

              //해당 예약 항목의 후기 여부 확인 -> 후기 없으면 작성 form /있으면 보여주기
              //예약 목록의 도착 날짜와 현재 날짜 비교 => 여행을 다녀와야 후기 작성 가능
              $review_status =$review_row['num'];
              if(empty(mysqli_num_rows($review_result))){
                $disabled = '';
                //@@@@@ MINJI test 0530
                if($p_arr_date2>= date("Y-m-d")){ $disabled = 'disabled';}
                if($_SESSION['id']=="admin"){
                  $disabled="disabled";
                }
                $review_status='<input  type="button" class="review_btn" name="review_btn" '.$disabled.' id="'.$r_pk.'" value="후기작성">';
              }else{
                $review_status='<input type="button" class="review_btn" name="review_btn" id="'.$r_pk.'" value="후기확인">';
              }

              if($r_cancel=="1"){
                $status="취소";
                if($count=="0"){
                  $cancel_status = "<p style='color:red;'>취소완료</p>";
                }
                $review_status =$r_cancel_date;
              }
             ?>

             <?php
             if($id=="admin"){
               echo '<tr>
                 <td>'.$r_date.'</td >
                 <td colspan="2" style="width:"><a href="../package/package_view.php?mode='.$r_code.'">['.$r_code.']'.$p_name.'</a></td>
                 <td>'.$r_pay.'</td>
                 <td style="font-size:20px;">'.$r_id.'</td>
                 <td>'.$p_dp_date.'<br>'.$p_arr_date2.'</td>

                 <td>'.$status.'</td>
                 <td> '.$cancel_status.' </td>

                 <td>'.$review_status.'</td>
               </tr>';
             }else{
               echo '<tr>
                 <td>'.$r_date.'</td >
                 <td colspan="2" style="width:"><a href="../package/package_view.php?mode='.$r_code.'">['.$r_code.']'.$p_name.'</a></td>
                 <td>'.$r_pay.'</td>
                 <td>'.$r_total.'</td>
                 <td>'.$p_dp_date.'<br>'.$p_arr_date2.'</td>

                 <td>'.$status.'</td>
                 <td> '.$cancel_status.' </td>

                 <td>'.$review_status.'</td>
               </tr>';
             }

               }
              ?>

          </output>
        </table>
      </fieldset>
      <?php
      if(empty($total_record)){
        echo '<p id="no_result" style="text-align:center; padding:2%;margin-bottom:3%;">'.$alert.'</p><hr><br>';
      }
       ?>
       <!--$page 는 현재페이지를 의미 x / 각 페이지를 의미-->
      <div class="page_button_group">
        <?php
        //현재 블럭의 시작 페이지가 페이지 스케일 보다 클 때 -> 처음으로 버튼 생성 + 이전 블럭 존재
        //[ex]  page가 9개 있고 현재 페이지가 6페이지인 경우  / 12345/ 6789     =>  <<(처음으로) <(이전) 6 7 8 9
        if( $start_page > PAGE_SCALE ){
          // echo( '<a href='reserve_list.php?page=1'> << </a>' );
          echo( '<a href="reserve_list.php?page=1"><button type="button" name="button" title="처음으로"><<</button></a>' );

          // 이전 블럭 클릭 시 -> 현재 블럭의 시작 페이지 - 페이지 스케일
          // 현재 6 page 인 경우 '<(이전블럭)' 클릭 -> $pre_page = 6-PAGE_SCALE  -> 1 페이지로 이동
          $pre_block= $start_page - PAGE_SCALE;
          if(isset($_GET['mode']) && $_GET['mode']=="search"){
            echo( '<a href="reserve_list.php?mode=search&find_option=$find_option&find_input=$find_input&page='.$pre_block.'"><button type="button" name="button" title="이전"><</button></a>' );
          }else{
            echo( '<a href="reserve_list.php?page='.$pre_block.'"><button type="button" name="button" title="이전"><</button></a>' );
          }
        }

        //현재 블럭에 해당하는 페이지 나열
        for( $i = $start_page; $i <= $end_page; $i++ ){
            //현재 블럭에 현재 페이지인 버튼
            if ( $i == $page ){
              echo( '<a href="#"><button type="button" name="button" style="background-color: #2F9D27; border: 1px solid #2F9D27; color: white;">'.$i.'</button></a>' );
            }else if(isset($_GET['mode']) && $_GET['mode']=="search"){
              echo( '<a href="reserve_list.php?mode=search&find_option=$find_option&find_input=$find_input&page='.$i.'"><button type="button" name="button">'.$i.'</button></a>' );
            }else{
              echo( '<a href="reserve_list.php?page='.$i.'"><button type="button" name="button">'.$i.'</button></a>' );
            }
        }

        // 현재 블럭의 마지막 페이지 보다 총 페이지 수가 큰 경우, >(다음) 버튼 / >>(맨끝으로) 버튼 생성
        //[ex]  page가 9개 있고 현재 페이지가 6페이지인 경우  / 12345/ 6789     =>  <<(처음으로) <(이전) 6 7 8 9
        //[ex]  page가 9개 있고 현재 페이지가 1페이지인 경우  / 12345/ 6789     =>  1 2 3 4 5 >(다음) >>(맨끝으로)
        if( $total_pages > $end_page ){
          // 다음블럭 => 현재 블럭의 시작페이지 + 스케일
          // 클릭 시 다음 블럭의 첫 번째 페이지로 이동
          // [ex]  총 page 9개 있고 페이지가 3인  경우 / >(다음) 버튼 누르면 '6'으로 이동
          $next_block= $start_page + PAGE_SCALE;

          if(isset($_GET['mode']) && $_GET['mode']=="search"){
            echo( '<a href="reserve_list.php?mode=search&find_option=$find_option&find_input=$find_input&page='.$next_block.'"><button type="button" name="button">></button></a>' );
          }else{
            echo( '<a href="reserve_list.php?page='.$next_block.'"><button type="button" name="button" title="다음">></button></a>' );
          }

          //맨끝페이지로 이동
          echo( '<a href="reserve_list.php?page='.$total_pages.'"><button type="button" name="button" title="맨끝으로">>></button></a>' );
        }
        ?>
      </div>
    </div> <!-- end of div "reserve_list" -->
    <footer> <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/footer.php";?> </footer>
    </div>  <!-- end of div "wrap" -->
  </body>
</html>
