<?php

// コードサイトスクリプティング対策(ユーザーが書いたjavascriptコードを読み込まないようにする)
function escape($string)
{
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
