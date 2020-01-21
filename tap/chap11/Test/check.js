function CheckForm(f) {
  var r1 = /[0123456789]/g; //숫자 0에서 부터 9까지의 문자 클래스
  var r1=/[0-9]/
  var r1=/\d/

  var r2 = /[^a-zA-Z0-9]/g; //영문자와 숫자를 제외한 모든 문자
  //var r2=/\W/
  var r3 = "~!@#$%^&*()_+=|\/?:\"'<>,.()[]{};"
  uname = f.user_name.value
  b = false;
  if (uname.replace(/\s/g, "") == "") {
    alert("이름을 입력하세요.");
    f.user_name.focus();
    return false;
  }

  for (i = 0; i < uname.length; i++) {
    var c = uname.charAt(i) if (r3.search(c) >= 0 || c.search(r1) >= 0) { //찾지 못하였을 때 반환하는 값 : -1
      b = true;
      break;
    }
  }

  if (b) {
    alert("이름은 문자만 입력하셔야 합니다.")
    f.user_name.value = "";
    f.user_name.focus();
    return false;
  }

  var strjumin1 = f.jumin1.value;
  var strjumin2 = f.jumin2.value;
  var j1 = /\d{6}/g;
  var j2 = /\d{7}/g;
  if (strjumin1.replace(/\s/g, "") == "" || strjumin1.match(j1) == null) {
    alert("주민등록번호 6자리를 입력하지 않았거나 숫자만 가능합니다.");
    f.jumin1.value = ""
    f.jumin1.focus();
    return false;
  }

  for (var i = 0; i < strjumin1.length; i++) {
    val1 = strjumin1.charAt(i) if (val1 < "0" || val1 > "9") {
      alert("주민등록번호는 숫자만 가능합니다.");
      f.jumin1.value = "";
      f.jumin1.focus();
      return false;
    }
  }

  if (strjumin2.replace(/\s/g, "") == "" || strjumin2.match(j2) == null) {
    alert("주민등록번호 7자리를 입력하지 않았거나 숫자만 가능합니다.");
    f.jumin2.value = ""
    f.jumin2.focus();
    return false;
  }

  var jumin = strjumin1 + strjumin2;
  var m = parseInt(jumin.charAt(12));
  var sum = 0;

  for (i = 0, j = 2; i <= 11; i++) {
    sum = sum + parseInt(jumin.charAt(i)) * j;
    j = j + 1;
    if (j == 10) j = 2;
  }

  var namuji = sum % 11;
  var gumsa = 11 - namuji;
  var check_no = gumsa % 10;
  if (check_no != m) {
    alert("주민등록번호를 잘못입력하셨습니다. 다시 입력해 주세요.");
    f.jumin1.value = "";
    f.jumin2.value = "";
    f.jumin1.focus();
    return false;
  }

  id = f.user_id.value
  if (id.replace(/\s/g, "") == "" || id.search(r2) >= 0) {
    alert("아이디를 입력되지 않았거나 아이디는 영문자와 숫자로 구성되어야 합니다.");
    f.user_id.value = ""
    f.user_id.focus();
    return false;
  }

  if (id.substr(0, 1).match(r1)) {
    alert("아이디의 첫 글자에는 숫자가 올 수 없습니다.");
    f.user_id.value = ""
    f.user_id.focus();
    return false;
  }
}

function check_focus(f) {
  var strfocus = f.jumin1.value.length;
  if (strfocus == 6) f.jumin2.focus();
}

function id_check() {
  window.open("idcheck.html", "", "width=300,height=100");
}
