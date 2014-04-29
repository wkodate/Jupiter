<?php
require_once('/var/www/html/jupiter/Common.php');
require_once(Common::ROOT_DIR . '/rss2db/parser/RSS10Parser.php');
require_once(Common::ROOT_DIR . '/rss2db/parser/RSS20Parser.php');
require_once(Common::ROOT_DIR . '/rss2db/parser/AtomParser.php');

class RSSParser {

    private $rss10Parser;
    private $rss20Parser;
    private $atomParser;
    private $items;

    public function __construct() {

        $this->rss10Parser = new RSS10Parser();
        $this->rss20Parser = new RSS20Parser();
        $this->atomParser = new AtomParser();
        $this->items = array();

    }

    public function parse($url) {

        $content = file_get_contents($url);
        $rss = simplexml_load_string($content, 'SimpleXMLElement', LIBXML_NOCDATA);

        # Status codeが200以外は処理しない
        $statusCode = $http_response_header[0];
        if (strpos($statusCode, '200') == false) {
            fputs(STDERR, "Unexpected status code: $statusCode\n");
            return;
        }

        $type = $rss->getName();
        if ($type == 'RDF') {
            foreach ($rss->item as $item) {
                array_push($this->items, $this->rss10Parser->parse($item));
            }
        } else if ($type == 'rss') {
            foreach ($rss->channel->item as $item) {
                array_push($this->items, $this->rss20Parser->parse($item));
            }
        } else if ($type == 'feed') {
            foreach ($rss->entry as $item) {
                array_push($this->items, $this->atomParser->parse($item));
            }
        } else {
            fputs(STDERR, "Unexpected type: $type\n");
        }
        return $this->items;
    }

}

