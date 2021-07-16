<?php

$link = mysqli_connect('db', 'book_log', 'pass', 'book_log');

// データベースとの接続のエラー処理
if (!$link) {
    echo 'データベースとの接続に失敗しました' . PHP_EOL;
    echo 'Debugging error:' . mysqli_connect_error() . PHP_EOL;
    exit;
}

$sql = 'SELECT title, author FROM reviews';

$results = mysqli_query($link, $sql);

while ($reviews = mysqli_fetch_assoc($results)) {
    echo '書籍名:' . $reviews['title'] . PHP_EOL;
    echo '著書名:' . $reviews['title'] . PHP_EOL;
}

// メモリの解放
mysqli_free_result($results);

// $sql = <<<EOT
// INSERT INTO reviews (
//     title,
//     author,
//     status,
//     evaluation,
//     summary
// ) VALUES (
//     'attack on titan',
//     'hajime isayama',
//     'complete',
//     4,
//     'this is too interesting'
// );
// EOT;

// echo 'データベースとの接続に成功しました' . PHP_EOL;

// // テーブルにデータを追加
// $result = mysqli_query($link, $sql);
// var_dump($result);
// // データ追加時のエラー処理
// if ($result) {
//     echo 'テーブルへのデータ追加に成功しました' . PHP_EOL;
// } else {
//     echo 'テーブルへのデータ追加に失敗しました' . PHP_EOL;
//     echo 'Debugging error:' . mysqli_error($link) . PHP_EOL;
// }


mysqli_close($link);
echo 'データベースとの切断に成功しました' . PHP_EOL;
