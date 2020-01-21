<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/db_connector.php";
if($_GET['id']){
 $id = $_GET['id'];
 $sql="SELECT * from `member` where `id`= '$id';";
 $result = mysqli_query($conn,$sql) or die("실패원인1: ".mysqli_error($conn));
 $row = mysqli_fetch_array($result);
 $name1 = $row['name'];
 $zip = $row['zip'];
 $address1 = $row['address1'];
 $address2 = $row['address2'];
 $h1 = $row['hp1'];
 $h2 = $row['hp2'];
 $email = $row['email'];
 $email_value=explode('@', $email);
 $selected=$selected1=$selected6=$selected7=$selected8=$selected9="";
 if($h1=="010"){
   $selected='selected';
 }elseif ($h1=="011") {
   $selected1='selected';
 }elseif ($h1=="016") {
   $selected6='selected';
 }elseif ($h1=="017") {
   $selected7='selected';
 }elseif ($h1=="018") {
   $selected8='selected';
 }elseif ($h1=="019") {
   $selected9='selected';
 }
}else{
  echo "오류";
}
 ?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>정보수정</title>
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/common/css/login_menu.css">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/introduction/css/history.css">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/member/join/css/join_member.css">
    <script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
    <script type="text/javascript">
    window.onload = function () {
    var r_email1=document.getElementById('r_email1');
    var r_email2=document.getElementById('r_email2');
    var r_phon=document.getElementById('r_phon');
    var e_mail_id=document.getElementById('e_mail_id');
    var e_mail_adress_2=document.getElementById('e_mail_adress_2');
    var join_phone_write=document.getElementById('join_phone_write');
    r_email1.value=<?=json_encode($email_value[0])?>;
    r_email2.value=<?=json_encode($email_value[1])?>;
    r_phon.value=<?=json_encode($h1)?>;
    join_phone_write.value=<?=json_encode($h2)?>;
    join_select_2.selected;
    e_mail_id.value=r_email1.value;
    e_mail_adress_2.value=r_email2.value;
    }
    </script>
    <!-- 약관모두체크 -->
    <script type="text/javascript">
      var check_val=false;
      var final_phone_check=false;
      var final_email_check=false;
      var id_check=false;
      function all_choice_value(){
        var check_1= document.getElementById('check_1');
        var check_2= document.getElementById('check_2');
        var check_3= document.getElementById('check_3');
        if(check_val==false){
          check_1.checked=true;
          check_2.checked=true;
          check_3.checked=true;
          check_val=true;
        }else{
          check_1.checked=false;
          check_2.checked=false;
          check_3.checked=false;
          check_val=false;
        }
      }
    </script>

    <!-- 아이디/비밀번호중복확인 -->
    <script type="text/javascript">
    $(document).ready(function(){
      //아이디 자동확인
     $("#join_id").keyup(function(e){
       var possibility = document.getElementById("possibility");
       var join_id = document.getElementById("join_id");
       var idPattern = /^[a-zA-Z0-9]{3,15}$/;
       if(!idPattern.test(join_id.value)){
         if(possibility=='아이디가 이미 존재합니다.'){
           $("#possibility").text('아이디가 이미 존재합니다.');
           $("#possibility").css('color', 'red');
           id_check=false;
           return false;
         }{
           $("#possibility").text("영문,숫자만 입력/3~15글자");
           $("#possibility").css('color', 'red');
           id_check=false;
           return false;
         }
       }
       $.ajax({
         url: 'check_id.php',
         type: 'POST',
         data: {join_id: $("#join_id").val()}
       })
       .done(function(result) {
         // alert(result);
         if(result=='아이디가 이미 존재합니다.'){
          $("#possibility").text(result);
          $("#possibility").css('color', 'red');
          id_check=false;
        }else{
          $("#possibility").text(result);
          $("#possibility").css('color', 'blue');
          id_check=true;
          console.log("ok");
        }

       })
       .fail(function() {
         console.log("error");
       })
       .always(function() {
         console.log("complete");
       });
     });

     //비밀번호 자동확인
     $("#join_passwd").keyup(function(e){
       var possibility_pw1 = document.getElementById("possibility_pw1");
       var join_passwd = document.getElementById("join_passwd");
       var join_passwd_Patt = /^.*(?=^.{8,15}$)(?=.*\d)(?=.*[a-zA-Z])(?=.*[!@#$%^&+=]).*$/;
       if(!join_passwd_Patt.test(join_passwd.value)){
           $("#possibility_pw1").text('특수문자/문자/숫자 모두포함(8~15)');
           $("#possibility_pw1").css('color', 'red');
           return false;
         }else{
           $("#possibility_pw1").text("사용가능합니다.");
           $("#possibility_pw1").css('color', 'blue');
           return false;
         }
       });

       //비밀번호확인 자동확인
       $("#join_passwdconfirm").keyup(function(e){
         var possibility_pw2 = document.getElementById("possibility_pw2");
         var join_passwd = document.getElementById("join_passwd");
         var join_passwdconfirm = document.getElementById("join_passwdconfirm");
         var join_passwd_Patt = /^.*(?=^.{8,15}$)(?=.*\d)(?=.*[a-zA-Z])(?=.*[!@#$%^&+=]).*$/;
         if(!join_passwd_Patt.test(join_passwdconfirm.value)){
             $("#possibility_pw2").text('특수문자/문자/숫자 모두포함(8~15)');
             $("#possibility_pw2").css('color', 'red');
             return false;
           }else{
              if(join_passwd.value!=join_passwdconfirm.value){
                $("#possibility_pw2").text("비밀번호가 일치하지 않습니다.");
                $("#possibility_pw2").css('color', 'red');
              }else{
                $("#possibility_pw2").text("사용가능합니다.");
                $("#possibility_pw2").css('color', 'blue');
              }
             return false;
           }
         });

     });
    </script>

    <!-- 이메일인증 -->
    <script type="text/javascript">
    var code="";
    $(document).ready(function(){
          $("#email_btn").click(function(e){
            var e_mail_id = document.getElementById("e_mail_id");
            var e_mail_adress_1 = document.getElementById("e_mail_adress_1");
            var e_mail_adress_2 = document.getElementById("e_mail_adress_2");
            var check_email1 = document.getElementsByName("check_email1")[0];
            var check_email2 = document.getElementsByName("check_email2")[0];
            var hidden_email = document.getElementsByName("hidden_email")[0];
            var e_mailPatt = /^[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*.[a-zA-Z]{2,3}$/i;
            var e_mail_id_value=e_mail_id.value.concat('@'+e_mail_adress_2.value);
            hidden_email.value = e_mail_id.value.concat('@'+e_mail_adress_2.value);
            var hidden_email_value = hidden_email.value;
            console.log(hidden_email.value);
            if(!e_mail_id.value){
              alert("이메일 아이디를 입력해주세요");
              e_mail_id.focus();
              e_mail_id.value="";
              return false;
            }else if(!e_mailPatt.test(e_mail_id_value)){
              alert("이메일 형식을 확인해주세요");
              e_mail_adress_1.focus();
              return false;
            }


            // alert(email1.value);
            $.ajax({
              url: 'check_email.php',
              type: 'POST',
              data: {email: hidden_email_value}
            })
            .done(function(result) {
              code=result;
              alert(code);
              check_email1.setAttribute('type', 'text');
              check_email2.setAttribute('type', 'button');
              alert('이메일로 코드가 발송 되었습니다.');

            })
            .fail(function() {
              alert("인증 번호 발송실패!");
              console.log("error");
            })
            .always(function() {
              console.log("complete");
           });
         });

         $("#check_email2").click(function(e){
           var email1 = document.getElementById("check_email1");
           if(email1.value==code){
             alert("인증 완료");
             final_email_check=true;
             $("#email_final_alert").text("인증완료");
             $("#email_final_alert").css('color', 'blue');
           }else{
             alert("인증 실패");
             final_email_check=false;
             $("#email_final_alert").text("인증실패");
             $("#email_final_alert").css('color', 'red');
           }
           });
        });
    </script>

  <!-- 휴대폰 인증 -->
    <script type="text/javascript">
    var h_code="";
    $(document).ready(function(){
          $("#hp_btn").click(function(e){
            var join_phone_write = document.getElementById("join_phone_write");
            var join_select = document.getElementById("join_select");
            var hidden_phone = document.getElementsByName("hidden_phone")[0];
            var cellphone_authentication_form = document.getElementById("cellphone_authentication_form");
            var join_phone_write_Patt =/^[0-9]*$/;
            var phone_val=join_select.options[join_select.selectedIndex].text+join_phone_write.value;
            hidden_phone.value=join_select.options[join_select.selectedIndex].text+join_phone_write.value;
            if (!join_phone_write_Patt.test(join_phone_write.value)) {
              alert("전화번호를 확인해주세요");
              join_phone_write.focus();
              join_phone_write.value="";
              return false;
            }else if (!join_phone_write.value) {
              alert("전화번호를 확인해주세요");
              join_phone_write.focus();
              join_phone_write.value="";
              return false;
            }else if (join_phone_write.value.length<8) {
              alert("전화번호를 확인해주세요");
              join_phone_write.value="";
              join_phone_write.focus();
              return false;
            }

            $.ajax({
              url: 'send_message.php',
              type: 'POST',
              data: {phone: phone_val}
            })
            .done(function(result) {
              h_code=result;
              alert(h_code);
              alert("문자인증 번호가 발송되었습니다.");
              $("#hp_btn_done").css('display', 'inline');
              $("#cellphone_authentication").css('display', 'inline');
            })
            .fail(function() {
              alert("문자인증 번호 발송실패!");
              console.log("error");
            })
            .always(function() {
              console.log("complete");
           });
         });
         $("#hp_btn_done").click(function(e){
           var cellphone_authentication = document.getElementById("cellphone_authentication");
           alert(h_code);
           if(cellphone_authentication.value==h_code){
             alert("인증 완료");
             final_phone_check=true;
             $("#final_phone_check").text("인증완료");
             $("#final_phone_check").css('color', 'blue');
           }else{
             alert("인증 실패");
             final_phone_check=false;
             $("#final_phone_check").text("인증실패");
             $("#final_phone_check").css('color', 'red');
           }
           });
        });
    </script>

    <!-- 다음 주소찾기 -->
    <script>
      function execDaumPostcode() {/* 폼은 다음 주소찾기 빌리면서 입력값은 여기서 받고 처리하네?  */
            new daum.Postcode({
                oncomplete: function(data) {
                    // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

                    // 각 주소의 노출 규칙에 따라 주소를 조합한다.
                    // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                    var fullAddr = ''; // 최종 주소 변수
                    var extraAddr = ''; // 조합형 주소 변수

                    // 사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
                    if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                        fullAddr = data.roadAddress;

                    } else { // 사용자가 지번 주소를 선택했을 경우(J)
                        fullAddr = data.jibunAddress;
                    }

                    // 사용자가 선택한 주소가 도로명 타입일때 조합한다.
                    if(data.userSelectedType === 'R'){
                        //법정동명이 있을 경우 추가한다.
                        if(data.bname !== ''){
                            extraAddr += data.bname;
                        }
                        // 건물명이 있을 경우 추가한다.
                        if(data.buildingName !== ''){
                            extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                        }
                        // 조합형주소의 유무에 따라 양쪽에 괄호를 추가하여 최종 주소를 만든다.
                        fullAddr += (extraAddr !== '' ? ' ('+ extraAddr +')' : '');
                    }

                    // // 우편번호와 주소 정보를 해당 필드에 넣는다.
                    document.getElementById('join_zip').value = data.zonecode; //5자리 새우편번호 사용
                    document.getElementById('join_foundational').value = fullAddr; //실제 주소

                    // 커서를 상세주소 필드로 이동한다.
                    document.getElementById('join_detail').focus();
                }
            }).open();
        }
    </script>

    <!-- 이메일함수 선택 -->
    <script type="text/javascript">
    function choice_email(){
      var e_mail_adress_1 = document.getElementById("e_mail_adress_1");
      var e_mail_adress_2 = document.getElementById("e_mail_adress_2");
      // e_mail_adress_1.options[e_mail_adress_1.selectedIndex].text
      if(e_mail_adress_1.options[e_mail_adress_1.selectedIndex].text!="직접입력"){
        e_mail_adress_2.value=e_mail_adress_1.options[e_mail_adress_1.selectedIndex].text;
        e_mail_adress_2.readOnly=true;
      }else{
        e_mail_adress_2.value=null;
        e_mail_adress_2.placeholder="";
        e_mail_adress_2.readOnly=false;
      }
    }
    </script>

    <!-- 패턴검사 -->
    <script type="text/javascript">
      function goto_join(){
         var join_passwd = document.getElementById("join_passwd");
         var join_passwdconfirm = document.getElementById("join_passwdconfirm");
         var join_name = document.getElementById("join_name");
         var join_zip = document.getElementById("join_zip");
         var join_foundational = document.getElementById("join_foundational");
         var join_detail = document.getElementById("join_detail");

         var join_id_Patt = /^[a-zA-Z0-9]{3,15}$/;
         var join_passwd_Patt = /^.*(?=^.{8,15}$)(?=.*\d)(?=.*[a-zA-Z])(?=.*[!@#$%^&+=]).*$/;
         var join_name_Patt = /^[가-힣]{2,5}$/;
         var e_mailPatt = /^[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*.[a-zA-Z]{2,3}$/i;
         var join_phone_write_Patt =/^[0-9]*$/;

         if(!join_passwd_Patt.test(join_passwd.value)){
           alert("특수문자/문자/숫자 모두포함(8~15)");
           join_passwd.focus();
           join_passwd.value="";
           return false;
         }else if(join_passwd.value!=join_passwdconfirm.value){
           alert("비밀번호가 같지 않습니다.");
           join_passwdconfirm.focus();
           join_passwdconfirm.value="";
           return false;
         }else if(!join_name_Patt.test(join_name.value)){
           alert("이름을 확인해주세요");
           join_name.focus();
           join_name.value="";
           return false;
         }else if(!join_zip.value){
           alert("주소를 입력해주세요");
           join_zip.focus();
           join_zip.value="";
           return false;
         }else if(!join_detail.value){
           alert("상세주소를 입력해주세요");
           join_detail.focus();
           join_detail.value="";
           return false;
         }
         document.join_member_form.submit();
      }
    </script>

  </head>
  <body>
    <input id="r_email1" type="hidden" name="" value="">
    <input id="r_email2" type="hidden" name="" value="">
    <input id="r_phon" type="hidden" name="" value="">
    <!--로그인 회원가입 로그아웃-->
    <header>
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/login_menu.php";?>
    </header>
    <hr>
    <h2 id="join_title">정보수정</h2>
    <hr>
    <section>
      <form name="join_member_form" action="join_query.php?mode=update&id=<?=$id?>" method="post">
        <input type="hidden" name="mode" value="id_check">
        <div class="join_form">
          <h3>정보수정</h3>
          <table  id="table1">
            <!--필수입력사항-->
            <tr>
              <td id="join_tr1" colspan="4"><span>*</span> 필수입력사항</td>
            </tr>
            <!--아이디-->
            <tr>
              <th><label>아이디</label>&nbsp;<span>*</span></th>
              <!-- <?php
              $id = $_GET['id'];
               ?> -->
              <td  colspan="3"><input id="join_id" type="text" name="join_id" placeholder="대/소문자/숫자 3글자 이상 15글자이하" disabled size="40"  value="<?=$id?>"><p id="possibility" style="display:inline; font-size:13px;"></p></td>
            </tr>
            <!--비밀번호-->
            <tr>
              <th><label>비밀번호</label>&nbsp;<span>*</span></th>
              <td  colspan="3"><input id="join_passwd" type="password" name="join_passwd" placeholder="특수문자/문자/숫자 모두포함(8~15)" size="40"><p id="possibility_pw1" style="display:inline; font-size:13px;"></td>
            </tr>
            <!--비밀번호확인-->
            <tr>
              <th>&nbsp;<label>비밀번호확인</label>&nbsp;<span>*</span></th>
              <td colspan="3"><input id="join_passwdconfirm" type="password" name="join_passwdconfirm" placeholder="특수문자/문자/숫자 모두포함(8~15)" size="40"><p id="possibility_pw2" style="display:inline; font-size:13px;"></p>
            </tr>
            <!--이름-->
            <tr>
              <th><label>이름</label>&nbsp;<span>*</span></th>
              <td colspan="3"><input value="<?=$name1?>" placeholder="2~5글자" id="join_name" type="text" name="join_name" size="40"></td>
            </tr>
            <!--주소_우편번호-->
            <tr>
              <th rowspan="3"><label>주소</label>&nbsp;<span>*</span></th>
              <td colspan="3" id="td_this"><input value="<?=$zip?>" readonly id="join_zip" type="text" name="join_zip" size="10">
                <button type="button" name="button" id="zip_btn" onclick="execDaumPostcode()" >우편번호</button>
              </td>
            </tr>
            <!--주소_기본-->
            <tr>
              <td colspan="3"><input readonly id="join_foundational" type="text" name="join_foundational" value="<?=$address1?>" placeholder="기본주소" size="40"></td>
            </tr>
            <!--주소_상세-->
            <tr>
              <td colspan="3"><input id="join_detail" type="text" name="join_detail" value="<?=$address2?>" placeholder="상세주소" size="40"></td>
            </tr>
            <tr>
              <th><label>이메일</label></th>
              <td id="e_mail_box">
                <input disabled id="e_mail_id" type="text" name="e_mail_id" size="17"> @
                <select disabled onclick="choice_email()" id="e_mail_adress_1" class="" name="e_mail_adress_1" style=" padding: 9px; font-size:13px;">
                  <option value="naver.com" >naver.com</option>
                  <option value="gmail.com" >gmail.com</option>
                  <option value="daum.net" >daum.net</option>
                  <option value="nate.com" >nate.com</option>
                  <option value="yahoo.com" >yahoo.com</option>
                  <option value="직접입력" selected>직접입력</option>
                </select>
                <input disabled id="e_mail_adress_2" value="naver.com"  placeholder="naver.com" type="text" name="e_mail_adress_2" size="13" style="text-align: center;">
                <!-- <button id="email_btn" type="button" name="email_btn">인증하기</button> -->
                <input type="hidden" name="hidden_email" >
                <input type="hidden" name="check_email1" size="8" placeholder="인증번호" id="check_email1">
                <!-- <input type="hidden" name="check_email2" value="확인" style="background-color: #FFFFFF" id="check_email2"></button> -->
                <p id="email_final_alert" style="display:inline;"></p>
              </td>
            </tr>
            <!--일반전화-->
            <tr>
              <th><label>일반전화</label></th>
              <td colspan="3" id="join_tr7">
                <input id="join_landline1" type="tel" name="join_landline1" size="8">-<input id="join_landline2" type="tel" name="join_landline2" size="10">-<input id="join_landline3" type="tel" name="join_landline3" size="10">
              </td>
            </tr>

            <!--휴대전화-->
            <tr>
              <th id="last_td1">&nbsp;&nbsp;&nbsp;<label>휴대전화</label>&nbsp;<span>*</span></th>
              <td id="last_td2"  colspan="3">
                <select  disabled id="join_select" name="join_select">
                  <option value="선택">선택</option>
                  <option <?=$selected?> id="join_select_1" value="010">010</option>
                  <option <?=$selected1?> id="join_select_2" value="011">011</option>
                  <option <?=$selected6?> id="join_select_3" value="016">016</option>
                  <option <?=$selected7?> id="join_select_4" value="017">017</option>
                  <option <?=$selected8?> id="join_select_5" value="018">018</option>
                  <option <?=$selected9?> id="join_select_6" value="019">019</option>
                </select>
              <input disabled id="join_phone_write" type="tel" name="join_cellphone" size="19" maxlength="8">
              <input disabled type="hidden" name="hidden_phone">
            </tr>
          </table>
          <!--인증번호입력-->
          <br>
          <br>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <button id="end_btn" type="button" name="button" onclick="confirm_del()">삭제</button>
          <script type="text/javascript">
            function confirm_del(){
              var result=confirm("삭제하시겠습니까?");
              if(result){
                window.location.href="delete_imformation.php?id=<?=$id?>";
              }
            }
          </script>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <button id="end_btn" type="button" name="button" onclick="goto_join()">수정</button>
          &nbsp;&nbsp;
          <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/member/admin/member_admin_list.php"> <button id="end_btn2" type="button" name="button">취소</button></a>
        </div><!--end of join_form div-->
      </form>
      <br><br><br><br><br>
    </section>
    <footer>
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/footer.php";?>
    </footer>
  </body>
</html>
