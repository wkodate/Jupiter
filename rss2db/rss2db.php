<?php
require_once('/var/www/html/jupiter/Common.php');
require_once(Common::ROOT_DIR . '/DBManager.php');
require_once(Common::ROOT_DIR . '/rss2db/RSSParser.php');
require_once(Common::ROOT_DIR . '/OpenGraph.php');

$lines = file_get_contents(Common::ROOT_DIR . '/rss2db/rssList.txt');
// 改行文字を取り除く
$lines = explode("\n", $lines);

$rssParser = new RSSParser();


$dbManager = new DBManager(Common::DB_NAME, Common::DB_HOST, Common::DB_USER, Common::DB_PASS);

$items = array();
foreach ($lines as $rssUrl) {

    # 空のurlは処理しない
    if (empty($rssUrl)) {
        continue;
    }

    // Parse RSS
    $items = $rssParser->parse($rssUrl);
    sleep(1);

    // Open Graph Protcol Helper
    foreach(items as $item) {
        $item['image'] = OpenGraph::fetch($item['link'])->image;
        sleep(1);
    }

    // To DB
    // TODO まとめて登録できるようにする
    foreach ($items as $item) {
        //$dbManager->registerItems($item, $rssUrl, $graph->image);
    }
}

// Disconnect DB
$dbManager=null;

