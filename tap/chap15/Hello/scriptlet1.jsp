<!DOCTYPE html>
<HTML>
<BODY>
	<%
	    System.out.println( "날짜를 출력하여 본다." );
	    java.util.Date date = new java.util.Date();
	%>
	안녕하세요? 현재 시각은 
	<%
	    out.println( String.valueOf( date ));
	%>
입니다.
</BODY>
</HTML>