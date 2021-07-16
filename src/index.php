<?php

require_once('lib/mysqli.php');
require_once('lib/escape.php');
// データベースに接続
$link = dbConnect();
function listReview($link)
{
    // データを配列として取得
    $sql = 'SELECT title, author, status, evaluation, summary FROM reviews';
    $results = mysqli_query($link, $sql);
    $reviews = [];

    if ($results) {
        while ($result = mysqli_fetch_assoc($results)) {
            $reviews[] = $result;
        }
    } else {
        // データ取得エラー処理
        error_log('fail to select from data');
        error_log('Debugging error:' . mysqli_error($link));
    }
    // メモリの解放
    mysqli_free_result($results);
    return $reviews;
}
$reviews = listReview($link);

$title = '読書ログ一覧';
$content = __DIR__ . '/views/index.php';
include __DIR__ . '/views/layout.php';
