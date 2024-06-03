document.write("hello world")
document.write("こーれコミットできません")

// 福井(180000)の予報を取得
let url = "https://www.jma.go.jp/bosai/forecast/data/forecast/130000.json";

fetch(url)
    .then(function(response) {
        return response.json();
    })
    .then(function(weather) {
        console.log(weather);
    });