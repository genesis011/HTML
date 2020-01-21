<?php
include $_SERVER['DOCUMENT_ROOT']."/santteut/tour/bill/bil_query.php";
?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/common/css/login_menu.css">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/tour/package/css/package_list.css">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/tour/bill/css/bill_view.css">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/common/css/side_bar.css">
    <script type="text/javascript" src="https://service.iamport.kr/js/iamport.payment-1.1.5.js"></script>
    <script  src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <!-- 카카오페이 -->
      <script type="text/javascript">
    function payment(){
      var IMP = window.IMP; // 생략가능
      IMP.init('imp16652312'); //가맹점 식별 코드
     //아래 입력된 정보는 테스트를 위한것.
     //원래는 주문자 정보를 가져와서 넣어야함.
      IMP.request_pay({
          pg : 'kakaopay', //결제방식
          pay_method : 'card', //결제 수단
          merchant_uid : 'merchant_' + new Date().getTime(),
          name : '<?=$p_name?>', //order 테이블에 들어갈 주문명 혹은 주문 번호
          amount : '<?=$r_pay?>', //주문 금액
          buyer_name : '<?=$m_name?>', //구매자 이름
          kakaoOpenApp : true
      }, function(rsp) {
       //callback함수
          if ( rsp.success ) { //결제 성공시
             //[1] 서버단에서 결제정보 조회를 위해 jQuery ajax로 imp_uid 전달하기
             jQuery.ajax({
                url: "/payments/complete", //cross-domain error가 발생하지 않도록 주의해주세요
                type: 'POST',
                dataType: 'json',
                data: {
                   imp_uid : rsp.imp_uid
                   //기타 필요한 데이터가 있으면 추가 전달
                }
             }).done(function(data) {
                //[2] 서버에서 REST API로 결제정보확인 및 서비스루틴이 정상적인 경우
                if ( everythings_fine ) {
                   var msg = '결제가 완료되었습니다.';
                   msg += '\n고유ID : ' + rsp.imp_uid;
                   msg += '\n상점 거래ID : ' + rsp.merchant_uid;
                   msg += '\n결제 금액 : ' + rsp.paid_amount;
                   msg += '카드 승인번호 : ' + rsp.apply_num;

                    var select_bank=document.getElementById('select_bank');
                    alert(msg);
                } else {
                   //[3] 아직 제대로 결제가 되지 않았습니다.
                   //[4] 결제된 금액이 요청한 금액과 달라 결제를 자동취소처리하였습니다.
                }
             });
             alert('결제가 완료되었습니다.');
             location.href="bill_insert_query.php?r_pk=<?=$r_pk?>&way=2&r_pay=<?=$r_pay?>&p_code=<?=$p_code?>&p_name=<?=$p_name?>&b_seat=<?=$b_seat?>";

          }else{
           var msg = '결제에 실패하였습니다.';
           msg += '에러내용 : ' + rsp.error_msg;
           alert(msg);
           // alert('결제가 실패되었습니다.');
          return false;
          }//end of else

      });
      }
    </script>
    <title>산뜻 :: 즐거운 산행</title>
    <!--보험/결제   -->
    <script type="text/javascript">
    function insurance_field_click(){
        var con = document.getElementById("insurance_field");
        var con2 = document.getElementById("payment_imformation_field");
        var button1 = document.getElementById("insurance_btn");
        var button2 = document.getElementById("payment_imformation_btn");

        if(con.style.display=='none'){
            con.style.display = 'block';
            button1.style.backgroundColor='#35cc2b';
            button2.style.backgroundColor='#2F9D27';
            con2.style.display='none'
        }
    }
    function payment_imformation_field_click(){
        var con = document.getElementById("insurance_field");
        var con2 = document.getElementById("payment_imformation_field");
        var button1 = document.getElementById("insurance_btn");
        var button2 = document.getElementById("payment_imformation_btn");
        if(con2.style.display=='none'){
            con2.style.display = 'block';
            button2.style.backgroundColor='#35cc2b';
            button1.style.backgroundColor='#2F9D27';
            con.style.display='none'
        }
    }
    function payment_choice_direct_radiobtn_click(){
        var con = document.getElementById("payment_choice_direct_detail_1");
        var con2 = document.getElementById("payment_choice_direct_detail_2");
        var con3 = document.getElementById("payment_choice_direct_detail_3");
        var var3 ='<p>· 무통장입금은 지정된 고유계좌번호로 구매대금을 입금하는 방식으로 입금은행을 선택하시면 선택은행의 가상계좌번호가 발급됩니다.</p>';
        var3=var3+'<p>· 발급된 가상계좌에 최종결제금액을 입금하셔야 결제가 완료되며 입금금액이 정확할 경우 예약자/입금자명이 달라도 정상입금 처리됩니다.</p>';
        var3=var3+'<p>· 해외은행계좌에서 입금시에는 반드시 원화로 입금하셔야 됩니다.</p>';
        var3=var3+'<p>· 해외호텔의 경우 무통장입금 신청일의 환율기준으로 최종결제금액이 확정되며 이후 변동 불가합니다.</p>';
        var3=var3+'<p id="final_mention">· 고객님! 예금주가 산뜻인지 확인해주세요. 고객 직접 입금을 권장합니다</p>';
        con.innerHTML="입금은행 선택";
        con2.innerHTML='<select id="select_bank"><option>선택해주세요</option><option>국민은행</option><option>하나은행</option><option>신한은행</option><option>기업은행</option></select>';
        con3.innerHTML=var3;
    }
    function kakopay_radiobtn_click(){
        var con = document.getElementById("payment_choice_direct_detail_1");
        var con2 = document.getElementById("payment_choice_direct_detail_2");
        var con3 = document.getElementById("payment_choice_direct_detail_3");
        var var3 ='<p>· 본인명의 휴대폰에서 본인명의 카드 등록 후 사용 가능합니다.</p>';
        var3=var3+'<p>· 카카오페이 무이자할부/제휴카드 혜택은 카카오페이 규정에 따르며 해당App에서 확인 가능합니다.</p>';
        con.innerHTML="카카오페이";
        con2.innerHTML='<img class="kakopay_img" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/common/img/kakaopay.jpg">';
        con3.innerHTML=var3;
    }
    </script>
  </head>
  <body>
    <div id="wrap">
    <header>
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/login_menu.php";?>
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/side_bar.php";?>
    </header>
    </div>
    <div id="top_text"><b>결제하기</b></div>
    <div id="detail_menu">
      <div id="select_people" >
        <p id="adult">성인</p>&nbsp;
        <p id="kid">아동</p>&nbsp;
        <p id="baby">유아</p>
        <div class="" style="display:inline-block;">
          &nbsp;&nbsp;&nbsp;
        <input disabled type="text" size="4" name="" value="<?=$r_adult?>">&nbsp;&nbsp;
        <input disabled type="text" size="4" name="" value="<?=$r_kid?>">&nbsp;&nbsp;
        <input disabled type="text" size="4" name="" value="<?=$r_baby?>">
        </div>
        <script type="text/javascript">
          var adult_pay=0;
          var kid_pay=0;
          var baby_pay=0;
          var member =1;
          var member2=0;
          var member3=0;
          function select_people_number(person){
            var pay=<?=json_encode($p_pay)?>;
            var money=document.getElementById('money');

            var adult_val=document.getElementById('adult_val');
            var kid_val=document.getElementById('kid_val');
            var baby_val=document.getElementById('baby_val');

            if(person=="adult"){
            var sel1 =document.getElementById('sel1');
            member = parseInt(sel1.options[sel1.selectedIndex].text);
            pay = pay*member;
            adult_pay=pay;
          }else if (person=="kid") {
            var sel2 =document.getElementById('sel2');
            member2 = parseInt(sel2.options[sel2.selectedIndex].text);
            pay = pay*member2*0.7;
            kid_pay=pay;
          }else if (person=="baby") {
            var sel3 =document.getElementById('sel3');
            member3 = parseInt(sel3.options[sel3.selectedIndex].text);
            pay = pay*member3*0.5;
            baby_pay=pay;
          }
            money.innerHTML=(adult_pay+kid_pay+baby_pay).toLocaleString();
            adult_val.value=member;
            kid_val.value=member2;
            baby_val.value=member3;
          }
        </script>
        <div class="" style="align:center;">
        </div>
      </div>
      <div id="pay_view">
        <p id="total_pay">총 예정금액</p>
        <?php
        $p_pay= number_format($p_pay);
         ?>
        <b id="money"><?=$p_pay?></b> <p id="won">원</p>
        <p class="subtext1">유류할증료,제세공과금 포함</p>
        <p class="subtext1">※유류할증료 및 제세공과금은 유가와 환율에</p>
        <p class="subtext1">따라 변동될 수 있습니다.</p>
        <p class="subtext1">※ 아동, 유아요금은 성인 2인과 같은 방 사용조건이며,</p>
        <p class="subtext1">미충족시 아동추가 요금이 발생합니다.</p>
        <p class="subtext1">※ 1인 객실 사용시 추가요금 발생</p>
        <p id="line">------------------------------------------</p>
      </div>
      <div id="button">
        <div id="reserve_status" onclick="people_submit()"> <b id="status">결제하기</b></div><br>
        <form id="people_form" name="people_form" action="../reserve/reserve_view.php?mode=<?=$p_code?>" method="post">
          <input id="adult_val" type="hidden" name="adult_val" value="">
          <input id="kid_val" type="hidden" name="kid_val" value="">
          <input id="baby_val" type="hidden" name="baby_val" value="">
        </form>

        <script type="text/javascript">
          function people_submit(){
          var pay=document.getElementsByName('pay');
          if(pay[0].checked==true){
            var select_bank=document.getElementById('select_bank');
            if(select_bank.value==""){
              alert("은행을 선택해 주세요");
              return false;
            }
            var select_bank=document.getElementById('select_bank');
            var popupX = (window.screen.width / 2) - (800 / 2);
            var popupY= (window.screen.height /2) - (500 / 2);
            window.open('none_bank.php?r_pk=&way=1&r_pk=<?=$r_pk?>&r_pay=<?=$r_pay?>&p_code=<?=$p_code?>&p_name=<?=$p_name?>&bank='+select_bank.value+'&b_seat=<?=$b_seat?>', '', 'status=no, width=900, height=300, left='+ popupX + ', top='+ popupY + ', screenX='+ popupX + ', screenY= '+ popupY);
          }else{
               payment();
          }

          }
        </script>
        <a href="../reserve/reserve_list.php" style="text-decoration:none;"><div id="go_cart" > <b>예약목록 보기</b></div></a>
      </div>
      <div id="right_footer"></div>
    </div>
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
          <td class="left2">예약자명</td>
          <td> <input disabled type="text" id="res_name" value="<?=$m_name?>"> </td>
          <td class="left2">휴대폰번호</td>
          <td> <input disabled type="text" id="res_phone" value="<?=$hp?>"> </td>
        </tr>
        <tr>
          <td class="left2">이메일</td>
          <td> <input disabled type="text" id="res_email1" value="<?=$m_email?>"></td>
          <td></td><td></td>
        </tr>
      </table>
    </div>
    <!-- 상품가격 -->
    <div id="package_detail_pay_imformation">
      <div id="package_detail_imformation_text"><b>상품가격</b></div>
      <table id="package_detail_imformation_table">
        <tr >
          <td id="package_detail_imformation_division"><b>구분</b></td>
          <td id="package_detail_imformation_adult"><b>성인 <br>(만 12세이상)</b></td>
          <td id="package_detail_imformation_child"><b>아동 <br>(만 12세미만)</b></td>
          <td id="package_detail_imformation_baby"><b>유아 <br>(만 2세미만)</b></td>
        </tr>
        <?php
        $p_pay=str_replace(",","",$p_pay);
        $p_pay=$p_pay;
         ?>
        <tr>
          <td id="package_detail_imformation_pay" class="package_detail_imformation_pay_field"><b>기본상품가격</b></td>
          <td class="package_detail_imformation_pay_field_value"> <?=$p_pay?>원</td>
          <td class="package_detail_imformation_pay_field_value"> <?=$p_pay*0.7?>원</td>
          <td class="package_detail_imformation_pay_field_value"><?=$p_pay*0.922*0.5?>원</td>
        </tr>
        <tr>
          <td class="package_detail_imformation_pay_field"><b>유류할증료</b></td>
          <td class="package_detail_imformation_pay_field_value"> <?=$p_pay*0.078?>원</td>
          <td class="package_detail_imformation_pay_field_value"> <?=$p_pay*0.7*0.078?>원</td>
          <td class="package_detail_imformation_pay_field_value"><?=$p_pay*0.5*0.078?>원</td>
        </tr>
        <tr>
          <td class="package_detail_imformation_pay_field"><b>소계</b></td>
          <td class="package_detail_imformation_pay_field_value_final"><?=$p_pay?>원</td>
          <td class="package_detail_imformation_pay_field_value_final"><?=$p_pay*0.7?>원</td>
          <td class="package_detail_imformation_pay_field_value_final"><?=$p_pay*0.5?>원</td>
        </tr>
      </table>
    </div>
    <!-- 최소출발인원 및 취소 수수료 정보 -->
    <div id="package_minimum_person_imformation">
      <div id="package_minimum_person_imformation_text"><b>최소출발인원 및 취소 수수료 정보</b></div>
      <table id="package_minimum_person_imformation_table">
        <tr>
          <td id="person_standard"><b>최소출발인원 기준</b></td>
          <?php
            $p_bus=ceil($p_bus/2);
           ?>
          <td id="person_standard_value"> <b style="color:#35cc2b;font-size:17px;"><?=$p_bus?></b> </td>
          <td id="commission_standard"><b>최소수수료 부과 기준</b></td>
          <td class="commission_standard_value"><b>V </b>표준약관 적용</td>
          <td class="commission_standard_value">특별약관 적용</td>
        </tr>
        <tr>
          <td id="package_minimum_person_imformation_value" colspan="5">※최소 출발인원 미충족시 여행약관 제9조에 따라 여행출발7일전까지 여행사는 여행계약을 일방적으로 해제하고 여행자에게 통보할 수 있습니다.</td>
        </tr>
      </table>
    </div>
    <div id="package_detail_imformations">
      <div id="package_detail_imformations_text"><b>기타 정보</b></div>
      <div id="package_detail_imformations_btn_field">
      <button class="package_detail_imformations_btn" style="border:none; width: 8%; height: 8%; background-color:#35cc2b; color:white;" id="insurance_btn" type="button" name="button" onclick="insurance_field_click()">보험 정보</button>
      <button class="package_detail_imformations_btn" style="border:none; width: 8%; height: 8%; background-color:#2F9D27; color:white;" id="payment_imformation_btn" type="button" name="button" onclick="payment_imformation_field_click()">결제 안내</button>
      </div>
      <!-- 보험정보 -->
      <div id="insurance_field" style="display :block">
        <br>
        보험정보
        <table id="insurance_table">
          <tr>
            <td rowspan="2" colspan="2" id="insurance_division"><b>구분</b></td>
            <td rowspan="2" id="insurance_content"><b>보장내용</b></td>
            <td colspan="2" id="insurance_limit"><b>보상한도</b></td>
          </tr >
          <tr>
            <td id="insurance_domestic"><b>국내</b></td>
            <td id="insurance_abroad"><b>해외</b></td>
          </tr>
          <tr>
            <td rowspan="2" id="insurance_injury"><b>상해</b></td>
            <td id="insurance_death"><b>사망/후유장애</b></td>
            <td class="insurance_value">해외여행 중 우연한 사고로 1년이내에 사망하거나 신체상에 후유장해를 입었을 경우 보험가입금액 전액 또는 후유장해 정도에 따라 보험가입금액의 3~100%를 보상</td>
            <td class="insurance_value">1억원 <br> (15세미만, 심신상실자, 심신박약자 해당없음</td>
            <td class="insurance_value">2<br>억원</td>
          </tr>
          <tr>
            <td id="insurance_medical_expenses" ><b>의료비</b></td>
            <td class="insurance_value">해외여행 중 우연한 사고로 상해를 입어 의사의 치료를 받는 경우, 1사고당 보험가입금액 한도 내에서 진찰비, 수술비, 약제비, 입원비 등 최고 180일까지의 실제로 부담한 의료비를 지급 (단, 입원비 10%, 통원의료비 1~2만원, 약제비 8천원 공제 후 지급)
                ※ 비급여 도수치료/체외충격파치료/증식치료 – 1회당 2만원과 의료비의 30%중 큰 금액을 공제(1년 350만원/50회 한도)
                ※ 비급여주사료 – 1회당 2만원과 의료비 30%중 큰 금액 (1년 250만원/50회 한도)
                ※ 비급여자기공명진단(MRI/MRA) – 1회당 2만원과 의료비 30% 중 큰 금액(300만원 한도)
                ※ 상세 공제내역은 반드시 약관 참고 부탁드립니다.</td>
            <td class="insurance_value">300만원</td>
            <td class="insurance_value">300만원</td>
          </tr>
          <tr>
            <td rowspan="2" id="insurance_injury"><b>질병</b></td>
            <td id="insurance_death"><b>사망/후유장애</b></td>
            <td class="insurance_value">해외여행 중 발생한 질병으로 사망하였거나 그 질병으로 인해 보험기간 만료후 30일 이내에 사망한 경우 보험가입금액 전액을 보상</td>
            <td class="insurance_value">1,000만원 <br>(15세미만, 79세 6개월이상, 심신상실자, 심신박약자 해당없음)</td>
            <td class="insurance_value">1,000만원</td>
          </tr>
          <tr>
            <td id="insurance_medical_expenses" ><b>의료비</b></td>
            <td class="insurance_value">해외여행 중 우연한 사고로 상해를 입어 의사의 치료를 받는 경우, 1사고당 보험가입금액 한도 내에서 진찰비, 수술비, 약제비, 입원비 등 최고 180일까지의 실제로 부담한 의료비를 지급 (단, 입원비 10%, 통원의료비 1~2만원, 약제비 8천원 공제 후 지급)
              ※ 비급여 도수치료/체외충격파치료/증식치료 – 1회당 2만원과 의료비의 30%중 큰 금액을 공제(1년 350만원/50회 한도)
              ※ 비급여주사료 – 1회당 2만원과 의료비 30%중 큰 금액 (1년 250만원/50회 한도)
              ※ 비급여자기공명진단(MRI/MRA) – 1회당 2만원과 의료비 30% 중 큰 금액(300만원 한도)
              ※ 상세 공제내역은 반드시 약관 참고 부탁드립니다.</td>
            <td class="insurance_value">100만원</td>
            <td class="insurance_value">100만원</td>
          </tr>
          <tr>
            <td colspan="2" class="insurance_damage"><b>배상책임 손해</b></td>
            <td class="insurance_value">해외여행 중 우연한 사고로 타인에게 신체장해 (상해, 질병,후유장해)를 입히거나, 타인의 재물을 멸실, 훼손시킴으로써 법률배상책임을 부담하게 될 경우 보상한도액에서 실제 소요된손해배상액을 보상 (단, 자기부담금 1만원 공제)</td>
            <td class="insurance_value">100만원</td>
            <td class="insurance_value">100만원</td>
          </tr>
          <tr>
            <td colspan="2" class="insurance_damage"><b>휴대품 손해</b></td>
            <td class="insurance_value">해외여행 중 우연한 사고 (도난, 파손, 화재 등)로 휴대품에 손해가 생길 경우 1조(또는 1쌍, 1개)에 대하여 20만원을 한도로 보험가입금액내에서 실제손해액을 보상 (단, 자기부담금 1만원공제)</td>
            <td class="insurance_value">50만원</td>
            <td class="insurance_value">50만원</td>
          </tr>
          <tr>
            <td colspan="2" class="insurance_damage"><b>특별비용 손해</b></td>
            <td class="insurance_value">여행도중 탑승한 항공기나 선박이 조난 (또는 행방불명) 당하거나상해나 질병으로 인하여 사망 또는 14일이상 계속 입원한 경우보험계약자, 피보험자 또는 피보험자의 법정상속인이 부담하는수색구조, 구원자의 항공운임 등 왕복교통비, 숙박비(2명X14일한도),사망유체이송비, 기타제잡비</td>
            <td class="insurance_value">200만원</td>
            <td class="insurance_value">200만원</td>
          </tr>

        </table>
      </div>

      <div id="payment_imformation_field" style="display :none">
        <br>
        결제 안내
        <table id="payment_imformation_table">
          <tr>
            <td><b>● 계약금 규정</b><br><br><br>
              위 계약금은 호텔, 항공, 현지 사정 등에 의하여 변경될 수 있으며, 상황에 따라 고객님의 결제시한은 당겨질 수 있습니다.
              단, 아래 명시되어 있는 취소료 규정 적용기간에 예약하신 고객님께서는 계약금보다 취소 수수료가 높을 시 취소 수수료 금액을 계약금으로 납부하셔야 합니다.
            </td>
          </tr>

          <tr>
            <td><b>● 취소료 규정</b><br><br><br>
              여행 취소시 아래의 비율로 취소료가 부과됩니다. (단, 당사의 귀책사유로 여행출발 취소 경우에도 동일한 규정이 적용됩니다.) <br>
               - 여행개시 30일전(~30)까지 통보시: 계약금환급 <br>
               - 여행개시 20일전(29~20)까지 통보시: 총상품가격의 10% 배상 <br>
               - 여행개시 10일전(19~10)까지 통보시: 총상품가격의 15% 배상 <br>
               - 여행개시 8일전(9~8)까지 통보시: 총상품가격의 20% 배상 <br>
               - 여행개시 1일전(7~1)까지 통보시: 총상품가격의 30% 배상 <br>
               - 여행 당일 통보시: 총상품가격의 50% 배상 <br><br><br>

               <p id="payment_imformation_final">※ 여행출발일 이전 상해,질병,입원,사망등으로 여행을 취소하는 경우 [진단서] 증빙 근거하여 환불이 가능하며 출발일 기준 7일이내 증빙서류를 제출해주시기 바랍니다.(상세규정은 약관참조)</p>
            </td>

          </tr>

        </table>
      </div>
    </div>

    <div id="payment_choice">
      <div id="payment_choice_text"><b>결제수단 선택</b></div>
      <table id="payment_choice_table">
        <tr>
          <td id="payment_choice_way"><b>결제수단</b></td>
          <td id="payment_choice_direct">
            <input id="payment_choice_direct_radiobtn" type="radio" name="pay" value="1" onclick="payment_choice_direct_radiobtn_click()" checked="checked">
            <b>무통장입금</b>
          </td>
          <td id="payment_choice_kakaopay">
            <input id="kakopay_radiobtn" type="radio" name="pay" value="2" onclick="kakopay_radiobtn_click()">
          </td>
          <td id="payment_choice_kakaopay_img">
            <img class="kakopay_img" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/common/img/kakaopay.jpg">
          </td>
        </tr>


        <tr>
          <td id="payment_choice_direct_detail_1">입금은행 선택</td>
          <td colspan='3' id="payment_choice_direct_detail_2">
            <select id="select_bank">
              <option value="">선택해주세요</option>
              <option value="국민은행">국민은행</option>
              <option value="하나은행">하나은행</option>
              <option value="신한은행">신한은행</option>
              <option value="기업은행">기업은행</option>
            </select>
          </td>
        </tr>

        <tr>
          <td id="payment_choice_direct_detail_3" colspan='4'>
            <p>· 무통장입금은 지정된 고유계좌번호로 구매대금을 입금하는 방식으로 입금은행을 선택하시면 선택은행의 가상계좌번호가 발급됩니다.</p>
            <p>· 발급된 가상계좌에 최종결제금액을 입금하셔야 결제가 완료되며 입금금액이 정확할 경우 예약자/입금자명이 달라도 정상입금 처리됩니다.</p>
            <p>· 해외은행계좌에서 입금시에는 반드시 원화로 입금하셔야 됩니다.</p>
            <p>· 해외호텔의 경우 무통장입금 신청일의 환율기준으로 최종결제금액이 확정되며 이후 변동 불가합니다.</p>
            <p id="final_mention">· 고객님! 예금주가 산뜻인지 확인해주세요. 고객 직접 입금을 권장합니다</p>
          </td>
        </tr>
        </div>
      </table>
    </div>
  </body>
  <br><br><br><br><br>
  <footer>
    <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/footer.php";?>
  </footer>
</html>
