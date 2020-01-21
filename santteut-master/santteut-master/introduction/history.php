<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/common/css/login_menu.css">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/introduction/css/history.css">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/common/css/side_bar.css">
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.0/css/all.css' integrity='sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ' crossorigin='anonymous'>
    <title>연혁</title>
  </head>
  <body>
    <!--로그인 회원가입 로그아웃-->
    <header>
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/login_menu.php";?>
    </header>
    <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/side_bar.php";?>
    <section id="history">
      <!-- <h2 style="margin-left: 18%;">산뜻소개</h2> -->
      <hr>
      <ul id="title_history">
          연혁
      </ul>
      <hr>
      <h4>산뜻산악회</h4>
      <br>
      <h3 style="color:#2F9D27; list-style:none; margin-left: 33%;">2019's</h3>
        <ul id="field">
          <li><i class='fas fa-tree'></i>&nbsp;<strong>6월 20일</strong><br><br>
            미래교육원수료와 함께 첫번째로 설립된 민간조직<br><br>
            김주오이조민회원들을 중심으로 미래강당에서 창립총회를 갖고 명칭을 산뜻산악회라 칭함<br><br>
            초대 팀장에 php파이어 김밍밍 언니를 추대<br><br>
            산뜻산악회는 첫 사업으로 5명의 동지들이 모여 미래교육원수료기념등산회를 가짐<br><br>
          </li>
          <li><i class='fas fa-tree'></i>&nbsp;<strong>6월 21일</strong><br><br>
            등산의 일상화를 위해 미래교육원생들을 대상으로 제 1회 등행대회를 개최<br><br>
          </li>
          <li><i class='fas fa-tree'></i>&nbsp;<strong>6월 22일</strong><br><br>
            햄버거산 등반을 시작으로 롤롤산, 랄라산 등지에서 극지법 등반훈련을 실시하였고,<br><br>
            산악운동의 저변확대와 인재 양성을 목적으로 학생 해양산악훈련을 다섯 차례 실시하면서<br><br>
            우리나라 산악운동의 초석을 튼튼히 다짐<br><br>
          </li>
          <li><i class='fas fa-tree'></i>&nbsp;<strong>6월 23일</strong><br><br>
            취임하신 김밍밍 팀장은 필라테스운동의 가치를 내세우며 20일부터 혈기왕성한 성훈부팀장과<br><br>
            민수부부팀장과 각 대학 산악부 리더들을 대상으로 본격적인 산악훈련 등반을 전개<br><br>
          </li>
          <li><i class='fas fa-tree'></i>&nbsp;<strong>6월 24일</strong><br><br>
            해외 고산 원정을 목표로 똥똥산에 훈련대를 파견, 폭설에 의한 눈사태로 이똥똥 대장을 포함<br><br>
            10명의 젊은 대원들을 잃는 산악조난사고 발생<br><br>
          </li>
        </ul>
        <h3 style="color:#2F9D27; margin-left: 33%;">2020's</h3>
        <ul id="second" style="margin-left: 35%;">
          <li><i class='fas fa-tree'></i>&nbsp;<strong>6월 25일</strong><br><br>
            8일 오성훈 회장이 취임하면서 산악 선진국의 새로운 등산기술을 도입하기 위해 프랑스 국립<br><br>
            이노무샤키등산학교에서 제1차 훈련대를 파견 국내 등반기술 변혁에 새로운 전기를 마련<br><br>
          </li>
          <li><i class='fas fa-tree'></i>&nbsp;<strong>6월 26일</strong><br><br>
            세계 다섯 번째 고봉인 니똥응가를 등정하는 쾌거를 이뤄냄<br><br>
          </li>
        </ul>
    </div>
    </section>
    <br><br><br>
    <footer>
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/footer.php";?>
    </footer>
  </body>
</html>
