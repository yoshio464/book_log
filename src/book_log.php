<?php

function dbConnect()
{
    //データベースと接続
    $link = mysqli_connect('db', 'book_log', 'pass', 'book_log');
    // データベースのエラー処理
    if (!$link) {
        echo 'データベースとの接続に失敗しました' . PHP_EOL;
        echo 'Debugging error:' . mysqli_connect_error() . PHP_EOL;
    }
    echo 'データベースと接続しました' . PHP_EOL;
    return $link;
}

$link = dbConnect();

$number = '';

// バリデーション
function validate($review)
{
    $errors = [];
    // 書籍名のバリデーション
    if (!mb_strlen($review['title'])) {
        $errors['title'] = '書籍名を入力してください';
    } elseif (mb_strlen($review['title']) > 255) {
        $errors['title'] = '書籍名は255文字以内で入力してください';
    }
    // 著者名のバリデーション
    if (!mb_strlen($review['author'])) {
        $errors['author'] = '著者名を入力してください';
    } elseif (mb_strlen($review['author']) > 100) {
        $errors['author'] = '著者名は100文字以内で入力してください';
    }
    // 読書状況のバリデーション
    // if ($review['status'] !== '未読' && $review['status'] !== '読んでいる' && $review['status'] !== '読了') {
    $correctStatus = ['未読', '読んでいる', '読了'];
    if (!in_array($review['status'], $correctStatus, true)) {
        $errors['status'] = '読書状況は書式に従って入力してください';
    }
    // }
    // 評価のバリデーション
    if ((int) $review['evaluation'] <= 0 || (int) $review['evaluation'] > 5) {
        $errors['evaluation'] = '評価は1から5までの整数で入力してください';
    }
    // 感想のバリデーション
    if (!mb_strlen($review['summary'])) {
        $errors['summary'] = '感想を入力してください';
    }
    return $errors;
    //
}

// メニューを表示
function displayMenu()
{
    echo '1．読書ログを登録' . PHP_EOL;
    echo '2．読書ログを表示' . PHP_EOL;
    echo '9．アプリケーションを終了' . PHP_EOL;
    echo '番号を選択してください（1,2,9）:';
}
// 読書ログの登録
function createReview($link)
{
    $review = [];
    echo '読書ログを登録してください' . PHP_EOL;
    echo '書籍名:';
    $review['title'] = trim(fgets(STDIN));
    echo '著者名:';
    $review['author'] = trim(fgets(STDIN));
    echo '読書状況（未読、読んでいる、読了）:';
    $review['status'] = trim(fgets(STDIN));
    echo '評価（5点満点の整数）:';
    $review['evaluation'] = trim(fgets(STDIN));
    echo '感想:';
    $review['summary'] = trim(fgets(STDIN));

    // バリデーション処理
    $validations = validate($review);
    if (count($validations) > 0) {
        foreach ($validations as $error) {
            echo $error . PHP_EOL;
        }
        return;
    }

    // テーブルへの追加
    $sql = <<<EOT
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
    $result = mysqli_query($link, $sql);
    if (!$result) {
        echo 'Debugging error:' . mysqli_error($link) . PHP_EOL;
    }

    echo '登録が完了しました' . PHP_EOL;
    echo '-----------' . PHP_EOL;
    // return [
    //     'title' => $title,
    //     'author' => $author,
    //     'status' => $status,
    //     'evaluation' => $evaluation,
    //     'summary' => $summary
    // ];
}
// 読書ログの表示
function displayReview($link)
{
    $sql = 'SELECT title, author, status, evaluation, summary FROM reviews';
    // sql文の実行
    $result = mysqli_query($link, $sql);
    while ($reviews = mysqli_fetch_assoc($result)) {
        echo '書籍名:' . $reviews['title'] . PHP_EOL;
        echo '著者名:' . $reviews['author'] . PHP_EOL;
        echo '読書状況（未読、読んでいる、読了）:' . $reviews['status'] . PHP_EOL;
        echo '評価（5点満点の整数）:' . $reviews['evaluation'] . PHP_EOL;
        echo '感想:' . $reviews['summary'] . PHP_EOL;
        echo '-----------' . PHP_EOL;
    }
    // メモリの解放
    mysqli_free_result($result);
}
// 選択した番号に応じて条件分岐。かつ、読書ログを表示できるように繰り返し処理
while ($number !== '9') {
    // メニュー
    displayMenu();

    $number = trim(fgets(STDIN));

    if ($number === '1') {
        // 読書ログの登録
        createReview($link);
    } elseif ($number === '2') {
        echo '読書ログを表示します' . PHP_EOL;
        // 全読書ログを表示できるように、繰り返し処理
        displayReview($link);
    }
}

// データベースと切断
mysqli_close($link);
echo 'データベースとの切断に成功しました' . PHP_EOL;
