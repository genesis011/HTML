<?php
if(!session_id()) {
    session_start();
}
require_once './src/Facebook/autoload.php'; // download official fb sdk for php @ https://github.com/facebook/php-graph-sdk
$fb = new Facebook\Facebook([
  'app_id' => '2504643382879573', //님의 앱ID 적어주세요

  'app_secret' => 'bda00bb09a5f836db5715d31bde6e8b5', //님의 시크릿코드 적어주세요

  'default_graph_version' => 'v2.11',
  ]);
$helper = $fb->getRedirectLoginHelper();
$permissions = ['email']; // optional

try {
	if (isset($_SESSION['facebook_access_token'])) {
		$accessToken = $_SESSION['facebook_access_token'];
	} else {
  		$accessToken = $helper->getAccessToken();
	}
} catch(Facebook\Exceptions\FacebookResponseException $e) {
 	// When Graph returns an error
 	echo 'Graph returned an error: ' . $e->getMessage();
  	exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
 	// When validation fails or other local issues
	echo 'Facebook SDK returned an error: ' . $e->getMessage();
  	exit;
 }
if (isset($accessToken)) {
	if (isset($_SESSION['facebook_access_token'])) {
		$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
	} else {
		// getting short-lived access token
		$_SESSION['facebook_access_token'] = (string) $accessToken;
	  	// OAuth 2.0 client handler
		$oAuth2Client = $fb->getOAuth2Client();
		// Exchanges a short-lived access token for a long-lived one
		$longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
		$_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;
		// setting default access token to be used in script
		$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
	}
	// redirect the user back to the same page if it has "code" GET variable
  // 함수 실행 후 요청 페이지
	// if (isset($_GET['code'])) {}
	// getting basic info about user
  //사용자 정보********************
  try {
		$profile_request = $fb->get('/me?fields=name,first_name,last_name,email');
    // PRINT basic info
    $profile = $profile_request->getGraphNode()->asArray();

    //결과 예시 array(5) { ["name"]=> string(9) "Minji Kim"
    // ["first_name"]=> string(5) "Minji"
    //["last_name"]=> string(3) "Kim"
    //["email"]=> string(17) "example@gmail.com" ["id"]=> string(16) "1576170299186210" }

    echo '  <form name="member_form" action="../join/join_query.php" method="post">
        <input type="hidden" name="mode" id="id" value="facebook">
        <input type="hidden" name="join_id" id="id" value="'.$profile['id'].'">
        <input type="hidden" name="join_name" id="name"  value="'.$profile['name'].'">
        <input type="hidden" name="email" id="email"  value="'.$profile['email'].'">
      </form>  <script>document.member_form.submit();</script>  ';

	} catch(Facebook\Exceptions\FacebookResponseException $e) {
		// When Graph returns an error
		echo 'Graph returned an error: ' . $e->getMessage();
		session_destroy();
		// redirecting user back to app login page
		header("Location: ./");
		exit;
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
		// When validation fails or other local issues
		echo 'Facebook SDK returned an error: ' . $e->getMessage();
		exit;
	}

	// printing $profile array on the screen which holds the basic info about user
	print_r($profile);
  	// Now you can redirect to another page and use the access token from $_SESSION['facebook_access_token']
} else {
	// replace your website URL same as added in the developers.facebook.com/apps e.g. if you used http instead of https
  // and you used non-www version or www version of your website then you must add the same here

	$loginUrl = $helper->getLoginUrl('http://localhost/santteut/member/login/facebook.php', $permissions);

}

?>
