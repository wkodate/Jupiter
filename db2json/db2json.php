<?php
require_once('/var/www/html/jupiter/Common.php');
require_once(Common::ROOT_DIR . '/DBManager.php');

define('NUM_OF_ITEMS', 50);

$dbManager = new DBManager(Common::DB_NAME, Common::DB_HOST, Common::DB_USER, Common::DB_PASS);

// Get RSS item
$items = $dbManager->getItems(NUM_OF_ITEMS);
echo json_encode($items);

// Disconnect DB
$dbManager=null;

