<?php
require_once('./parser/RSS10Parser.php');
require_once('./parser/RSS20Parser.php');
require_once('./parser/AtomParser.php');

class RSSParser {

    private $rss10Parser;
    private $rss20Parser;
    private $atomParser;

    public function __construct() {

        $this->rss10Parser = new RSS10Parser();
        $this->rss20Parser = new RSS20Parser();
        $this->atomParser = new AtomParser();

    }

    public function parse($url) {

        # 空のurlは処理しない
        if (empty($url)) {
            fputs(STDERR, "Unexpected type: $type\n");
            continue;
        }

        $content = file_get_contents($url);
        $rss = simplexml_load_string($content, 'SimpleXMLElement', LIBXML_NOCDATA);

        # Status codeが200以外は処理しない
        $statusCode = $http_response_header[0];
        if (strpos($statusCode, '200') == false) {
            fputs(STDERR, "Unexpected status code: $statusCode\n");
            continue;
        }

        $type = $rss->getName();
        if ($type == 'RDF') {
            foreach ($rss->item as $item) {
                echo $this->rss10Parser->parse($item) . "\n";
            }
        } else if ($type == 'rss') {
            foreach ($rss->channel->item as $item) {
                echo $this->rss20Parser->parse($item) . "\n";
            }
        } else if ($type == 'feed') {
            foreach ($rss->entry as $item) {
                echo $this->atomParser->parse($item) . "\n";
            }
        } else {
            fputs(STDERR, "Unexpected type: $type\n");
        }
    }

}





