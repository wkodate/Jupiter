<?php

abstract class RSSParser {
    abstract function getTitle($item);
    abstract function getLink($item);
    abstract function getDescription($item);
    abstract function getDate($item);
}
