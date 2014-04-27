<?php
require_once('/var/www/rss2db/Common.php');
require_once(Common::ROOT_DIR . '/rss2db/RSSParser.php');
require_once(Common::ROOT_DIR . '/rss2db/DBManager.php');

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

