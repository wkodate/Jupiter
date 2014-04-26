<?php
require_once('./parser/AbstractParser.php');

class RSS20Parser extends AbstractParser {

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
        return $item->pubDate;
    }

}
