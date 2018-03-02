<?php
error_reporting(E_ALL ^ E_STRICT);
require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use DmmSearch\Sample\SearchSample;

$dotEnv = new Dotenv(__DIR__ . '/../');
$dotEnv->load();

$appId = getenv('API_ID');
$affiliateId = getenv('AFFILIATE_ID');

$dmm = new SearchSample($appId, $affiliateId);
// 商品情報を取得する
$items = $dmm->getSearchItemsByKeyword('ポプテピピック');
?>
<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DMM Search</title>
    <link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/pure-min.css">
</head>
<body>
DMM web APIを使って遊んでみた 検索ワード：ポプテピピック
<div class="pure-g">
    <div class="pure-u-1">
        <table class="pure-table pure-table-horizontal">
            <thead>
            <tr>
                <th>商品ID</th>
                <th>画像</th>
                <th>タイトル</th>
                <th>URL</th>
            </tr>
            </thead>
            <tbody>
                <?php
                    foreach ($items['result']['items'] as $item) {
                        $img_src = $item['imageURL']['small'] ?? 'https://placehold.jp/150x150.png';
                        print '<tr>';
                        print '<td>' . $item['content_id'] . '</td>';
                        print '<td><img src="' . $img_src . '"></td>';
                        print '<td>' . $item['title'] . '</td>';
                        print '<td><a href="' . $item['URL'] . '">' . $item['URL'] . '</a></td>';
                        print '</tr>';
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
