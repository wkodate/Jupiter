<?php
require_once('./parser/AbstractParser.php');

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
