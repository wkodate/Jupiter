<?php
require_once('/var/www/html/jupiter/Common.php');
require_once(Common::ROOT_DIR . '/DBManager.php');
require_once(Common::ROOT_DIR . '/rss2db/RSSParser.php');
require_once(Common::ROOT_DIR . '/rss2db/opengraph/OpenGraph.php');

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

    $updated = false;
    foreach($items as $item) {
        // データベースに既に存在すれば次の処理へスキップ
        if ($dbManager->itemExists($item['link'])) {
            fputs(STDOUT, '[SKIP] ' . $item['link'] . " is already existed.\n");
            continue;
        }
        $updated = true;
        // Open Graph Protcol Helper
        $graph = OpenGraph::fetch($item['link']);
        // imageタグが存在すれば取得
        $item['image'] = '';
        if(isset($graph->image)) {
            $item['image'] = $graph->image;
        }
        // To DB
        // TODO まとめて登録できるようにする
        //$dbManager->registerItems($item, $rssUrl);
        fputs(STDOUT, '[UPDATE] ' . $item['link'] . "\n");
        sleep(1);
    }
    // 1件も更新がなければsleep
    if(!$updated) {
        sleep(1);
    }

}

// Disconnect DB
$dbManager=null;

