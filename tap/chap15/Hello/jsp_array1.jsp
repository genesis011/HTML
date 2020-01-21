<%@ page contentType="text/html; charset=utf-8" language="java" %>
<%@ page import="java.util.ArrayList" language="java" %>

<%
ArrayList ar=new ArrayList();
ar.add("홍길동");
ar.add("김철수");
ar.add("김영희");

%>

<html>
<body>
    <%
     int i=0;
     for(i=0;i<ar.size();i++)
     {
      out.print("배열 요소: "+ar.get(i)+"<br/>");
     }
    %>
</body>
</html>