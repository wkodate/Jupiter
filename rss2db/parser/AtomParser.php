<?php
require_once('./parser/AbstractParser.php');

class AtomParser extends AbstractParser {

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
        return null;
        //return (string)$item->children('http://purl.org/dc/elements/1.1/')->date;
    }

}
