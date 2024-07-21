<?php 
 include 'db.php';
 session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style2.css">
    <title>今日の服</title>
    <style>
        #webcam-container {
            display: flex;
            justify-content: center;
            margin-bottom: 10px;
        }
        #label-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@latest/dist/tf.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@teachablemachine/image@latest/dist/teachablemachine-image.min.js"></script>
    </style>
</head>
<body>
    <header>
        <h1>今日の服</h1>
        <button onclick="location.href='index.php'">ホーム</button> 
        <hr>
    </header>
    <section>
        <h2 class="topick">カメラでアップロード</h2>

        <script>
        const URL = "./my_model/";
            let model, maxPredictions;
        function handleFileSelect(event) {
            const fileInput = event.target;
            const file = fileInput.files[0];
            
            if (file) {
                // ここでファイルの処理を行います
                uploadAndPredict();
                alert("ファイルが選択されました: " + file.name);
            } else {
                alert("ファイルが選択されていません");
            }
        }
        </script>

        <h1>Upload Image from Camera</h1>
    <form>
        <label for="camera-upload">Capture or upload an image:</label>
        <input id="camera-upload" type="file" name="file" accept="image/" capture="camera" onchange="handleFileSelect(event)">
    </form>

    </section>

    <section>
        <h2 class="topick">服を追加</h2>
        <label for="upload">写真を撮影してアップロードする</label>
        <h3>ファイルアップロードフォーム</h3>
        <form id="file-upload-form" action="closet.php" method="post" enctype="multipart/form-data">
            <label for="file">ファイルを選択してください:</label>
            <input id="camera-upload" type="file" name="file" accept="image/*" capture="camera" onchange="uploadAndPredict(event)">
            /* いる奴 */
            <input type="submit" value="アップロード">
        </form>

        <div id="label-container"></div>

        <script type="text/javascript">
            /* const URL = "./my_model/"; */
            /* let model, maxPredictions; */

            async function init() {
                const modelURL = URL + "model.json";
                const metadataURL = URL + "metadata.json";

                try {
                    model = await tmImage.load(modelURL, metadataURL);
                    maxPredictions = model.getTotalClasses();
                    console.log("Model loaded successfully");
                } catch (error) {
                    console.error("モデルの読み込みに失敗しました:", error);
                }
            }

            async function predict(imageElement) {
                if (!model) {
                    console.error("モデルが読み込まれていません");
                    return;
                }

                try {
                    const prediction = await model.predict(imageElement);
                    console.log("Prediction:", prediction);

                    // 結果を表示する
                    const labelContainer = document.getElementById("label-container");
                    labelContainer.innerHTML = '';

                    for (let i = 0; i < maxPredictions; i++) {
                        const classPrediction =
                            prediction[i].className + ": " + prediction[i].probability.toFixed(2);
                        const div = document.createElement("div");
                        div.textContent = classPrediction;
                        labelContainer.appendChild(div);
                    }

                    // 分類結果に応じて処理を行う
                    if (prediction[0].probability >= 0.8) {
                        /* class1が0.8以上の場合、フォームを送信する */
                        console.log('認識値：'. prediction[0].probability);
                        console.log('これは服です');
                        document.getElementById("file-upload-form").submit();
                    } else {
                        /* class2が0.8以上の場合、警告を出す */
                        console.log('認識値：'. prediction[0].probability);
                        alert("この画像は服として認識されませんでした。");
                    }

                } catch (error) {
                    console.error("予測の実行に失敗しました:", error);
                }
            }

            /* 呼び出される奴 */
            function uploadAndPredict(event) {
                /* アップロード前処理 */
                const fileInput = document.getElementById("camera-upload");
                const file = fileInput.files[0];
                if (!file) {
                    alert("画像を選択してください。");
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(event) {
                    const img = new Image();
                    img.onload = function() {
                        /* 服の判定 */
                        predict(img);
                    };
                    img.src = event.target.result;
                };
                reader.readAsDataURL(file);
            }

            // 初期化関数を呼び出す
            init();
        </script>

        <?php
        // アップロード先ディレクトリを指定します
        $uploadDir = 'image/';

        // ディレクトリが存在しない場合は作成します
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // ファイルがアップロードされたか確認します
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
            $uploadFile = $uploadDir . basename($_FILES['file']['name']);

            // ファイルのタイプを確認します（必要に応じてフィルタリングを行います）
            $fileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

            if (in_array($fileType, $allowedTypes)) {
                if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)) {
                    echo "ファイルが正常にアップロードされました。<br>";
                    echo '<img src="' . htmlspecialchars($uploadFile) . '" alt="アップロードされた画像">';
                } else {
                    echo "ファイルのアップロードに失敗しました。";
                }
            } else {
                echo "許可されていないファイルタイプです。";
            }
        } else {
            echo "ファイルが選択されていません。";
        }
        ?>




    </section>





    

    <section>
        <h2 class="topick">クローゼット</h2>
    <?php
        try {
            $dsn = "sqlsrv:server = tcp:kyofuku.database.windows.net,1433; Database = kyoufuku_db";
            $username = "oomoto";
            $password = "FStKV6rvFqypNdG"; // パスワードを適切に設定してください
            $options = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            );

            $connection = new PDO($dsn, $username, $password, $options);
            // echo "Connection successful.<br>";

            $query = "SELECT * FROM cloth_table";
            $statement = $connection->query($query);

            if ($statement) {
                // echo "Query successful.<br>";
                $results = $statement->fetchAll(PDO::FETCH_ASSOC);
                
                if (count($results) > 0) {
                    foreach ($results as $row) {
                        echo '<h3>'. htmlspecialchars($row['No']). '</h3>';
                        $img = htmlspecialchars($row['cloth_id']);
                        echo '<img class="image" src=" ' . $img . ' " alt="ClothImage" style="max-width: 50%; height: auto;"><br>';
                    }
                } else {
                    echo "No records found.<br>";
                }
            } else {
                echo "Query failed.<br>";
            }
        } catch (PDOException $e) {
            die("Error connecting to SQL Server: " . $e->getMessage());
        }
    ?>
    </section>





</head>
</body>
</html>