// 配列の定義
const ue = ["ue1", "ue2", "ue3", "ue4","ue5"]; // 配列の要素数に応じてラジオボタンが増加
const  sita= ["sita1", "sita2", "sita3", "sita4","sita5"]; // 配列の要素数に応じてラジオボタンが増加


// ラジオボタンを追加するコンテナを取得
function radio(radio_name,arrayData){
    const container = document.getElementById('radio-buttons-container');

    //データベースから持ってくる場合は、正規表現を用いて服のジャンルごとにもってきて並べる。恐らくラジオボタンのnameを統一すれば一つ選択のみになる

    // 配列の要素数に基づいてラジオボタンを生成し、コンテナに追加
    for (let i = 0; i < arrayData.length; i++) {
        // ラジオボタンの要素を作成
        const radioButton = document.createElement('input');
        radioButton.type = 'radio';
        radioButton.name = radio_name;
        radioButton.value = arrayData[i];

        // ラベル要素を作成
        const label = document.createElement('label');
        label.textContent = arrayData[i];
        label.appendChild(radioButton);

        // コンテナにラジオボタンとラベルを追加
        container.appendChild(label);

        // 改行を追加（見やすくするため）
       container.appendChild(document.createElement('br'));
    }
}

radio("uefuku",ue)

radio("sitafuku",sita)
