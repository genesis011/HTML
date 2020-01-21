<?php
/*
=================================================================
+ [DESC] 장바구니 목록
+ [DATE] 2019-05-19
+ [NAME] 김민지
=================================================================
*/
// session_start();
include $_SERVER['DOCUMENT_ROOT']."/santteut/tour/cart/cart_list_query.php";
?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/common/css/login_menu.css">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/tour/cart/css/cart_list.css">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/common/css/side_bar.css">
  <title>산뜻 :: 즐거운 산행</title>
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
  </head>
  <body>
    <div id="wrap">
    <header>
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/login_menu.php";?>
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/side_bar.php";?>
    </header>
    <hr>
    <!--장바구니 리스트 페이지-->
    <div id="cart_list" style="height: 700px; max-height:2000px;">
      <h3 id="title" >장바구니</h3>
      <fieldset id="list_field" >
        <table id="list_tbl_body" style="">
          <tr>
            <td><input type="checkbox" name="cart_check_all"  onclick="all_check()" value=""></td>
            <td width="800px">상품명/상품코드</td>
            <td>출발일자</td>
            <td>상품가격</td>
          </tr>
          <?php
            for($i=1;$i<=$total_record;$i++){
              $row = mysqli_fetch_array($s_result);
              $cart_code = $row['p_code'];
              $cart_name = $row['p_name'];
              $cart_dp_date = $row['p_dp_date'];
              $cart_pay = $row['p_pay'];
          ?>
          <tr>
            <td><input type="checkbox" name="cart_check" value="<?=$cart_code?>"></td>
            <td width="800px"><a href="../package/package_view.php?mode=<?=$cart_code?>"><?=$cart_name?>/<?=$cart_code?></a></td>
            <td><?=$cart_dp_date?></td>
            <td><?=$cart_pay?></td>
          </tr>
          <?php
            }
          ?>
        </table>
        <?php
          if(empty($total_record)){
            echo '<p id="no_result" style="text-align:center; padding:2%;margin-bottom:3%;"> 장바구니 내역이 없습니다.</p>';
          }
        ?>
        <script type="text/javascript">
          function all_check(){
            var cart_check=document.getElementsByName('cart_check');
            var cart_check_all=document.getElementsByName('cart_check_all');
            if(cart_check_all[0].checked==true){
              for(var i=0; i<=cart_check.length-1;i++){
                  cart_check[i].checked=true;
              }
            }else{
              for(var i=0; i<=cart_check.length-1;i++){
                  cart_check[i].checked=false;
              }
            }
          }
        </script>
        <form id="delete_form" action="cart_list_query.php" name="delete_form" method="post">
        <input type="hidden" id="output" name="output" value="">
        </form>
        <br>
        <input type="button" id="del_btn" onclick="delete_submit()" value="삭제하기" >
        <script type="text/javascript">
          function delete_submit(){
            var cart_check=document.getElementsByName('cart_check');
            var output = document.getElementById('output');
            for(var i=0; i<=cart_check.length-1;i++){
              if(cart_check[i].checked==true){
                output.value+="/"+cart_check[i].value;
              }
            }
            document.delete_form.submit();
          }
        </script>
      </fieldset>
    </div> <!-- end of div "reserve_list" -->
    <footer> <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/footer.php";?> </footer>
    </div>  <!-- end of div "wrap" -->
  </body>
</html>
