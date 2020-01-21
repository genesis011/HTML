<%! int day = 3; %> 
<html> 
<head><title>if/else 예제</title></head> 
<body>
<% if (day == 1 | day == 7) { %>
      <p> 오늘은 주말입니다.</p>
<% } else { %>
      <p> 오늘은 주말이 아닙니다.</p>
<% } %>
</body> 
</html> 
