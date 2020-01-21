<%@ page contentType="text/html; charset=utf-8" language="java" %>
<%
String[] array={"홍길동","김철수","김영희"};
%>

<html>
<body>
    <%
     int i=0;
     for(i=0;i<array.lengthi++)
     {
      out.print("배열 요소: "+array[i]+"<br/>");
     }
    %>
</body>
</html>