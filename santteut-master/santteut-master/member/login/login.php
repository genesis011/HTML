<!DOCTYPE html>
<?php
if($_GET['mode']=="update"){
  echo '<script>alert("완료. 다시 로그인해주세요.");</script>';
}
if(!session_id()) {
    session_start();
}

if(isset($_COOKIE["cookie_id"])){
  $cookie_id=$_COOKIE["cookie_id"];
  $cookie_check="checked";
}else{
  $cookie_id="";
  $cookie_check="";
}


 ?>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/common/css/login_menu.css">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/introduction/css/history.css">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/member/login/css/login.css?ver=1.1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script>
      function checkLoginStatus() {
        var loginBtn = document.querySelector('#loginBtn');
        if (gauth.isSignedIn.get()) {
          console.log('logined');
          loginBtn.value = 'Logout';
          var profile = gauth.currentUser.get().getBasicProfile();
          document.member_form.join_id.value = profile.getId();
          document.member_form.join_name.value = profile.getName();
          document.member_form.email.value = profile.getEmail();
          document.member_form.submit();
          gauth.disconnect();
        } else{
          console.log('logouted');
          loginBtn.value = 'Login';
        }
      }
      function init() {
        console.log('init');
        gapi.load('auth2', function() {
              console.log('auth2');
                window.gauth = gapi.auth2.init({
                  client_id: '301409044099-3qn245369bseosmhocbttg3sdof9rbe9.apps.googleusercontent.com'
                })
                gauth.then(function() {
                  console.log('googleAuth success');
                  checkLoginStatus();
                }, function() {
                  console.log('googleAuth fail');
                });
              });
            }

          function save_id(){
            var login_id =document.getElementById('login_id');
            var save_id =document.getElementById('save_id');



            if(save_id.checked==true){
              $.ajax({
                url: 'login_cookie.php',
                type: 'POST',
                data: {
                  cookie_id:login_id.value
                }
              })
              .done(function(result){
              })
              .fail(function() {
                console.log("error");
              })
              .always(function() {
                console.log("complete");

              });


            }else{

              $.ajax({
                url: 'login_cookie.php',
                type: 'POST',
                data: {
                  cookie_id:"none"
                }
              })
              .done(function(result) {
              })
              .fail(function() {
                console.log("error");
              })
              .always(function() {
                console.log("complete");

              });


            }

          }


    </script>
    <script type="text/javascript" src="https://static.nid.naver.com/js/naverLogin_implicit-1.0.3.js" charset="utf-8"></script>
    <script type="text/javascript">
      window.addEventListener('load', function() {
        var naver_id_login = new naver_id_login("SrlAW6CBDScYywp943rw", "http://localhost/santteut/member/login/naver_callback.html");
        var state = naver_id_login.getUniqState();
        naver_id_login.setButton("green", 3,38);
        naver_id_login.setDomain("http://localhost/santteut/index.php");
        naver_id_login.setState(state);
        naver_id_login.setPopup();
        naver_id_login.init_naver_id_login();
      });

      function login_action(){
        if(login_form.login_id.value == ''){
          alert('ID를 입력하세요.');
          login_form.login_id.focus();
          return false;
        }
        if(login_form.login_passwd.value == ''){
          alert('패스워드를 입력하세요.');
          login_form.login_passwd.focus();
          return false;
        }
        save_id();
        document.login_form.submit();
      }
    </script>
    <title>로그인</title>
  </head>
  <body >
    <!--로그인 회원가입 로그아웃-->
    <header>
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/login_menu.php";?>
    </header>
    <section id="login">
    <hr>
    <h2>로그인</h2>
    <hr>

    <div class="login_div">
      <h3>로그인</h3>

      <table>
       <form name="login_form" action="login_query.php" method="post">
         <!-- <input type="hidden" name="mode" value="login"> -->

        <tr>
          <th><label>아이디</label></th>
          <td><input id="login_id" type="text" name="login_id" value="<?=$cookie_id?>"></td>
          <th rowspan="2"><button type="button" name="button" id="login_button" onclick="login_action()">로그인</button> </th>
        </tr>
        <tr>
          <th><label>비밀번호</label></th>
          <td><input type="password" name="login_passwd"></td>
        </tr>
      </form>
        <tr>
          <td id="empty_row" colspan="3"><br></td>
        </tr>
        <tr><td id="id_storage" colspan="3"><input <?=$cookie_check?> id="save_id" type="checkbox" name="id_storage" onclick="save_id();">아이디저장&nbsp;&nbsp;<a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/member/join/join_member.php"><b>회원가입</b></a></td></tr>
        <tr>
          <td id="empty_row" colspan="3"><br></td>
        </tr>
        <tr><td colspan="3">&nbsp;&nbsp;<a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/member/login/forgot_id_pw.php?find=id">아이디 찾기/비밀번호 찾기</a></td></tr>
        <tr>
          <td id="empty_row" colspan="3"><br></td>
        </tr>
        <tr>
          <td colspan="3">
            <!-- 네이버계정로그인 -->
            <div id="naver_id_login" style="display:inline;">
            </div>
            <script type="text/javascript">
              var naver_id_login = new naver_id_login("SrlAW6CBDScYywp943rw", "http://localhost/santteut/member/login/naver_callback.html");
              var state = naver_id_login.getUniqState();
              naver_id_login.setButton("green", 3,38);
              naver_id_login.setDomain("http://localhost/santteut/index.php");
              naver_id_login.setState(state);
              naver_id_login.setPopup();
              naver_id_login.init_naver_id_login();
            </script>
            <!-- 페이스북계정 로그인 -->
            <?php include_once './facebook.php'; ?>
            <?php 	echo '<a href="' . $loginUrl . '">'; ?><img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/member/login/img/facebook.jpg" alt="페이스북계정로그인"></a><br>
            <!-- 카카오계정로그인 -->
            <a href="kakao.php"><img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/member/login/img/kakao.jpg" alt="카카오계정로그인"></a>
            <!-- 구글계정로그인 -->
            <input type="image" style="height:41px;" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/member/login/img/google.jpg" id="loginBtn" value="login" onclick="
              if(this.value === 'Login'){
                gauth.signIn().then(function(){
                  console.log('gauth.signIn()');
                  checkLoginStatus();
                });
              }else{
                gauth.disconnect().then(function(){
                  console.log('gauth.signOut()');
                  checkLoginStatus();
                });
                gauth.signOut().then(function(){
                  console.log('gauth.signOut()');
                  checkLoginStatus();
                });
              }
            ">
            <form name="member_form" action="../join/join_query.php" method="post">
              <input type="hidden" name="mode" value="google">
              <input type="hidden" name="join_id" id="id" value="">
              <input type="hidden" name="join_name" id="name"  value="">
              <input type="hidden" name="email" id="email"  value="">
            </form>
            <script src="https://apis.google.com/js/platform.js?onload=init" async defer></script>
          </td>
        </tr>
      </table>
    </div>
    </section>
  <br>
    <footer>
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/footer.php";?>
    </footer>
  </body>
</html>
