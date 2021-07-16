<?php

// 配列の中身が無いことによるエラーを回避
$errors = [];
$review = [
    'title' => '',
    'author' => '',
    'status' => '未読',
    'evaluation' => '',
    'summary' => ''
];

$title = '読書ログの登録';
$content = __DIR__ . '/views/new.php';
include __DIR__ . '/views/layout.php';
