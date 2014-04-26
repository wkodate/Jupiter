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
        return $item->link->attribute()->href;
    }

    public function getDescription($item) {
        return $item->content;
    }

    public function getDate($item) {
        return null;
        return $item->published;
    }

}
