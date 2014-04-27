<?php

require_once 'secret.php';
require_once 'TopicsAPI.php';

$topicsApi = new TopicsAPI($appId);
$response = $topicsApi->getAPIResponse();
$topics = $topicsApi->extractBaseballTopic($response);
