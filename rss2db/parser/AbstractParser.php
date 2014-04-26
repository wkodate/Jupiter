<?php

abstract class AbstractParser {

    abstract protected function getTitle($item);
    abstract protected function getLink($item);
    abstract protected function getDescription($item);
    abstract protected function getDate($item);

    public function parse($item) {

        $items['title'] = (string)$this->getTitle($item);
        $items['link'] = (string)$this->getLink($item);
        $items['description'] = (string)$this->getDescription($item);
        $items['date'] = (string)$this->getDate($item);

        return $items;

    }

}
