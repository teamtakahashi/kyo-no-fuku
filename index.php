<?php 
 include 'db.php';
 session_start();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style2.css">
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@latest/dist/tf.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@teachablemachine/image@latest/dist/teachablemachine-image.min.js"></script>
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
        .image {
            width:50%;
            height:auto;
        }
    </style>
    <title>今日の服</title>
</head>
<body>
    <header id="top">
        <div class="header-top">
            <img src="kyo-no-wanko.png" alt="header_img" style="max-width: 20%; height: auto;">
            <h1>今日の服</h1>
        </div>
        
        <!-- タイトル -->
        <hr>
        <button onclick="location.href='closet.php'">クローゼット</button>  
        <button onclick="location.href='coordination'">Myコーデ</button> 
        <div class="header-low">            
            <nav>
                <ul>
                    <li class="crumb"><a href="#top">top</a></li>
                    <li class="crumb"><a href="#recommendation">おすすめ</a></li>
                    <li class="crumb"><a href="#search">コーデ検索</a></li>
                </ul>
            </nav>
        </div>
        
        <!-- ナビゲーション -->
    </header>

    <main>
    <?php

/**
 * try {
            $dsn = "sqlsrv:server = tcp:kyofuku.database.windows.net,1433; Database = kyoufuku_db";
            $username = "oomoto";
            $password = "FStKV6rvFqypNdG"; // パスワードを適切に設定してください
            $options = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            );

            $connection = new PDO($dsn, $username, $password, $options);
            echo "Connection successful.<br>";

            $query = "SELECT * FROM cloth_table";
            $statement = $connection->query($query);

            if ($statement) {
                echo "Query successful.<br>";
                $results = $statement->fetchAll(PDO::FETCH_ASSOC);
                
                if (count($results) > 0) {
                    foreach ($results as $row) {
                        echo "Cloth kind: " . htmlspecialchars($row['cloth_kind']) . "<br>";
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
 * 
 * 
 */
       
        ?>
        <article>
            <section class="recommendation" id="recommendation">
                <!-- おすすめ -->
                <div class="wrapper">
                    <h2 class="topick">おすすめコーデ</h2>
                    <p>今日のおすすめコーデ</p>

                    <!-- <img class="image" src="image/fuku1.png" alt=""> -->
                    <!-- <h1 id="h1"></h1> -->
                    <!-- <h2 id="h2_1"></h2> -->
                    
                    <!-- <h2>---------------------</h2> -->
                    <!-- <h2 id="h2_3"></h2> -->
                    <!-- <h2 id="h2_4"></h2> -->
                    <!-- <script src="weather2.js"></script> -->

                    
                    <?php
                    
                    $lat = 36.03;
                    $lon = 136.13;
                    $appid = 'bf45f55105b1de116d8d3ab3fc205250';
                    $strUrl = "https://api.openweathermap.org/data/2.5/weather?lat={$lat}&lon={$lon}&appid={$appid}";
                    $cloth = "";
                    
                    // APIからデータを取得
                    $response = file_get_contents($strUrl);
                    
                    // JSONを配列に変換
                    $data = json_decode($response, true);
                    
                    // 出力
                    $text = "天気 : " . $data['weather'][0]['main'] . " (" . $data['weather'][0]['description'] . ")" . "<br>";
                    $text .= "気温 : " . round(($data['main']['temp'] - 273.15), 2) . "℃" . "<br>";
                    $text .= "湿度 : " . $data['main']['humidity'] . "%" . "<br>";
                                        
                    // 今日のコーデ作成
                    if ($data['weather'][0]['main'] == "Snow") {
                        echo "<div id='h2_3'>厚手の長袖長ズボンor上着</div>";
                    } else {
                        if (30 <= round(($data['main']['temp_max'] - 273.15), 2)) {
                            if (65 <= $data['main']['humidity']) {
                                $cloth = "半袖半ズボン";
                            } else {
                                $cloth = "半袖";
                            }
                        } else if (round(($data['main']['temp_max'] - 273.15), 2) < 20) {
                            if (round(($data['main']['temp_max'] - 273.15), 2) <= 5) {
                                $cloth =  "厚手の長袖";
                            } else {
                                $cloth =  "長袖";
                            }
                        } else if (12 <= $data['main']['temp_max'] - $data['main']['temp_min']) {
                            $cloth =  "半袖と上着";
                        } else {
                            $cloth =  "好きな服着よう";
                        }
                        echo '<h2>' . $cloth . ' </2>';
                    }
                    
                    // オプション (あったらつけるやつ)
                    if ($data['weather'][0]['main'] == "Snow" || $data['weather'][0]['main'] == "Rain") {
                        echo "<div id='h2_4'>長靴</div>";
                    } else if ($data['weather'][0]['main'] == "Clear" && 30 <= round(($data['main']['temp_max'] - 273.15), 2)) {
                        echo "<div id='h2_4'>帽子</div>";
                    } else if (round(($data['main']['temp'] - 273.15), 2) <= 5) {
                        echo "<div id='h2_4'>マフラー</div>";
                    }
                    
                    
                  

                        try {

                            // ---------------------
                            
                            
                            // ------------------------
    
    
    
                            // データベース接続の確認
                            if (!$connection) {
                                die("Connection failed: " . mysqli_connect_error());
                            } else {
                                // echo "接続成功.<br>";
                            }
    
                            // クエリの実行
                            $query = "SELECT cloth_id FROM cloth_table WHERE cloth_kind = N'$cloth'";
                            $statement = $connection->query($query);
    
                            if ($statement) {
                                // echo "Query 成功.<br>";
                                $results = $statement->fetchAll(PDO::FETCH_ASSOC);
                    
                                if (count($results) > 0) {
                                    foreach ($results as $row) {
                                        echo "Cloth id: " . htmlspecialchars($row['cloth_id']) . "<br>";
                                        $cloth_id = htmlspecialchars($row['cloth_id']);
                                        echo '<img class="image" src=" ' . $cloth_id . ' " alt="cloth Image" "><br>';
                                    }
                                } else {
                                    echo "見つからなよー.<br>";
                                }
                            } else {
                                echo "Query 無理だ―.<br>";
                            }
                        
                        } catch (PDOException $e) {
                            die("Error connecting to SQL Server: " . $e->getMessage());
                        }

                    ?>

                </div>
            </section>

            <section class="search" id="search">
                <h2 class="topick">コーデ検索</h2>
                <!-- 検索 -->
                <div class="wrapper">
                    <form action="" method="POST">
                        <label for="value">検索</label>
                        <input type="text" name="value" id="value">                        
                        <input type="submit" value="送信">
                    </form>

                    <?php 
                    
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        // echo htmlspecialchars($_POST["value"]);
                        $inValue = $_POST['value'];
                        try {

                        // データベース接続の確認
                        if (!$connection) {
                            die("Connection failed: " . mysqli_connect_error());
                        } else {
                            echo "接続成功.<br>";
                        }

                        // クエリの実行
                        $query = "SELECT cloth_id FROM cloth_table WHERE Tag1 = N'$inValue' OR Tag2 = N'$inValue' OR cloth_kind = N'$inValue'";
                        $statement = $connection->query($query);

                        if ($statement) {
                            echo "Query 成功.<br>";
                            $results = $statement->fetchAll(PDO::FETCH_ASSOC);
                
                            if (count($results) > 0) {
                                foreach ($results as $row) {
                                    echo "Cloth id: " . htmlspecialchars($row['cloth_id']) . "<br>";
                                    $cloth_id = htmlspecialchars($row['cloth_id']);
                                    echo '<img class="image" src=" ' . $cloth_id . ' " alt="cloth Image" "><br>';
                                }
                            } else {
                                echo "見つからなよー.<br>";
                            }
                        } else {
                            echo "Query 無理だ―.<br>";
                        }
                    
                    } catch (PDOException $e) {
                        die("Error connecting to SQL Server: " . $e->getMessage());
                    }
                    }
                        
                    ?>
          
                </div>
            </section>

            <section class="camera">
                <h2 class="topick">カメラ</h2>
                <div class="wrapper">
                <button type="button" onclick="init()">Start</button>
                <div id="webcam-container"></div>
                <div id="label-container"></div>
                
                <script src="main.js"></script>
                </div>
            </section>

                 
        </article> 
    </main>

    <footer>
        <p>&copy;teamtakahashi</p>
    </footer>    
   
</body>
</html>
