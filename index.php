<?php include 'db.php'; ?>
<?php session_start(); ?>
<? 
echo "php";
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
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
    </style>
    <title>今日の服</title>
</head>
<body>
    <header alt="top">
        <img src="kyo-no-wanko.png" alt="header_img" style="max-width: 100%; height: auto;">
        <h1>今日の服</h1>
        <!-- タイトル -->
        <hr>
        <nav class="manu"
            <ol>
                <li class="crumb"><a href="#top">top</a></li>
                <li class="crumb"><a href="#recommendation">おすすめ</a></li>
                <li class="crumb"><a href="#search">コーデ検索</a></li>
            </ol>
        </nav>
        <!-- ナビゲーション -->
    </header>

    <main>
        <article>
            <section class="recommendation" alt="recommendation">
                <!-- おすすめ -->
                <div class="wrapper">
                    <h2>おすすめコーデ</h2>
                    <p>今日のおすすめコーデ</p>

                    <img src="fuku1.png" alt="" style="max-width: 50%; height: auto;">


                </div>
            </section>

            <section class="search" alt="search">
                <!-- 検索 -->
                <div class="wrapper">
                    <form action="" method="POST">
                        <label for="">検索</label>
                        <input type="text" name="value">                        
                        <input type="submit" value="submit">
                    </form>
                    <?php 
                    echo $_POST["value"] 
                    ?>

                </div>
            </section>

            <section class="camera">
                <div class="wrapper">
                <button type="button" onclick="init()">Start</button>
                <div id="webcam-container"></div>
                <div id="label-container"></div>
                <script src="weather.js"></script>
                <script src="main.js"></script>

                </div>
            </section>

            <div class="closet">
                <!-- クローゼット -->

                <button onclick="location.href='closet.php'">クローゼット</button>                 
                <!-- <a href="closet.php" class="button"><input type="button">クローゼット</a> -->

            </div>
            
            <div class="coordination">
                <!-- コーディネート -->
                 <button onclick="location.href='coordination'">Myコーデ</button>
                <!-- <a href="coordination.php" class="button">Myコーデ</a> -->
            </div>            
        </article> 
    </main>

    <footer>
        <p>&copy;teamtakahashi</p>
    </footer>    
</body>
</html>
