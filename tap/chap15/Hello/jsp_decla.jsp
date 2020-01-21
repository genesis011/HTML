<!DOCTYPE html>
<HTML>
<BODY>
<%@ page import="java.util.*" %>
<%!
    Date date = new Date();
    Date getDate()
    {
        return date;
    }
%>
안녕하세요? 현재 시각은 <%= getDate() %> 입니다.
</BODY>
</HTML>