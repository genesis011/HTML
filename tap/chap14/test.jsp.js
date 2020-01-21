<%@ page import="java.util.Date" %>
<%
response.setContentType("text/event-stream;charset=utf-8");
Date time = new Date();
%>
data:<%= time %>