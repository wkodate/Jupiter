<?php

class TopicsAPI {

    private $url;

    public function __construct($appId) {

        $this->url = sprintf(
            "http://news.yahooapis.jp/NewsWebService/V2/topics"
            . "?appid=%s"
            . "&category=sports"
            . "&pickupcategory=sports", 
            $appId
        );

    }

    public function getAPIResponse() {
        
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, $this->url); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        // TODO HTTPResponseのstatus確認
        $response = curl_exec($ch); 
        curl_close($ch); 

        return $response;

    }

    public function extractBaseballTopic($xml) {

        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->preserveWhiteSpace = false;
        $dom->validateOnParse = true;
        $dom->loadXML($xml);

        $topics = array();
        $resultsetNode = $dom->getElementsByTagName("ResultSet")->item(0);

        $resultNode = $resultsetNode->getElementsByTagName("Result");
        foreach ($resultNode as $result) {
            $id = $result->getElementsByTagName("HeadlineId")->item(0)->nodeValue;
            $category = $result->getElementsByTagName("SubCategory")->item(0)->nodeValue;
            if ($category != '野球') {
                continue;
            }
            $topics[$id]['category'] = $category;
            $topics[$id]['title']    = $result->getElementsByTagName("Title")->item(0)->nodeValue;
            $topics[$id]['date']     = $result->getElementsByTagName("DateTime")->item(0)->nodeValue;
            $topics[$id]['link']     = $result->getElementsByTagName("Url")->item(0)->nodeValue;
            $topics[$id]['pv']       = $result->getElementsByTagName("PvIndex")->item(0)->nodeValue;
        }

        return $topics;

    }

}
