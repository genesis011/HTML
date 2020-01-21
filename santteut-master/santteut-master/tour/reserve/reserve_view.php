<?php
session_start();
$id = $_SESSION['id'];
include $_SERVER['DOCUMENT_ROOT']."/santteut/tour/lib/tour_query.php";
?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/common/css/login_menu.css?ver=7">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/tour/reserve/css/reserve_view.css?ver=1">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/common/css/side_bar.css?ver=0">
    <title>산뜻 :: 즐거운 산행</title>
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
  <script type="text/javascript">
  var count=0;
  var a=450;
  var b=0;
  var c=1;
  var scroll_count =0;
      var prevScrollpos = window.pageYOffset;
      window.onscroll = function() {
        var side_div =document.getElementById('side_div');
        var reserve_detail_menu =document.getElementById('reserve_detail_menu');
        // alert(side_div.style.height);
        // alert(reserve_detail_menu.style.height);
        realheight_div=reserve_detail_menu.style.height.substring(0,3);
        realheight_div=parseInt(realheight_div);
        // alert(realheight_div);
        side_div.style.height=realheight_div-360+"px";
        // side_div.height
      var currentScrollPos = window.pageYOffset;
        if(window.scrollY<=600){
        if (prevScrollpos > currentScrollPos) {
          move_sidebar_2();
        } else {
          if(a<650){
            move_sidebar();
          }

        }
        prevScrollpos = currentScrollPos;
      }
      }
    function move_sidebar(){
      a=a+10;
      c=c+10;
      var d=c+"px";
      var b =a+"px";
        $("#reserve_detail_menu").css('height', b);
        $("#reserve_finish").css('margin-top', d);
        // $("#reserve_button").css('padding-bottom', '20px');
    }
    function move_sidebar_2(){
      a=a-10;
      c=c-10;
      var d=c+"px";
      var b =a+"px";
      if(a>450){
        $("#reserve_detail_menu").css('height', b);
        $("#reserve_detail_menu").css('min-height', '430px');
        $("#reserve_finish").css('margin-top', d);
      }
    }
    $(document).ready(function() {
      if($("#last_seat").val()=="28"){
        $("#seat_box").css('margin-left', '200px');
        $("#seat_box").css('padding-top', '35px');
      }else{
        $("#seat_box").css('margin-left', '160px');
        $("#seat_box").css('padding-top', '30px');
      }
    });
  </script>
  <script type="text/javascript">
    window.onload = function() {
      var insert_seat="";
      onload_button_status();
      adult_control_btn('+','text_adult','*');
      kid_control_btn('+','text_kid','*');
      baby_control_btn('+','text_baby','*');
      var kid_side_div=document.getElementById('kid_side_div');
      var baby_side_div=document.getElementById('baby_side_div');
      var text_adult=document.getElementById('text_adult');
      var text_kid=document.getElementById('text_kid');
      var text_baby=document.getElementById('text_baby');
      var reserve_money=document.getElementById('reserve_money');
      var money_val=parseInt(reserve_money.value);
      var pay = <?= json_encode($p_pay)?>;
      pay=parseInt(pay);
      text_adult=parseInt(text_adult.value);
      text_kid=parseInt(text_kid.value);
      text_baby=parseInt(text_baby.value);
      reserve_money.innerHTML=((pay*text_adult)+(pay*text_kid*0.7)+(pay*text_baby*0.5)).toLocaleString();
      if(kid>0){
        kid_side_div.style.display="inline";
      }
      if(baby>0){
        baby_side_div.style.display="inline";
      }
  }
  </script>

  </head>
  <body >
    <input type="hidden" name="" value="">
    <!--로그인 회원가입 로그아웃-->
    <div id="wrap" style="height:2000px;;">
    <header>
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/login_menu.php";?>
    </header>
    <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/side_bar.php";?>
    <div id="middle2">
    <div id="top_text"><b>예약하기</b></div>
    <div id="tbl_div1">
      <div id="top_text2"><b>선택 상품정보</b></div>
      <table id="tbl1">
        <tr>
          <td class="left2" id="pac_name" >상품명</td>
          <td id="pac_name2"><?=$p_name?></td>
        </tr>

        <tr>
          <td class="left2" id="pac_code">상품코드</td>
          <td id="pac_code2"><?=$p_code?></td>
        </tr>
        <tr>
          <td rowspan="3" class="left2" id="sch1">일정</td>
          <td id="period1"><?=$p_period?>일</td>
        </tr>

        <tr>
          <td id="go"><div class="gb2" style="display:inline-block;">한국출발</div>  <?php echo $dp_date[0]."년 ".$dp_date[1]."월 ".$dp_date[2]."일 "." (".$day.") ".$p_dp_time ?></td>
        </tr>
        <tr>
          <td id="back"><div class="gb2" style="display:inline-block;">한국도착</div> <?php echo $dp_date2[0]."년 ".$dp_date2[1]."월 ".$dp_date2[2]."일 "." (".$day2.") ".$p_arr_time ?></td>
        </tr>
      </table>
    </div>

    <div id="tbl_div2">
      <div id="top_text3"><b>예약자 정보</b></div>
      <table id="tbl2">
        <tr>
          <td class="left2" id="res_name1">예약자명<p class="star">*</p></td>
          <td id="res_name_td"> <input disabled type="text" id="res_name" value="<?=$name?>"> </td>
          <td class="left2" id="res_phone1">휴대폰번호<p class="star">*</p></td>
          <td id="res_phone_td"> <input disabled type="text" id="res_phone" value="<?=$hp?>" placeholder="  '-' 없이 입력해주세요"> </td>
        </tr>

        <tr>
          <td class="left2" id="res_email0">이메일<p class="star">*</p></td>
          <td colspan="3" > <input disabled type="text" id="res_email1" value="<?=$email[0]?>"> @
            <select disabled id="res_email2" name="">
            <option value="">선택</option>
            <option value="" <?php if(isset($email[1]) && $email[1]==="naver.com") echo "selected";?>>naver.com</option>
            <option value="" <?php if(isset($email[1]) && $email[1]==="hanmail.net") echo "selected";?>>hanmail.net</option>
            <option value="" <?php if(isset($email[1]) && $email[1]==="google.com") echo "selected";?>>google.com</option>
            <option value="" <?php if(isset($email[1]) && $email[1]==="nate.com") echo "selected";?>>nate.com</option>
          </select></td>
        </tr>
      </table>
    </div>

    <div id="tbl_div3" style="height:auto;">
      <div id="tour_text1"><b>여행자 정보</b></div>
      <div id="tour_text2">  <b class="label_img">></b>  <b id="sel_text">인원선택</b> </div>
      <?php
          $adult_val=$_POST['adult_val']*1;
          $kid_val=$_POST['kid_val']*1;
          $baby_val=$_POST['baby_val']*1;
      ?>
      <table id="tbl3">
        <tr>
          <td class="left3">성인<br>(만 12세 이상)</td>
          <td>
            <div class="count">
              <button onclick="adult_control_btn('-','text_adult')" id="minus_btn_adult" type="button" class="minus"><span class="ir">-</span></button>
              <input id="text_adult" readonly type="text" value="<?=$adult_val?>" class="in1" >
              <button onclick="adult_control_btn('+','text_adult')" id="plus_btn_adult" type="button" class="plus"><span class="ir">+</span></button>
            </div>
          </td>
          <td class="left3">아동<br>(만 12세 미만)</td>
          <td>
            <div class="count">
              <button onclick="kid_control_btn('-','text_kid')"  id="minus_btn_kid" type="button" class="minus"><span class="ir">-</span></button>
              <input id="text_kid" readonly type="text" value="<?=$kid_val?>" class="in1" >
              <button onclick="kid_control_btn('+','text_kid')" id="plus_btn_kid" type="button" class="plus"><span class="ir">+</span></button>
            </div>
          </td>
          <td class="left3">유아<br>(만 2세 미만)</td>
          <td>
            <div class="count">
              <button onclick="baby_control_btn('-','text_baby')" id="minus_btn_baby" type="button" class="minus"><span class="ir">-</span></button>
              <input id="text_baby" readonly type="text" value="<?=$baby_val?>" class="in1" >
              <button onclick="baby_control_btn('+','text_baby')" id="plus_btn_baby" type="button" class="plus"><span class="ir">+</span></button>
            </div>
          </td>
        </tr>
      </table>

        <!-- 실행되는것 : 어른값 아동값 유아값 height 값 증가,감소  -->
      <script type="text/javascript">
        var adult_num=<?=json_encode($adult_val)?>;
        var kid_num=<?=json_encode($kid_val)?>;
        var baby_num=<?=json_encode($baby_val)?>;
        var wrap = document.getElementById('wrap');
        var height=wrap.style.height;
        var realheight=0;
        // 어른 수 함수
        function adult_control_btn(control,id,set){
          // alert(wrap.style.height);
          realheight=height.substring(0,4);
          realheight=parseInt(realheight);
          var id2 = document.getElementById(id);
          var text=id2.value;
          text=parseInt(text);
          if(control=="+"){
            if(set=="*"){
              id2.value=text;
              if(adult_num==0){
                adult_num++;
              }

            }else{
              id2.value=text+1;
              if(id=='text_adult'){
                if(adult_num>=10){
                adult_num=10;
                }else{
                adult_num++;
                }
              }
            }
          }else{
            id2.value=text-1;
              if(id=='text_adult'){
                if(adult_num<=1){
                adult_num=1;
              }else{
              adult_num--;
              }
                var test_table=document.getElementsByName('test_table')[adult_num-1];
                test_table.style.display="none";
            }
          }
          if(id2.value==11){
            id2.value=10;
          }else if(id=='text_adult'&&id2.value==0){
              id2.value=1;
              return false;
          }else if(id2.value==1){
            var test_table=document.getElementsByName('test_table')[0];
            test_table.style.display="none";
          }else if(id2.value==-1){
            id2.value=0;
          }

          for(var i=0;i<adult_num-1;i++){
            var test_table=document.getElementsByName('test_table')[i];
            test_table.style.display="block";
          }
          var a = parseInt(text_adult.value);
          var b = parseInt(text_kid.value);
          var c = parseInt(text_baby.value);
          wrap.style.height=realheight+(50*(a+b+c))+"px";
          var pay = <?= json_encode($p_pay)?>;
          pay=parseInt(pay);
          reserve_money.innerHTML=((pay*a)+(pay*b*0.7)+(pay*c*0.5)).toLocaleString();
            // alert(wrap.style.height);
        }
        // 아동 수 함수
        function kid_control_btn(control,id,set){
          // alert(wrap.style.height);
          realheight=height.substring(0,4);
          realheight=parseInt(realheight);
          var id2 = document.getElementById(id);
          var text=id2.value;
          text=parseInt(text);
          if(control=="+"){
            if(set=="*"){
              id2.value=text;
              if(id2.value==0){
                kid_side_div.style.display="none";
              }else{
                kid_side_div.style.display="inline";
              }
            }else{
            id2.value=text+1;
            if(id=='text_kid'){
              if(kid_num>=10){
              kid_num=10;
              }else{
              kid_num++;
              kid_side_div.style.display="inline";
              }
            }
          }
          }else{
            id2.value=text-1;
              if(id=='text_kid'){
                if(kid_num==1){
                  kid_side_div.style.display="none";
                }

                if(kid_num<=0){

                kid_num=0;
                kid_side_div.style.display="none";

              }else{
              kid_num--;
              }
                var test_table2=document.getElementsByName('test_table2')[kid_num];
                test_table2.style.display="none";
            }
          }
          if(id2.value==11){
            id2.value=10;
          }else if(id=='kid_num'&&id2.value==0){
              id2.value=1;
              return false;
          }else if(id2.value==1){
            var test_table2=document.getElementsByName('test_table2')[0];
            test_table2.style.display="none";
          }else if(id2.value==-1){
            id2.value=0;
          }
          for(var i=0;i<kid_num;i++){
            var test_table2=document.getElementsByName('test_table2')[i];
            test_table2.style.display="block";
          }
          var a = parseInt(text_adult.value);
          var b = parseInt(text_kid.value);
          var c = parseInt(text_baby.value);
          wrap.style.height=realheight+(50*(a+b+c))+"px";
          var pay = <?= json_encode($p_pay)?>;
          pay=parseInt(pay);
          reserve_money.innerHTML=((pay*a)+(pay*b*0.7)+(pay*c*0.5)).toLocaleString();
        }
      // 유아 수 함수
      function baby_control_btn(control,id,set){
        realheight=height.substring(0,4);
        realheight=parseInt(realheight);
        var id2 = document.getElementById(id);
        var text=id2.value;
        text=parseInt(text);
        if(control=="+"){
          if(set=="*"){
            if(id2.value==0){
              baby_side_div.style.display="none";
            }else{
              baby_side_div.style.display="inline";
            }
            id2.value=text;
          }else{
          id2.value=text+1;
          if(id=='text_baby'){
            if(baby_num>=10){
            baby_num=10;
            }else{
            baby_num++;
            baby_side_div.style.display="inline";
            }
          }
        }
        }else{
          id2.value=text-1;
            if(id=='text_baby'){
              if(baby_num==1){
                baby_side_div.style.display="none";
              }
              if(baby_num<=0){
              baby_num=0;
              baby_side_div.style.display="none";
            }else{
            baby_num--;
            }
              var test_table3=document.getElementsByName('test_table3')[baby_num];
              test_table3.style.display="none";
          }
        }
        if(id2.value==11){
          id2.value=10;
        }else if(id=='baby_num'&&id2.value==0){
            id2.value=1;
            return false;
        }else if(id2.value==1){
          var test_table3=document.getElementsByName('test_table3')[0];
          test_table3.style.display="none";
        }else if(id2.value==-1){
          id2.value=0;
        }

        for(var i=0;i<baby_num;i++){
          var test_table3=document.getElementsByName('test_table3')[i];
          test_table3.style.display="block";
        }
        var a = parseInt(text_adult.value);
        var b = parseInt(text_kid.value);
        var c = parseInt(text_baby.value);
        wrap.style.height=realheight+(50*(a+b+c))+"px";
        var pay = <?= json_encode($p_pay)?>;
        pay=parseInt(pay);
        reserve_money.innerHTML=((pay*a)+(pay*b*0.7)+(pay*c*0.5)).toLocaleString();
      }
      </script>

      <div id="check_eql">
        <input type="checkbox" id="box1" onclick="set_info()"><label for="box1"><p>성인1이 예약자와 동일</p></label>
      </div>

      <script type="text/javascript">
      var set_check=false;
        function set_info(){
          var set_name =document.getElementById('set_name');
          var phone_num =document.getElementById('phone_num');
          if(set_check==false){
            set_name.value=<?=json_encode($name)?>;
            phone_num.value=<?=json_encode($hp)?>;
            set_check =true;
          }else{
            set_name.value="";
            phone_num.value="";
            set_check =false;
          }
        }
      </script>
      <table id="tbl4"  >
        <tr>
          <td class="left4" colspan="2">한글이름<p class="star">*</p></td>
          <td class="left4">영문성<p class="star">*</p></td>
          <td class="left4">영문이름<p class="star">*</p></td>
          <td class="left4">성별<p class="star">*</p></td>
          <td class="left4">법정생년월일<p class="star">*</p></td>
          <td class="left4">휴대폰번호<p class="star">*</p></td>
        </tr>

        <tr>
          <td><b >성인1</b></td>
          <td id="name"class="inputs"><input name="adult_name_1" id="set_name" type="text" class="inputs1" value="" size="10"></td>
          <td class="inputs"><input name="adult_fe_name_1"  type="text" class="inputs1" id="input1" value=""></td>
          <td class="inputs"> <input name="adult_le_name_1" type="text" class="inputs1" value=""> </td>


          <td class="inputs"> <input name="adult_gender_1" type="radio" name="gen" id="male" value=""><label for="">남&nbsp;</label><input name="adult_gender_1" type="radio" name="gen" value=""><label for="">여</label></td>
          <td class="inputs"> <input name="adult_birr_1" type="text" id="inputs2" value=""> </td>
          <td class="inputs"> <input name="adult_ph_1" type="text" id="phone_num" value=""></td>
        </tr>
      </table>
      <?php
      for($i=2;$i<=10;$i++){
        echo '
        <table class="test_table1"name="test_table">
        <tr>
          <td class="test_class" colspan="2"></td>
          <td class="test_class"></td>
          <td class="test_class">&nbsp;</td>
          <td class="test_class"></td>
          <td class="test_class"></td>
          <td class="test_class"></td>
       </tr>

        <tr>
          <td><b >성인'.$i.'</b></td>
          <td  id="name"class="inputs" ><input name="name1_'.$i.'" type="text" class="inputs1" value="" size="10"></td>
          <td class="inputs"><input name="fe_name1_'.$i.'"  type="text" class="inputs1" id="input1" value=""></td>
          <td class="inputs"> <input name="le_name1_'.$i.'" type="text" class="inputs1" value=""> </td>
          <td class="inputs"> <input  type="radio" name="gen1_'.$i.'" id="male" value=""><label for="">남&nbsp;</label><input type="radio" name="gen1_'.$i.'" value=""><label for="">여</label></td>
          <td class="inputs"> <input name="bir1_'.$i.'" type="text" id="inputs2" value=""> </td>
          <td class="inputs"> <input name="ph1_'.$i.'" type="text" id="phone_num" value=""> </td>
        </tr>
        </table>';
      }

      for($i=1;$i<=10;$i++){
        echo '
        <table class="test_table1"name="test_table2">
        <tr>
          <td class="test_class" colspan="2"></td>
          <td class="test_class"></td>
          <td class="test_class">&nbsp;</td>
          <td class="test_class"></td>
          <td class="test_class"></td>
          <td class="test_class"></td>
       </tr>

        <tr>
          <td><b >아동'.$i.'</b></td>
          <td id="name"class="inputs"><input input name="name2_'.$i.'" type="text" class="inputs1" value="" size="10"></td>
          <td class="inputs"><input name="fe_name2_'.$i.'"  type="text" class="inputs1" id="input1" value=""></td>
          <td class="inputs"> <input name="le_name2_'.$i.'" type="text" class="inputs1" value=""> </td>
          <td class="inputs"> <input type="radio" name="gen2_'.$i.'" id="male" value=""><label for="">남&nbsp;</label><input type="radio" name="gen2_'.$i.'" value=""><label for="">여</label></td>
          <td class="inputs"> <input name="bir2_'.$i.'" type="text" id="inputs2" value=""> </td>
          <td class="inputs"> <input name="ph2_'.$i.'" type="text" id="phone_num" value=""> </td>
        </tr>
        </table>';
      }

      for($i=1;$i<=10;$i++){
        echo '
        <table class="test_table1"name="test_table3">
        <tr>
          <td class="test_class" colspan="2"></td>
          <td class="test_class"></td>
          <td class="test_class">&nbsp;</td>
          <td class="test_class"></td>
          <td class="test_class"></td>
          <td class="test_class"></td>
       </tr>

        <tr>
          <td><b >유아'.$i.'</b></td>
          <td id="name"class="inputs"><input name="name3_'.$i.'" type="text" class="inputs1" value="" size="10"></td>
          <td class="inputs"><input name="fe_name3_'.$i.'" type="text" class="inputs1" id="input1" value=""></td>
          <td class="inputs"> <input name="le_name3_'.$i.'" type="text" class="inputs1" value=""> </td>
          <td class="inputs"> <input type="radio" name="gen3_'.$i.'" id="male" value=""><label for="">남&nbsp;</label><input type="radio" name="gen3_'.$i.'" value=""><label for="">여</label></td>
          <td class="inputs"> <input name="bir3_'.$i.'" type="text" id="inputs2" value=""> </td>
          <td class="inputs"> <input name="ph3_'.$i.'" type="text" id="phone_num" value=""> </td>
        </tr>
        </table>';
      }
       ?>
    </div>
      <div id="tour_text3">  <b class="label_img">></b>  <b id="sel_seat">좌석선택</b> </div>
      <!-- <img src="img/bus.jpg" alt="" id="bus_form"> -->
      <div id="bus_seat">
        <div id="seat_box">
        <?php
        //우등버스인지 일반버스인지 넘겨주는 값
        $bus=$p_bus;
        if($bus==="28"){
          define('row', 2);
          define('col', 8);
          define('margin', 322);
          define('last', 28);
        }else{
          define('row', 3);
          define('col', 9);
          define('margin', 375);
          define('last', 41);
        }
        //****************************버스 좌석 생성
      for ($i=0; $i <=row ; $i++) {
        for ($j=0; $j <=col ; $j++) {
          $checked ='';
            if(isset($seat[((row+1)*$j+$i+1)])){
              $style='style="color:#CFCFCF;"';
              $checked ='style="color:#35cc2b;" checked disabled';
            }else{
              $style='style="color:#000000;"';
            }
            // 여기
            echo '<input id="'.((row+1)*$j+$i+1).'"  onclick="check_seat(\''.((row+1)*$j+$i+1).'\');" name="bus_seat_check" type="checkbox" value="'.((row+1)*$j+$i+1).'" '.$checked.'><b '.$style.'><label for="'.((row+1)*$j+$i+1).'">'.((row+1)*$j+$i+1).'</label></b>';
            echo "&nbsp;";
            if($j==col){
              echo "<br>";
              if($i==1){
                echo '<input  onclick="check_seat(\'last_seat\');" name="bus_seat_check" type="checkbox" id="last_seat" style="margin-left:'.margin.'px; margin-top:15px; margin-bottom:15px;" value="'.last.'" '.$checked.'><b '.$style.' ><label for="last_seat">'.last.'</label></b><br>';
              }
            }else if(((row+1)*$j+$i+1)==9 && !($bus=="1")){
               echo "&nbsp;&nbsp;";
            }
          }
        }
        ?>
        </div>
        <!-- 좌석시트 함수  -->
        <script type="text/javascript">
          function check_seat(seat){
          var seat=document.getElementById(seat);
          var text_adult=document.getElementById('text_adult');
          var text_kid=document.getElementById('text_kid');
          var text_baby=document.getElementById('text_baby');
          var a=parseInt(text_adult.value);
          var b=parseInt(text_kid.value);
          var c=parseInt(text_baby.value);
          var limit =a+b+c;
          if(count<limit){
            if(seat.checked==true){
              count++;
            }else{
              count--;
            }
          }else{
            if(seat.checked==false){
              count--;
            }else{
            alert('초과');
            seat.checked=false;
            }
          }
        }
        </script>
<!-- style="color:#35cc2b;" -->
        <div id="terms_view">
          <div id="all_agree">
            <input id="all_agree_btn" type="checkbox" name="all_choice_value" value="" onclick="all_choice_value()">
            <label for="all_agree_btn">전체동의하기</label>
            <script type="text/javascript">
              var choice =false;
              function all_choice_value(){
                if(choice==false){
                var h_y= document.getElementById('h_y');
                var n_y= document.getElementById('n_y');
                var c_y= document.getElementById('c_y');
                var a_y= document.getElementById('a_y');
                h_y.checked=true;
                n_y.checked=true;
                c_y.checked=true;
                a_y.checked=true;
                choice=true;
              }else{
                var h_y= document.getElementById('h_y');
                var n_y= document.getElementById('n_y');
                var c_y= document.getElementById('c_y');
                var a_y= document.getElementById('a_y');
                h_n.checked=true;
                n_n.checked=true;
                c_n.checked=true;
                a_n.checked=true;
                choice=false;
              }
              }
              function not_agree(){
                var all_agree_btn =document.getElementById('all_agree_btn');
                all_agree_btn.checked=false;
                choice =false;
              }
            </script>
          </div>
        <div id="term_btn">
          <button class="tablink" onclick="openPage('Home', this,'#bdbdbd','Home_choice_value')" id="defaultOpen">여행표준약관</button>
          <button  class="tablink" onclick="openPage('News', this,'#bdbdbd','News_choice_value')" >위치기반 서비스 동의</button>
          <button class="tablink"  onclick="openPage('Contact', this,'#bdbdbd','Contact_choice_value')">고유식별정보 수집</button>
          <button class="tablink" onclick="openPage('About', this,'#bdbdbd','About_choice_value')">개인정보활용 동의</button>
        </div>

        <div id="term_box">
        <div id="Home" class="tabcontent" >
          <h3>여행표준약관</h3>
          <p  ><b>제1조 (목적)</b></p>
          <p  >이 약관은 (주)하나투어(이하 ‘당사’라 한다.)와 여행자가 체결한 국외 여행계약의 세부 이행 및 준수 사항을 정함을 목적으로 합니다.</p>
          <br> <br><p  ><b>제2조 (당사와 여행자 의무)</b></p>
          <p  >1. 당사는 여행자에게 안전하고 만족스러운 여행서비스를 제공하기 위하여 여행알선 및 안내, 운송, 숙박 등 여행 계획의 수립 및 실행 과정에서 맡은 바 임무를 충실히 수행하여야 합니다.</p>
          <p  >2. 여행자는 안전하고 즐거운 여행을 위하여 여행자 간 화합도모 및 당사의 여행 질서 유지에 적극 협조하여야 합니다.</p>
          <br> <br><p  ><b>제3조 (용어의 정의)</b></p>
          <p  >여행의 종류 및 정의, 해외여행 수속대행업의 정의는 다음과 같습니다.</p>
          <p  >1) 기획여행 : 당사가 미리 여행 목적지 및 관광 일정, 여행자에게 제공될 운송 및 숙식 서비스 내용(이하 ‘여행서비스’라 함), 여행 요금을 정하여 광고 또는 기타 방법으로 여행자를 모집하여 실시하는 여행.</p>
          <p  >2) 희망여행 : 여행자(개인 또는 단체)가 희망하는 여행 조건에 따라 당사가 운송, 숙식, 관광 등 여행에 관한 전반적인 계획을 수립하여 실시하는 여행.</p>
          <p  >3) 해외여행 수속대행(이하 수속대행 계약이라 함) : 당사가 여행자로부터 소정의 수속대행 요금을 받기로 약정하고, 여행자의 위탁에 따라 다음에 열거하는 업무(이하 수속대행 업무라 함)를 대행하는 것.</p>
          <p  >가. 사증, 재입국 허가 및 각종 증명서 취득에 관한 수속</p>
          <p  >나. 출입국 수속 서류 작성 및 기타 관련 업무</p>
          <br> <br><p  ><b>제4조(계약의 구성)</b></p>
          <p  >1. 여행계약은 여행 계약서(붙임)와 여행약관, 여행 일정표(또는 여행 설명서)를 계약내용으로 합니다.</p>
          <p  >2. 여행 일정표(또는 여행 설명서)에는 여행일자 별 여행지와 관광 내용, 교통수단, 쇼핑 횟수, 숙박장소, 식사 등 여행 실시 일정 및 여행사 제공 서비스 내용과 여행자 유의사항이 포함되어야 합니다.</p>
          <br> <br><p  ><b>제5조 (특약)</b></p>
          <p  >당사와 여행자는 관계 법규에 위반되지 않는 범위 내에서 서면으로 특약을 맺을 수 있습니다. 이 경우 표준 약관과 다름을 당사는 여행자에게 설명하여야 합니다.</p>
          <br> <br><p  ><b>제6조 (안전정보 제공 및 계약서 등 교부)</b></p>
          <p  >당사는 여행자와 여행계약을 체결할 때 여행약관과 외교부 해외 안전여행 홈페이지(www.0404.go.kr)에 게재된 여행지 안전 정보를 제공하여야 하며, 여행계약을 체결한 경우 계약서와 여행 일정표 (또는 여행 설명서)를 각 1부씩 여행자에게 교부하여야 합니다.</p>
          <br> <br><p  ><b>제7조 (계약서 및 약관 등 교부 간주)</b></p>
          <p  >당사와 여행자는 다음 각 호의 경우 여행 계약서와 여행약관 및 여행 일정표(또는 여행 설명서)가 교부된 것으로 간주합니다.</p>
          <p  >1) 여행자가 인터넷 등 전자 정보망으로 제공된 여행 계약서, 약관 및 여행 일정표(또는 여행 설명서)의 내용에 동의하고 여행계약의 체결을 신청한 데 대해 당사가 전자 정보망 내지 기계적 장치 등을 이용하여 여행자에게 승낙의 의사를 통지한 경우</p>
          <p  >2) 당사가 팩시밀리 등 기계적 장치를 이용하여 제공한 여행 계약서, 약관 및 여행 일정표(또는 여행 설명서)의 내용에 대하여 여행자가 동의하고 여행계약의 체결을 신청하는 서면을 송부한 데 대해 당사가 전자 정보망 내지 기계적 장치 등을 이용하여 여행자에게 승낙의 의사를 통지한 경우</p>
          <br> <br><p  ><b>제8조 (당사의 책임)</b></p>
          <p  >당사는 여행 출발 시부터 도착 시까지 당사 본인 또는 그 고용인, 현지 여행업자 또는 그 고용인 등(이하 ‘사용인’이라 함)이 제2조 제1항에서 규정한 당사 임무와 관련하여 여행자에게 고의 또는 과실로 손해를 가한 경우 책임을 집니다.</p>
          <br> <br><p  ><b>제9조 (최저 행사 인원 미 충족 시 계약해제)</b></p>
          <p  >1. 당사가 최저 행사 인원 충족되지 아니하여 여행계약을 해제하는 경우 여행개시 7일 전까지 여행자에게 통지하여야 합니다.</p>
          <p  >2. 당사가 여행 참가자 수 미달로 전항의 기일 내 통지를 하지 아니하고 계약을 해제하는 경우 이미 지급받은 계약금 환급 외에 다음 각 항목의 1의 금액을 여행자에게 배상하여야 합니다.</p>
          <p  >1) 여행개시 1일전까지 통지 시 : 여행요금의 30%</p>
          <p  >2) 여행 당일 통지 시 : 여행요금의 50%</p>
          <p  > (※ 여행요금이란 일정표상 명시된 총 상품 가격을 의미한다)</p>
          <br> <br><p  ><b>제10조 (계약 체결 거절)</b></p>
          <p  >당사는 여행자에게 다음 각 호의 1에 해당하는 사유가 있을 경우에는 여행자와의 계약 체결을 거절할 수 있습니다.</p>
          <p  >1) 다른 여행자에게 폐를 끼치거나 여행의 원활한 실시에 지장이 있다고 인정될 때</p>
          <p  >2) 질병 기타 사유로 여행이 어렵다고 인정될 때</p>
          <p  >3) 명시한 최대 행사 인원이 초과되었을 때</p>
          <p  >4) 일정표에 최저 행사 인원이 미달되었을 때</p><br> <br>
        </div>

        <div id="News" class="tabcontent" >
          <h3>위치기반 서비스 동의</h3>
          <p ><b>제 1 조 (목적)</b></p>
          <p  >본 약관은 주식회사 하나투어(이하 “회사”)가 제공하는 위치기반서비스 약관에 부합하여 관련서비스 제공하는 회사와 개인위치정보주체와의 권리, 의무 및 책임사항, 기타 필요한 사항을 규정함을 목적으로 합니다.</p>
          <br><br>
          <p  ><b>제 2 조 (이용약관의 효력 및 변경)</b></p>
          <p  >① 본 약관은 서비스를 이용하는 고객 또는 개인위치정보주체가 본 약관에서 정의하는 회사의 서비스에 절차에 따라 동의함으로써 효력이 발생합니다.</p>
          <p  >② 이용자는 서비스의 동의 요청에 따라서 지정한 “동의” 선택 및 위치정보 조회에 대한 문자를 수신하였을 경우 이용자가 위치 정보와 관련된 내용을 충분히 이해하였으며, 그 적용에 동의한 것으로 봅니다.</p>
          <p  >③ 회사는 위치정보의 보호 및 이용 등에 관한 법률, 콘텐츠산업 진흥법, 전자상거래 등에서의 소비자보호에 관한 법률, 소비자기본법 약관의 규제에 관한 법률 등 관련법령을 위배하지 않는 범위에서 본 약관을 개정할 수 있습니다.</p>
          <p  >④ 회사가 약관을 개정할 경우에는 기존약관과 개정약관 및 개정약관의 적용일자와 개정사유를 명시하여 현행약관과 함께 그 적용일자 10일 전부터 적용일 이후 상당한 기간 동안 공지만을 하고, 개정 내용이 이용자에게 불리한 경우에는 그 적용일자 30일 전부터 적용일 이후 상당한 기간 동안 각각 이를 서비스 홈페이지에 게시하거나 이용자에게 음성 또는 전자적 형태(SMS 등)로 약관 개정 사실을 발송하여 고지합니다.</p>
          <p  >⑤ 회사가 전항에 따라 이용자에게 통지하면서 공지 또는 공지? 고지일로부터 개정약관 시행일 7일 후까지 거부의사를 표시하지 아니하면 이용약관에 승인한 것으로 봅니다.</p>
          <br><br>
          <p  ><b>제 3 조 (관계법령의 적용)</b></p>
          <p  >본 약관은 신의성실의 원칙에 따라 공정하게 적용하며, 본 약관에 명시되지 아니한 사항에 대하여는 관계법령 또는 상관례에 따릅니다.</p>
          <br><br>
          <p  ><b>제 4조 (서비스의 내용)</b></p>
          <p  >① 회사는 직접 위치정보를 수집하거나 위치정보사업자로부터 위치정보를 전달받아 아래와 같은 위치기반서비스를 제공합니다.</p>
          <p  >1. 산뜻 고객센터 : (지역번호없이) 02-000-0000 발신 고객 중 위치정보활용에 동의한 고객에 한하여 이용자와 가까운 위치에
          있는 산뜻 상담원과 전화 연결</p>
          <p  >2. 상품예약서비스 : PC IP 정보 및 모바일 GPS 위치정보를 활용하여 가까운 하나투어 (도우미 여행사) 예약 연결</p>
          <p  >3. 여행정보 서비스 제공 : 개인위치정보주체 또는 이동성이 있는 기기의 위치정보를 제공 시 위치정보를 이용한 여행정보, 이벤트 등
            다양한 편의 서비스를 제공합니다.</p>
          <p  >② 회사는 만 14세 이상의 회원에 대해서만 개인위치정보를 이용한 위치기반서비스를 제공합니다.</p>
          <br><br>
          <p  ><b>제 5 조 (서비스 이용요금)</b></p>
          <p  >회사가 제공하는 서비스는 기본적으로 무료입니다.</p>
            <br><br>
        </div>

        <div id="Contact" class="tabcontent" >
          <br>
          <h3>고유식별정보 수집</h3>
          <br><br><p class="information_collect" ><b>당사는 개인정보보호법을 준수하며 서비스 수행의 목적에 한하여 최소한의 고유식별정보를 수집,이용하며 기준은 아래와 같습니다.</b></p>
          <br><br><p class="information_collect"><b>1. 고유식별 정보 수집/이용 목적 : 해외여행 상품예약시 출국가능 여부파악 및 여행자 본인식별</b></p>
          <br><br><p class="information_collect"><b>2. 수집하는 고유식별 정보의 항목 : 여권번호 (여권만료일)</b></p>
          <br><br><p class="information_collect"><b>3. 고유식별정보의 보유 및 이용기간 : 여행상품 서비스 수행목적의 완료시점까지</b></p>
          <br><br><p class="information_collect"><b>*동의거부권</b></p>
          <br><br><p class="information_collect"><b>개인정보주체는 고유식별정보(여권번호 등) 에 대한 수집동의를 거부할 권리가 있습니다.</b></p>
          <p class="information_collect"><b>동의를 거부할 경우 출국자 확인이 불가하여 예약서비스 수행이 불가함을 알려드립니다.</b></p>
          <br><br>
        </div>

        <div id="About" class="tabcontent" >
          <h3>개인정보활용 동의</h3>
          <br><br><p class="information_collect"><b>1. 개인정보 활용 목적</b></p>
          <p class="information_collect"><b>고객님의 개인정보는 고객님에게 적합한 맞춤 여행상품 안내서비스 및 맞춤 상담을 위해 아래와 같이 활용될 수 있습니다.</b></p>
          <p class="information_collect" style="font-size:14px;"><b>(1) 회사의 여행 상품 및 여행관련 서비스를 이용한 고객에게 한정하여 회사가 기획한 여행상품이나 다양한 맞춤서비스 홍보 및 안내하기 위하여 개인정보 개인정보 활용에 동의한 고객에게 다양한 맞춤 서비스를 제공할 수 있습니다.</b></p>
          <p class="information_collect" style="font-size:14px;"><b>(2) 신규서비스 개발 및 특화, 인구통계학적 특성에 따른 서비스 제공 및 광고 게재, 당사 및 제휴사 상품 / 제휴카드 안내, 이벤트 등 광고성 정보 전달, 회원의 서비스 이용에 대한 통계, 회원 대상 각종 마케팅 활동에 활용됩니다.</b></p>
          <br><br><p class="information_collect"><b>2. 개인정보의 이용 및 보유기간</b></p>
          <p class="information_collect"><b>개인정보 활용에 동의한 고객님에 한해 서비스 제공 및 관계 법령에 따른 보존기간까지</b></p>
          <br><br><p class="information_collect"><b>3. 동의를 거부할 권리 및 동의를 거부할 경우의 불이익</b></p>
          <p class="information_collect"><b>개인정보주체는 개인정보 활용에 대한 동의를 거부할 권리가 있습니다. 동의를 거부할 경우 여행 맞춤 서비스 및 정보제공이 일부 제한 될 수 있으며 회원가입 및 여행서비스 이용에는 영향이 없습니다.</b></p>
          <br><br><br><br>
        </div>
        <div id="choice_values">
        <p class="choice_value" id="Home_choice_value" ><b>(여행표준약관)</b><input type="radio" name="Home_choice_value" value="" id="h_y">동의합니다.&nbsp;&nbsp;&nbsp;&nbsp;<input id="h_n" onclick="not_agree()" type="radio" name="Home_choice_value" value="" checked>동의하지 않습니다.</p>
        <p class="choice_value" id="News_choice_value"  ><b>(위치기반 서비스 동의)</b><input type="radio" name="News_choice_value" value="" id="n_y">동의합니다.&nbsp;&nbsp;&nbsp;&nbsp;<input onclick="not_agree()" id="n_n" type="radio" name="News_choice_value" value="" checked>동의하지 않습니다.</p>
        <p class="choice_value" id="Contact_choice_value"  ><b>(고유식별정보 수집)</b><input type="radio" name="Contact_choice_value" value="" id="c_y">동의합니다.&nbsp;&nbsp;&nbsp;&nbsp;<input onclick="not_agree()" id="c_n" type="radio" name="Contact_choice_value" value="" checked>동의하지 않습니다.</p>
        <p class="choice_value" id="About_choice_value" ><b>(개인정보활용 동의)</b><input type="radio" name="About_choice_value" value="" id="a_y">동의합니다.&nbsp;&nbsp;&nbsp;&nbsp;<input onclick="not_agree()"; id="a_n" type="radio" name="About_choice_value" value="" checked>동의하지 않습니다.</p>
        </div>
        </div>
        <script>
        function openPage(pageName,elmnt,color,choiceName) {
          var i, tabcontent, tablinks;
          tabcontent = document.getElementsByClassName("tabcontent");
          choice_value = document.getElementsByClassName("choice_value");
          for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
            choice_value[i].style.display = "none";
          }
          tablinks = document.getElementsByClassName("tablink");
          for (i = 0; i < tablinks.length; i++) {
            tablinks[i].style.backgroundColor = "";
          }
          document.getElementById(pageName).style.display = "block";
          document.getElementById(choiceName).style.display = "block";
          elmnt.style.backgroundColor = color;
        }
        document.getElementById("defaultOpen").click();
        </script>
        </div>
      </div>
      <!-- end of middle2 -->
      </div>
      <div id="reserve_detail_menu">
        <div id="cost_info">
          <p>상품요금정보</p>
        </div>
        <div id="reserve_pay_view">
          <p id="reserve_total_pay">최종결제금액</p>
          <b id="reserve_money"><?=$p_pay*1?></b> <p id="won">원</p>
          <p class="subtext2">유류할증료,제세공과금 포함</p>
          <p class="subtext2">※발권일/환율에 따라 변경 가능합니다</p>
          <p class="line">---------------------------------------</p>
          <div id="side_div" style="overflow-y: scroll; height:100px;" >

            <div style="display:inline">
              <p style="display:inline">&nbsp;<b>성인</b></p>
              <b id="adult_val" style="font-size:25px;">&nbsp;&nbsp;&nbsp;&nbsp;<?=$p_pay?>원</b><br>
              <p style="font-size:6px; margin:0px; display:inline;">&nbsp;(만 12세 이상)</p>
              <p style="display:inline-block; margin:0px; color:gray;">--------------------</p>
              <p style="display:inline-block; margin:0px; color:gray;font-size:10px; "><b width:300px;>기본상품가격</b> <b style="text-align:center;"><?=$p_pay*0.922?>원</b></p><br>
              <p style="display:inline-block; margin:0px; color:gray;font-size:10px; "><b width:300px;>유류할증료</b> <b style="text-align:center;">&nbsp;&nbsp;&nbsp;<?=$p_pay*0.078?>원</b> </p>
              <hr style="border-color: #5D5D5D;">
            </div>

            <div id="kid_side_div" style="display:none;">
              <p style="display:inline">&nbsp;<b>아동</b></p>
              <b style="font-size:25px;">&nbsp;&nbsp;&nbsp;&nbsp;<?=$p_pay*0.7?>원</b><br>
              <p style="font-size:6px; margin:0px; display:inline;">&nbsp;(만 12세 미만)</p>
              <p style="display:inline-block; margin:0px; color:gray;">--------------------</p>
              <p style="display:inline-block; margin:0px; color:gray;font-size:10px; "><b width:300px;>기본상품가격</b> <b style="text-align:center;"><?=$p_pay*0.922*0.7?>원</b></p><br>
              <p style="display:inline-block; margin:0px; color:gray;font-size:10px; "><b width:300px;>유류할증료</b> <b style="text-align:center;">&nbsp;&nbsp;&nbsp;<?=$p_pay*0.078*0.7?>원</b> </p>
              <hr style="border-color: #5D5D5D;">
            </div>

            <div id="baby_side_div" style="display:none;">
              <p style="display:inline">&nbsp;<b>유아</b></p>
              <b style="font-size:25px;">&nbsp;&nbsp;&nbsp;&nbsp;<?=$p_pay*0.5?>원</b><br>
              <p style="font-size:6px; margin:0px; display:inline;">&nbsp;(만2세 미만)</p>
              <p style="display:inline-block; margin:0px; color:gray;">--------------------</p>
              <p style="display:inline-block; margin:0px; color:gray;font-size:10px; "><b width:300px;>기본상품가격</b> <b style="text-align:center;"><?=$p_pay*0.922*0.5?>원</b></p><br>
              <p style="display:inline-block; margin:0px; color:gray;font-size:10px; "><b width:300px;>유류할증료</b> <b style="text-align:center;">&nbsp;&nbsp;&nbsp;<?=$p_pay*0.078*0.5?>원</b> </p>
              <hr style="border-color: #5D5D5D;">
            </div>
          </div>
        </div>
        <div id="increase_box" ></div>
        <div id="reserve_button">
          <div id="reserve_finish" onclick="check_form()" > <b id="status"><?=$status2?></b></div><br>
        </div>
        <div id="right_footer"></div>
      </div>
      <script type="text/javascript">

        function onload_button_status(){
          var reserve_finish = document.getElementById('reserve_finish');
          var status = document.getElementById('status');
          if(status.innerHTML=="예약마감"){
            reserve_status.style.backgroundColor = "#aaaaaa";
          }
        }

        function check_form(){

          var adult = document.getElementById('text_adult');
          var kid = document.getElementById('text_kid');
          var baby = document.getElementById('text_baby');
          var insert_seat="";
          var bus_seat_check=document.getElementsByName('bus_seat_check');
          for(var i=0;i< <?=json_encode($bus)?> ; i++){
            if(bus_seat_check[i].checked==true&&bus_seat_check[i].disabled==false){
              insert_seat=insert_seat+"/"+bus_seat_check[i].value;
            }
          }

          var adult_val=parseInt(adult.value);
          var kid_val=parseInt(kid.value);
          var baby_val=parseInt(baby.value);
          var member_num=adult_val+kid_val+baby_val;

          if(!<?=json_encode($p_code)?>){
            alert("코드값이 없습니다.");
            return false;
          }else if(count<member_num){
            alert("좌석을 알맞게 선택해주세요");
            for(var i=0;i< <?=json_encode($bus)?> ; i++){
              if(bus_seat_check[i].disabled==false){
                bus_seat_check[i].checked=false;
                count=0;
              }
            }
            var insert_seat="";
            return false;
          }else if(!member_num){
            alert("인원을선택해주세요");
          }
          var bus_seat_check=document.getElementsByName('test_table');
          var bus_seat_check2=document.getElementsByName('test_table2');
          var bus_seat_check3=document.getElementsByName('test_table3');

          var adult_name_1=document.getElementsByName('adult_name_1');
          var adult_fe_name_1=document.getElementsByName('adult_fe_name_1');
          var adult_le_name_1=document.getElementsByName('adult_le_name_1');
          var adult_gender_1=document.getElementsByName('adult_gender_1');
          var adult_birr_1=document.getElementsByName('adult_birr_1');
          var adult_ph_1=document.getElementsByName('adult_ph_1');

          if(adult_name_1[0].value==false){
            alert("성인1 의 이름을 입력해주세요");
            return false;
          }
          if(adult_fe_name_1[0].value==false){
            alert("성인1 의 영문성을 입력해주세요");
            return false;
          }
          if(adult_le_name_1[0].value==false){
            alert("성인1의 영문이름을 입력해주세요");
            return false;
          }
          if(adult_gender_1[0].checked==false&&adult_gender_1[1].checked==false){
            alert("성인1의 성별을 선택해주세요");
            return false;
          }
          if(adult_birr_1[0].value==false){
            alert("성인1의 법정생년월일을 입력해주세요");
            return false;
          }
          if(adult_ph_1[0].value==false){
            alert("성인1의 휴대폰번호를 입력해주세요");
            return false;
          }

          for(var i=0;i<8;i++){
            if(bus_seat_check[i].style.display=="block"){
              var name1=document.getElementsByName('name1_'+(i+2));
              var fe_name1=document.getElementsByName('fe_name1_'+(i+2));
              var le_name1_=document.getElementsByName('le_name1_'+(i+2));
              var gen1_=document.getElementsByName('gen1_'+(i+2));
              var bir1_=document.getElementsByName('bir1_'+(i+2));
              var ph1_=document.getElementsByName('ph1_'+(i+2));
              if(name1[0].value==false){
                alert("성인"+(i+2)+"의 이름을 입력해주세요");
                return false;
              }
              if(fe_name1[0].value==false){
                alert("성인"+(i+2)+"의 영문성을 입력해주세요");
                return false;
              }
              if(le_name1_[0].value==false){
                alert("성인"+(i+2)+"의 영문이름을 입력해주세요");
                return false;
              }
              if(gen1_[0].checked==false&&gen1_[1].checked==false){
                alert("성인"+(i+2)+"의 성별을 선택해주세요");
                return false;
              }
              if(bir1_[0].value==false){
                alert("성인"+(i+2)+"의 법정생년월일을 입력해주세요");
                return false;
              }
              if(ph1_[0].value==false){
                alert("성인"+(i+2)+"의 휴대폰번호를 입력해주세요");
                return false;
              }
            }
          }
          for(var i=0;i<=9;i++){
            if(bus_seat_check2[i].style.display=="block"){
              var name2=document.getElementsByName('name2_'+(i+1));
              var fe_name2=document.getElementsByName('fe_name2_'+(i+1));
              var le_name2_=document.getElementsByName('le_name2_'+(i+1));
              var gen2_=document.getElementsByName('gen2_'+(i+1));
              var bir2_=document.getElementsByName('bir2_'+(i+1));
              var ph2_=document.getElementsByName('ph2_'+(i+1));

              if(name2[0].value==false){
                alert("아동"+(i+1)+"의 이름을 입력해주세요");
                return false;
              }
              if(fe_name2[0].value==false){
                alert("아동"+(i+1)+"의 영문성을 입력해주세요");
                return false;
              }
              if(le_name2_[0].value==false){
                alert("아동"+(i+1)+"의 영문이름을 입력해주세요");
                return false;
              }
              if(gen2_[0].checked==false&&gen2_[1].checked==false){
                alert("아동"+(i+1)+"의 성별을 선택해주세요");
                return false;
              }
              if(bir2_[0].value==false){
                alert("아동"+(i+1)+"의 법정생년월일을 입력해주세요");
                return false;
              }
              if(ph2_[0].value==false){
                alert("아동"+(i+1)+"의 휴대폰번호를 입력해주세요");
                return false;
              }
            }
          }
          for(var i=0;i<=9;i++){
            if(bus_seat_check3[i].style.display=="block"){
              var name3=document.getElementsByName('name3_'+(i+1));
              var fe_name3_=document.getElementsByName('fe_name3_'+(i+1));
              var le_name3_=document.getElementsByName('le_name3_'+(i+1));
              var gen3_=document.getElementsByName('gen3_'+(i+1));
              var bir3_=document.getElementsByName('bir3_'+(i+1));
              var ph3_=document.getElementsByName('ph3_'+(i+1));

              if(name3[0].value==false){
                alert("유아"+(i+1)+"의 이름을 입력해주세요");
                return false;
              }
              if(fe_name3_[0].value==false){
                alert("유아"+(i+1)+"의 영문성을 입력해주세요");
                return false;
              }
              if(le_name3_[0].value==false){
                alert("유아"+(i+1)+"의 영문이름을 입력해주세요");
                return false;
              }
              if(gen3_[0].checked==false&&gen3_[1].checked==false){
                alert("유아"+(i+1)+"의 성별을 선택해주세요");
                return false;
              }
              if(bir3_[0].value==false){
                alert("유아"+(i+1)+"의 법정생년월일을 입력해주세요");
                return false;
              }
              if(ph3_[0].value==false){
                alert("유아"+(i+1)+"의 휴대폰번호를 입력해주세요");
                return false;
              }
            }
          }
          var h_y= document.getElementById('h_y');
          var n_y= document.getElementById('n_y');
          var c_y= document.getElementById('c_y');
          var a_y= document.getElementById('a_y');
          if(h_y.checked!=true){
            alert("여행표준약관에 동의하세요");
            return false;
          }else if(n_y.checked!=true){
            alert("위치기반서비스에 동의하세요");
            return false;
          }else if(c_y.checked!=true){
            alert("고유식별정보수집에 동의하세요");
            return false;
          }else if(a_y.checked!=true){
            alert("개인정보활용에 동의하세요");
            return false;
          }
          var reserve_money=document.getElementById('reserve_money');
            reserve_money.innerHTML

          $.ajax({
            url: 'reserve_query.php',
            type: 'POST',
            data: {
              code:<?=json_encode($p_code)?>
              ,seat:insert_seat
              ,member_num:member_num
              ,adult:adult_val
              ,kid:kid_val
              ,baby:baby_val
              ,money:reserve_money.innerHTML
            }
          })
          .done(function(result) {
            var output = $.parseJSON(result);
            var status = output[0].status;
            var r_pk = output[0].r_pk;
            alert(status);
            // alert(r_pk);
            if(status=="결제가능"){
              location.href='../bill/bill_view.php?r_pk='+r_pk;
            }else{
              location.href='reserve_complete.php?p_code=<?=json_encode($p_code)?>&p_name=<?=json_encode($p_name)?>&member_num='+member_num+'&adult_val='+adult_val+'&kid_val='+kid_val+'&baby_val='+baby_val;
            }
          })
          .fail(function() {
            console.log("error");
          })
          .always(function() {
            console.log("complete");
          });
        }
      </script>
  <!-- end of wrap -->
  </div>
  <footer>
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/footer.php";?>
  </footer>
  </body>
</html>
