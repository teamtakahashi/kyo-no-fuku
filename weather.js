//とりあえず福井の座標を取得
var strUrl = "https://api.openweathermap.org/data/2.5/weather?lat=36.03&lon=136.13&appid=bf45f55105b1de116d8d3ab3fc205250";

var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
    // 非同期通信（Ajax）
    // readyState 4: リクエスト終了, status 200:通信成功
    if (this.readyState == 4 && this.status == 200) {
        var data = this.response;
        // 天気
        document.getElementById('unchiw1').innerHTML = "天気 : " + data.weather[0].main + "(" + data.weather[0].description + ")" + "</br>";
        document.getElementById('unchiw2').innerHTML = "気温 : " + data.main[0] + "</br>"; //データは絶対温度で取得される
        document.getElementById('unchiw3').innerHTML = "湿度 : " + data.main[0].humidity + "%" + "</br>";
        

        console.log(data);
    }
}

xmlhttp.open("GET", strUrl, true);  // 第３引数の意味（非同期通信：true、同期通信：false）
xmlhttp.responseType = 'json'; // JSONを取得するために必要
xmlhttp.send();