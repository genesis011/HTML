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

    <!-- 패키지 코드 랜덤 생성 -->
    <?php
    $package_str = "";
        for($i=0;$i<2;$i++) {
            $capi = rand()%26+65;
            $package_str .= chr($capi);
        }
    $package_num = mt_rand(100000, 999999);
    $package_number = $package_str . $package_num;
    ?>
  </head>

  <body>
    <!--로그인 회원가입 로그아웃-->
    <div id="wrap">
    <header>
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/login_menu.php";?>
    </header>

    <div id="content">
      <br><br>
      <h2>패키지 등록</h2><br>
        <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/editor/editor.php"; ?>
    </div>
    <footer>
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/footer.php";?>
    </footer>

    </div>

  </body>
</html>
