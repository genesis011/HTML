<?php
include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/db_connector.php";
  if(isset($_POST['id2'])){$id= $_POST['id2'];}else{$id='';}
  if(isset($_POST['email1'])){$email1= $_POST['email1'];}else{$email1='';}
  if(isset($_POST['email2'])){$email2= $_POST['email2'];}else{$email2='';}
  $email = $email1."@".$email2;
  if(!empty($email1)&&!empty($email2)&&empty($id)){
    $sql = "select * from member where email='$email'";
    $result = mysqli_query($conn,$sql) or die("실패원인 : ".mysqli_error($con));
    if(mysqli_num_rows($result)==0){
      echo "<script>
          alert('회원님의 정보가 존재하지 않습니다.');
        </script>";
    }else{
      $row = mysqli_fetch_array($result);
      // $id = "아이디는".$row['id']."입니다.";
      echo "<script>
          alert('아이디는 ".$row['id']."입니다.');
        </script>";
    }
  }else if(!empty($email1)&&!empty($email2)&&!empty($id)){
    $sql = "select * from member where id='$id'";
    $result = mysqli_query($conn,$sql) or die("실패원인 : ".mysqli_error($con));
    if(mysqli_num_rows($result)==0){
      echo "<script>
          alert('회원님의 정보가 존재하지 않습니다.');
        </script>";
    }else{
      $row = mysqli_fetch_array($result);
      echo "<script>
          alert('비밀번호는 ".$row['passwd']."입니다.');
        </script>";
      // $id = "비밀번호는".$row['passwd']."입니다.";
    }
  }
?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/common/css/login_menu.css">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/member/login/css/forgot_id_pw.css?ver=9">
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
    <title>아이디/비밀번호 찾기</title>
    <script type="text/javascript">
    var code="";
    $(document).ready(function(){
      $("#forgot_id").click(function(){
        $("#id").css('display', 'none');
        $("#id2").css('display', 'none');
        $("#id3").css('display', 'none');
      });
      $("#forgot_pw").click(function(){
        $("#id").css('display', 'inline');
        $("#id2").css('display', 'inline');
        $("#id3").css('display', 'inline');
      });
    $("#sub").click(function(event) {
      var email1 = document.getElementById("email1");
      var email2 = document.getElementById("email2");
      var email=email1.value.concat('@'+email2.value);
      $.ajax({
        url: 'check_email.php',
        type: 'POST',
        data: {email: email}
      })
      .done(function(result) {
        code=result;

        if(result!="등록되지않은 이메일입니다."){
          alert("인증번호가 전송되었습니다.");
        check_email1.setAttribute('type', 'text');
        check_email2.setAttribute('type', 'button');
        }else{
          alert("등록되지않은 이메일입니다.");
        }
      })
      .fail(function() {alert("인증 번호 발송실패!"); console.log("error");})
      .always(function() {console.log("complete");});
    });
    $("#check_email2").click(function(e){
      var email1 = document.getElementById("check_email1");
      if(email1.value==code){alert("인증 완료"); document.form1.submit();}else{alert("인증 실패");}});
    });
    </script>
  </head>
  <body>
    <header>
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/login_menu.php";?>
    </header>
    <section id="forgot_id_pw" >
      <div class="forgot_id_pw_form">
        <br><br><br><br><br><br><br><br><br><br>
        <table id="id_pw_tbl">
          <tr>
            <th id="forgot_id" style="border-right:solid 1px #BDBDBD;"><b>아이디찾기</b></th>
            <th id="forgot_pw"><b>비밀번호찾기</b></th>
          </tr>
          <tr>
            <td colspan="2" style="padding: 15px;">
              <form class="" name="form1" action="forgot_id_pw.php" method="post">
              <output id="id">아이디</output>
              <input style="margin-bottom: 1.5%;" id="id2" size="21" name="id2"><br id="id3">
              이메일
              <input type="text" name="email1" value="" size="7" id="email1">  @
              <input type="text" name="email2" value="" size="7" id="email2">
              <button type="button" name="button" id="sub" style="width:120px" >인증하기</button>
              </form>
            </td>
          </tr>
          <tr>
            <td colspan="2" style="padding-bottom: 1px; padding-top: 1px; padding-left:25px;">
              본인확인 이메일 주소와 입력한 이메일 주소가 같아야,
              인증번호를 받을 수 있습니다.
              <input type="hidden" name="check_email1" size="8" placeholder="인증번호" id="check_email1">
              <input type="hidden" name="check_email2" value="확인" id="check_email2"></button>
              <p><?=$id?></p>
           </td>
          </tr>
        </table>
      </div>
    </section>
    <footer>
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/footer.php";?>
    </footer>
  </body>
</html>
