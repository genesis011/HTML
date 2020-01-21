<?php
session_start();
include '../../common/lib/db_connector.php';
?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/common/css/login_menu.css">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/tour/admin/css/admin_add_package.css?ver=1">
    <title>산뜻 :: 즐거운 산행</title>
    <script type="text/javascript">
      function check_input(){
        saveContent();
      }
    </script>
  </head>
  <body>
    <!--로그인 회원가입 로그아웃-->
    <div id="wrap">
    <header>
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/login_menu.php";?>
    </header>

    <div id="content">
      <br><br>
      <h2>패키지 수정.삭제</h2><br>
        <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/editor/editor2.php"; ?>
    </div>
    <footer>
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/footer.php";?>
    </footer>
    </div>
  </body>
</html>
