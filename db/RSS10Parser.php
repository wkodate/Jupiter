<?php
require_once('./RSSParser.php');

class RSS10Parser extends RSSParser {

    private $title;
    private $link;
    private $description;
    private $date;

    public function getTitle($item) {
        return $item->title;
    }
    
    public function getLink($item) {
        return $item->link;
    }

    public function getDescription($item) {
        return $item->description;
    }

    public function getDate($item) {
        return (string)$item->children('http://purl.org/dc/elements/1.1/')->date;
    }

}
