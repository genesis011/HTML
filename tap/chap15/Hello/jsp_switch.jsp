<%! int day = 2; %> 
<html> 
<head><title>switch 예제</title></head> 
<body>
<% 
switch(day) {
case 0:
   out.println("오늘은 일요일입니다.");
   break
case 1:
   out.println("오늘은 월요일입니다.");
   break
case 2:
   out.println("오늘은 화요일입니다.");
   break
case 3:
   out.println("오늘은 수요일입니다.");
   break
case 4:
   out.println("오늘은 목요일입니다.");
   break
case 5:
   out.println("오늘은 금요일입니다.");
   break
case 6:
   out.println("오늘은 토요일입니다.");
   break
default:
   out.println("잘못된 요일입니다.");
}
%>
</body> 
</html> 