<?php
  include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/db_connector.php";
  $num = test_input($_GET["num"]);
  $page = test_input($_GET["page"]);
  $hit = test_input($_GET["hit"]);
  $q_num = mysqli_real_escape_string($conn, $num);
  $sql = "SELECT pw FROM `qna` WHERE num = '$q_num';";
  $result = mysqli_query($conn,$sql);
    if (!$result) {die('Error: ' . mysqli_error($conn));}
    $row=mysqli_fetch_array($result);
    $pw=$row['pw'];
    if(empty($pw)){
?>
<script>window.opener.location.href="./qna_view.php?num=<?=$num?>&page=<?=$page?>&hit=<?=$hit+1?>";
  window.close();
</script>
<?php
    }
?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
      <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/community/official_review/css/official_review_form.css">
    <title>비밀번호 입력</title>
  </head>
  <body>
    <section id="notice">
      <form action="qna_query.php?mode=pass" method="post">
        <table border="1" style="margin-left:3%; margin-top:8%;">
        <tr>
          <th>비밀번호</th>
          <td style="width:300px;">
            <input type="hidden" name="num" value="<?=$num?>">
            <input type="hidden" name="page" value="<?=$page?>">
            <input type="hidden" name="hit" value="<?=$hit?>">
            <input type="password" name="password" style="height:25px; width:200px; margin-left:5px;">
            <input type="submit" value="확인" style="width:50px; height:24px; background-color: #2F9D27; border: 1px solid #2F9D27; color: white; margin-left: 10px;">
          </td>
        </tr>
      </table>
    </form>
  </section>
  </body>
</html>
