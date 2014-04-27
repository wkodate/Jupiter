<?php
require_once('./parser/AbstractParser.php');

class AtomParser extends AbstractParser {

    public function getTitle($item) {
        return $item->title;
    }
    
    public function getLink($item) {
        return $item->link->attribute()->href;
    }

    public function getDescription($item) {
        if (isset($item->content)) {
            return $item->content;
        } else {
            return null;
        }
    }

    public function getDate($item) {
        if (isset($item->published)) {
            return $item->published;
        } else {
            return null;
        }
    }

}
