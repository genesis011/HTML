<%@ page contentType="text/plain; charset=utf-8" %>
<%@ page pageEncoding="utf-8" %>
<%
 request.setCharacterEncoding("utf-8");
 String name = request.getParameter("name");
%>
안녕하세요, <%= name %>님!


