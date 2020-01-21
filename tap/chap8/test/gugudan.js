var table = document.createElement('table');
table.style.border = "1px solid gray";
var tbody = document.createElement('tbody');
table.appendChild(tbody);

for(var i = 2 ; i <= 9 ; i++){
    var tr = document.createElement('tr');
    for(var j = 1 ; j <= 9 ; j++){
        var td = document.createElement('td');
        td.textContent = i + "*" + j + "=" + (i * j);
        td.style.border = "1px solid gray";
        tr.appendChild(td);
    }
    tbody.appendChild(tr);
}
document.body.append(table);
