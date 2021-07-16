<?php

// dbConnect関数を持ってくる
require_once(__DIR__ . '/lib/mysqli.php');

function createReview($link, $review)
{
    $query = <<< EOT
INSERT INTO reviews (
    title,
    author,
    status,
    evaluation,
    summary
) VALUES (
    "{$review['title']}",
    "{$review['author']}",
    "{$review['status']}",
    "{$review['evaluation']}",
    "{$review['summary']}"
)
EOT;
    $result = mysqli_query($link, $query);
    if (!$result) {
        error_log('fail to create review');
        error_log('Debugging error:' . mysqli_error($link));
    }
}

function validate($review)
{
    $errors = [];
    // 書籍名
    if (!mb_strlen($review['title'])) {
        $errors['title'] = '書籍名を入力してください';
    } elseif (!mb_strlen($review['title']) > 255) {
        $errors['title'] = '書籍名は255文字以内で入力してください';
    }
    // 著者名
    if (!mb_strlen($review['author'])) {
        $errors['author'] = '著者名を入力してください';
    } elseif (!mb_strlen($review['author']) > 255) {
        $errors['author'] = '著者名は100文字以内で入力してください';
    }
    // 読書状況
    $statuses = ['未読', '読んでいる', '読了'];
    if (!in_array($review['status'], $statuses, true)) {
        $errors['status'] = '読書状況を書式に従って入力してください';
    }
    // 評価
    if (!mb_strlen($review['evaluation'])) {
        $errors['evaluation'] = '評価を入力してください';
    } elseif ((int) $review['evaluation'] <= 0 || (int) $review['evaluation'] > 5) {
        $errors['evaluation'] = '評価は1から5までの整数で入力してください';
    }
    // 感想
    if (!mb_strlen($review['summary'])) {
        $errors['summary'] = '感想を入力してください';
    }
    return $errors;
}

// HTTPメソッドがPOSTだったら
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // statusボタンは何も選ばれていないと、エラーを返すから事前に空文字を宣言
    $status = '';
    if (array_key_exists('status', $_POST)) {
        $status = $_POST['status'];
    }

    // POSTされた情報を変数に格納
    $review = [
        'title' => $_POST['title'],
        'author' => $_POST['author'],
        'status' => $status,
        'evaluation' => $_POST['evaluation'],
        'summary' => $_POST['summary'],
    ];
    // バリデーションする
    $errors = validate($review);
    if (!count($errors)) {
        // データベースに接続
        $link = dbConnect();
        // データベースにデータを登録
        createReview($link, $review);
        // データベースとの接続を切断
        mysqli_close($link);
        // トップページへリダイレクトさせる
        header('Location: index.php');
    }
}

// 共通化したhtmlファイルを読み込む
$title = '読書ログの登録';
$content = __DIR__ . '/views/new.php';
include __DIR__ . '/views/layout.php';
