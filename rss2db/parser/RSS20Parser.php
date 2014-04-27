<?php
require_once('/var/www/rss2db/Common.php');
require_once(Common::ROOT_DIR . '/rss2db/parser/AbstractParser.php');

class RSS20Parser extends AbstractParser {

    public function getTitle($item) {
        return $item->title;
    }
    
    public function getLink($item) {
        return $item->link;
    }

    public function getDescription($item) {
        if (isset($item->description)) {
            return $item->description;
        } else {
            return null;
        }
    }

    public function getDate($item) {
        if (isset($item->pubDate)) {
            return $item->pubDate;
        } else {
            return null;
        }
    }

}
