//とりあえず福井の座標を取得
var strUrl = "https://api.openweathermap.org/data/2.5/weather?lat=36.03&lon=136.13&appid=bf45f55105b1de116d8d3ab3fc205250";

var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
    // 非同期通信 (Ajax)
    // readyState 4: リクエスト終了, status 200:通信成功
    if (this.readyState == 4 && this.status == 200) {
        var data = this.response;
        let text = "";
        text = "天気 : " + data.weather[0].main + " (" + data.weather[0].description + ")" + "</br>"; //天気
        text += "気温 : " + Math.round((data.main.temp-273.15)*100)/100 + "℃" + "</br>"; //気温は絶対温度で取得される
        text += "湿度 : " + data.main.humidity + "%" + "</br>"; //湿度
        // 出力
        document.getElementById('h1').innerHTML = "天気API";//天気
        document.getElementById('h2_1').innerHTML = text;//天気

        console.log(data);

        /*今日のコーデ作成 --- 天気、気温、湿度をもとに適切な服をランダムに選ぶ*/
        if(data.weather[0].main == "Snow"){     //雪が降る日は厚手の長袖長ズボン、あれば上着羽織る
            document.getElementById('h2_3').innerHTML = "厚手の長袖長ズボンor上着";
        }else{
            if(30 <= Math.round((data.main.temp_max-273.15)*100)/100){
                if(65 <= data.main.humidity){
                    document.getElementById('h2_3').innerHTML = "半袖半ズボン";//じめじめするので半ズボン
                }else{
                    document.getElementById('h2_3').innerHTML = "半袖";//最高気温30℃超えたら半袖(半ズボンは自由)
                }
            }else if(Math.round((data.main.temp_max-273.15)*100)/100 < 20){
                if(Math.round((data.main.temp_max-273.15)*100)/100 <= 5){
                    document.getElementById('h2_3').innerHTML = "厚手の長袖";//最高気温5℃未満は厚手の長袖
                }else{
                    document.getElementById('h2_3').innerHTML = "長袖";//最高気温20℃未満は長袖
                }
                
            }else if(12 <= data.main.temp_max - data.main.temp_min){
                document.getElementById('h2_3').innerHTML = "半袖と上着";//気温差12℃以上は半袖に上着羽織る
            }else{
                document.getElementById('h2_3').innerHTML = "好きな服着よう"; //どっちでも大丈夫そう
            }
        }
        /*オプション (あったらつけるやつ)*/
        if(data.weather[0].main == "Snow" || data.weather[0].main == "Rain"){
            document.getElementById('h2_4').innerHTML = "長靴"; //雨か雪だと長靴
        }else if(data.weather[0].main == "Clear" && 30 <= Math.round((data.main.temp_max-273.15)*100)/100){
            document.getElementById('h2_4').innerHTML = "帽子"; //晴れていて気温30℃以上だと帽子
        }else if(Math.round((data.main.temp-273.15)*100)/100 <= 5){
            document.getElementById('h2_4').innerHTML = "マフラー";//気温5℃以下だとマフラー
        }
    }
}



xmlhttp.open("GET", strUrl, true);  // 第３引数の意味 (非同期通信：true、同期通信：false)
xmlhttp.responseType = 'json'; // JSONを取得するために必要
xmlhttp.send();

console.log('マジで疲れた変な名前にすんな!');