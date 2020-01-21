// 소수를 찾는 자바스크립트 소스
var n = 1;
search: while (true) {
    n += 1;
    for (var i = 2; i <= Math.sqrt(n) ; i += 1)
        if (n % i == 0)
            continue search;
    // 소수를 발견할 때마다 바로 웹페이지로 전달한다. 
    postMessage(n);
}