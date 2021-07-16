<?php

// mysqlに関係する共通の関数
require __DIR__ . '/../vendor/autoload.php';

function dbConnect()
{
    // .envファイルから環境変数を持ってくる
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();
    $dbHost = $_ENV['DB_HOST'];
    $dbUsername = $_ENV['DB_USERNAME'];
    $dbPassword = $_ENV['DB_PASSWORD'];
    $dbDatabase = $_ENV['DB_DATABASE'];

    $link = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbDatabase);
    // 接続時のエラー処理
    if (!$link) {
        echo 'データベースとの接続に失敗しました' . PHP_EOL;
        echo 'Debugging error:' . mysqli_connect_error() . PHP_EOL;
    }
    return $link;
}
