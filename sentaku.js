// 配列の定義
const items = ["value1", "value2", "value3", "value4","value5"]; // 配列の要素数に応じてラジオボタンが増加

// ラジオボタンを追加するコンテナを取得
const container = document.getElementById('radio-buttons-container');

// 配列の要素数に基づいてラジオボタンを生成し、コンテナに追加
for (let i = 0; i < items.length; i++) {
    // ラジオボタンの要素を作成
    const radioButton = document.createElement('input');
    radioButton.type = 'radio';
    radioButton.name = 'han_radio';
    radioButton.value = items[i];

    // ラベル要素を作成
    const label = document.createElement('label');
    label.textContent = items[i];
    label.appendChild(radioButton);

    // コンテナにラジオボタンとラベルを追加
    container.appendChild(label);

    // 改行を追加（見やすくするため）
    container.appendChild(document.createElement('br'));
}