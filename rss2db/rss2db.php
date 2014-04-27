<?php
require_once('./RSSParser.php');
require_once('./DBManager.php');

$lines = file_get_contents('./rssList.txt');
// 改行文字を取り除く
$lines = explode("\n", $lines);

$rssParser = new RSSParser();

$dbname = 'jupiter';
$host = 'localhost';
$user = 'jupiter';
$pass = 'jupiter';

$dbManager = new DBManager($dbname, $host, $user, $pass);

$items = array();
foreach ($lines as $rssUrl) {

    # 空のurlは処理しない
    if (empty($rssUrl)) {
        continue;
    }

    // Parse RSS
    $items = $rssParser->parse($rssUrl);

    // To DB
    foreach ($items as $item) {
        $dbManager->registerItems($item, $rssUrl);
    }
}

// Disconnect DB
$dbManager=null;

