<?php

abstract class AbstractRSSParser {

    abstract protected function getTitle($item);
    abstract protected function getLink($item);
    abstract protected function getDescription($item);
    abstract protected function getDate($item);

    public function parse($item) {

        echo $this->getTitle($item), PHP_EOL;
        echo $this->getLink($item), PHP_EOL;
        echo $this->getDescription($item), PHP_EOL;
        echo $this->getDate($item), PHP_EOL;

    }

}
