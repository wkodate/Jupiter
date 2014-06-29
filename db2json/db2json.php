<?php
require_once('/var/www/html/jupiter/Common.php');
require_once(Common::ROOT_DIR . '/DBManager.php');

define('NUM_OF_ITEMS', 200);

$dbManager = new DBManager(Common::DB_NAME, Common::DB_HOST, Common::DB_USER, Common::DB_PASS);

// Get RSS item
$items = $dbManager->getItems(NUM_OF_ITEMS);
echo json_encode($items);

$file = '/var/www/html/jupiter/index.json';
$fp = fopen($file, 'a');
fwrite($fp, sprintf(json_encode($items)));
fclose($fp);

// Disconnect DB
$dbManager=null;

