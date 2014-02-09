<?php

require_once 'secret.php';
require_once '../Model/TopicsAPI.php';

$topicsApi = new TopicsAPI($appId);
$response = $topicsApi->getAPIResponse();
$topics = $topicsApi->extractBaseballTopic($response);
//print_r($topics);


require_once '../View/index.html';
