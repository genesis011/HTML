<HTML>
<BODY>
<TABLE BORDER=2>
<%
	int n=3;
    for ( int i = 0; i < n; i++ ) {
        %>
        <TR>
        <TD>Number</TD>
        <TD><%= i+1 %></TD>
        </TR>
        <%
    }
%>
</TABLE>
</BODY>
</HTML>