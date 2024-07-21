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
        
    </style>
</head>
<body>
    <header>
        <h1>今日の服</h1>
        <button onclick="location.href='index.php'">ホーム</button> 
        <hr>
    </header>

    <section>
        <h2 class="topick">服を追加</h2>
        <label for="upload">写真を撮影してアップロードする</label>
        <h3>ファイルアップロードフォーム</h3>
        <form action="closet.php" method="post" enctype="multipart/form-data">
            <label for="file">ファイルを選択してください:</label>
            <input type="file" name="file" id="file">
            <br>
            <label for="file">ユーザ番号:</label>
            <input type="text" name="uesr_num" id="user_num">
            <br>
            <label for="file">服の種類:</label>
            <input type="text" name="cloth_kind" id="cloth_kind">
            <br>
            <label for="file">IC:</label>
            <input type="text" name="Ic" id="Ic">
            <br>
            <label for="file">タグ１:</label>
            <input type="text" name="Tag1" id="Tag1">
            <br>
            <label for="file">タグ２:</label>
            <input type="text" name="Tag2" id="Tag2">
            <br>
            <input type="submit" value="アップロード">
        </form>

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
        // ここまではイイ感じ

// POSTデータ
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // echo htmlspecialchars($_POST["value"]);
            
            $cloth_id = $_FILES['file']['name'];
            $user_num = $_POST['uesr_num'];
            $cloth_kind = $_POST['cloth_kind'];
            $Ic = $_POST['Ic'];
            $Tag1 = $_POST['Tag1'];
            $Tag2 = $_POST['Tag2'];
            try {

            // データベース接続の確認
            if (!$connection) {
                die("Connection failed: " . mysqli_connect_error());
            } else {
                echo "接続成功.<br>";
            }



            // -----------------
            $countQuery = "SELECT COUNT(*) as No FROM cloth_table";
    $statement = $connection->prepare($countQuery);
    $statement->execute();

    // 行数を取得
    $rowCount = "";
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    $rowCount = $result['No'];

    // 行数を表示
    echo "Chat GPTTotal number of rows: " . $rowCount . "<br>";
            // ------------------

        //     // クエリの実行
        //     $query = "SELECT COUNT(ALL No) FROM cloth_table";
        //     // $statement2 = $connection->prepare($countQuery);
        //     $statement2 = $connection->query($query);
        //     // $statement2->execute();


        //     $No = $statement2->rowCount();
        //     echo "Total number of rows: " . $No . "<br>";
        // // なぜかマイナス

        //     if ($statement2) {
        //         echo "Query 成功.<br>";
        //         $results = $statement2->fetchAll(PDO::FETCH_ASSOC);
        //         $rowCount = $result['rowCount'];
        //         echo "Total number of rows: " . $rowCount . "<br>";
    
        //         // if (count($results) > 0) {
        //         //     foreach ($results as $row) {
                        
        //         //     }
        //         // } else {
        //         //     echo "見つからなよー.<br>";
        //         // }
        //     } else {
        //         echo "Query 無理だ―.<br>";
        //     }


            $No = $rowCount + 1;

            
            $query = "INSERT INTO cloth_table (No, user_num, cloth_id, cloth_kind, Ic, Tag1, Tag2) VALUES ($rowCount+1, $user_num, N'image/$cloth_id', N'$cloth_kind', N'$Ic', N'$Tag1', N'$Tag2');";
            $statement = $connection->query($query);
            
            // $total = mysqli_num_rows() 編集中


            if ($statement) {
                echo "Query 成功.<br>";
                $results = $statement->fetchAll(PDO::FETCH_ASSOC);
    
                
                
            } else {
                echo "Query 無理だ―.<br>";
            }
        
        } catch (PDOException $e) {
            // die("Error connecting to SQL Server: " . $e->getMessage());
        }
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