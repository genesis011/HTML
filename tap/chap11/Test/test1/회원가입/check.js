function nameCheck(){
  var name = document.getElementById('name');
  var nameExp = /^[가-힣a-zA-Z\x20]{2,8}$/;
  var spanName = document.getElementById('span-name');

  if(name.value === ""){
    spanName.innerHTML = "이름은 빈 칸일 수 없습니다.";
        return false;
  } else if (!name.value.match(nameExp)){
    spanName.innerHTML = "이름은 영문, 한글로 2-8자를 입력해 주세요";
        return false;
  } else {
    spanName.innerHTML = "OK";
    return true;

  }
}
function jumin1Check(){
  var jumin1 = document.getElementById('jumin1');
  var jumin1Exp = /^[0-9]{6}$/;
  var spanJumin = document.getElementById('span-jumin');

  if(jumin1.value === ""){
    spanJumin.innerHTML = "주민등록번호는 빈 칸일 수 없습니다.";
    return false;
  } else if (!jumin1.value.match(jumin1Exp)){
    spanJumin.innerHTML = "주민등록번호 앞자리 6자를 입력해 주세요";
    return false;
  } else {
    spanJumin.innerHTML = "OK";
    return true;
  }
}
function jumin2Check(){
  var jumin2 = document.getElementById('jumin2');
  var jumin2Exp = /^[0-9]{7}$/;
  var spanJumin = document.getElementById('span-jumin');

  if(jumin2.value === ""){
    spanJumin.innerHTML = "주민등록번호는 빈 칸일 수 없습니다.";
    return false;
  } else if (!jumin2.value.match(jumin2Exp)){
    spanJumin.innerHTML = "주민등록번호 뒷자리 7자를 입력해 주세요";
    return false;
  } else {
    spanJumin.innerHTML = "OK";
    return true;
  }
}
function idCheck(){
  var id = document.getElementById('id');
  var idExp = /^[a-zA-Z]{1}[0-9a-zA-Z]{7,11}$/;
  var spanId = document.getElementById('span-id');

  if(id.value === ""){
    spanId.innerHTML = "아이디는 빈 칸일 수 없습니다.";
    return false;
  } else if (!id.value.match(idExp)){
    spanId.innerHTML = "아이디는 영문, 숫자로 8-12자를 입력해 주세요";
    return false;
  } else {
    spanId.innerHTML = "OK";
    return true;
  }
}
function checkDone(){
  if(nameCheck() && jumin1Check() && jumin2Check() && idCheck()){
    alert('가입을 축하드립니다.');
  } else {
    alert('실패하였습니다. 폼을 확인해 주세요');
  }
}
