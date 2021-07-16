<?php

// dbConnect関数を持ってくる
require_once(__DIR__ . '/../lib/mysqli.php');

function dropTable($link)
{
    $sql = 'DROP TABLE IF EXISTS reviews';
    $result = mysqli_query($link, $sql);
    if (!$result) {
        echo 'テーブルの削除に失敗しました' . PHP_EOL;
        echo 'Debugging error:' . mysqli_error($link) . PHP_EOL;
    }
}

function createTable($link)
{
    $sql = <<< EOT
    CREATE TABLE reviews (
        id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255),
        author VARCHAR(100),
        status VARCHAR(10),
        evaluation INTEGER,
        summary TEXT,
        created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
    ) DEFAULT CHARACTER SET=utf8mb4;
    EOT;
    $result = mysqli_query($link, $sql);
    if (!$result) {
        echo 'テーブルの作成に失敗しました' . PHP_EOL;
        echo 'Debugging error:' . mysqli_error($link) . PHP_EOL;
    }
}

// dbに接続
$link = dbConnect();
// テーブルがすでに存在していれば削除
dropTable($link);
// テーブルを新規作成
createTable($link);
// dbとの接続を切断
mysqli_close($link);
