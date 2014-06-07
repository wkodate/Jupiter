<?php
require_once('/var/www/html/jupiter/Common.php');
require_once(Common::ROOT_DIR . '/rss2db/parser/AbstractParser.php');

class RSS10Parser extends AbstractParser {

    Const DC_NAMESPACE = 'http://purl.org/dc/elements/1.1/';

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
            return "";
        }
    }

    public function getDate($item) {
        if (isset($item->children(self::DC_NAMESPACE)->date)) {
        return $item->children(self::DC_NAMESPACE)->date;
        } else {
            return "";
        }
    }

}
