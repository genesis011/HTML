function setClock() {
    var now = new Date();
    document.getElementById('clock').innerHTML = now;
    setTimeout('setClock()', 1000);
}