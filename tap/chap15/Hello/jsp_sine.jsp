<%@page import="java.util.*, java.lang.*"%>
<html>
<head>
<title>싸인함수 테이블</title>
</head>
<body>
	<h1 align="center">
	싸인함수
	</h>
	<table border="1" align="center"><%!int angles[] = { 0, 30, 60, 90 };%><th>각도</th>
	<th>싸인값</th>
	<%
	for (int i = 0; i < 4; i++) {
	%>
	<tr>
	<td><%=angles[i]%></td>
	<td><%=Math.sin(Math.toRadians(angles[i]))%>
	</tr>
	<%} %>
	</table>
</body>
<html>