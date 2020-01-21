<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://developers.kakao.com/sdk/js/kakao.min.js"> </script>
    <title>로그인</title>
    <script type="text/javascript">
    Kakao.init('fe46daffa4b40efbbdca82b06d5871ea');

      Kakao.Auth.loginForm({
         success: function(authObj) {
         Kakao.API.request({
            url: '/v2/user/me',
            success: function(res) {
                 $("#id").val(JSON.stringify(res.id));
                 $("#name").val(JSON.stringify(res.properties.nickname));
                 $("#email").val(JSON.stringify(res.kaccount_email));
                 document.member_form.submit();
            },
            fail: function(error) {
              alert(JSON.stringify(error))
            }
          });
          },
       fail: function(err) {
       }
      });

    </script>
    <title></title>
  </head>
  <body>
  <form name="member_form" action="../join/join_query.php" method="post">
    <input type="hidden" name="mode" value="kakao">
    <input type="hidden" name="join_id" id="id" value="">
    <input type="hidden" name="join_name" id="name"  value="">
    <input type="hidden" name="email" id="email"  value="">

  </form>
  </body>
</html>
