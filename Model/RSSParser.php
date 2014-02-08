<?php

require_once '../magpierss/rss_fetch.inc';

class RSSParser {

    private $rss;
    private $items;

    public function __construct($rssUrl) 
    {
        $this->rss = fetch_rss($rssUrl);
        $this->items = $this->rss->items;
    }

    public function getChannelFields() {
        echo $this->getChannelTitle($this->rss) . "\n";
        echo $this->getChannelLink($this->rss) . "\n";
        echo $this->getChannelDesc($this->rss) . "\n";
        echo "\n";
    }

    public function getChannelTitle() 
    {
        return $this->rss->channel['title'];
    }

    public function getChannelLink() 
    {
        return $this->rss->channel['link'];
    }

    public function getChannelDesc() 
    {
        return $this->rss->channel['description'];
    }

    public function getItemFields() {
        foreach ($this->items as $item) {
            echo $this->getItemTitle($item) . "\n";
            echo $this->getItemLink($item) . "\n";
            echo $this->getItemDesc($item) . "\n";
            $date = $this->getItemDate($item);
            if ($date) echo $date . "\n";
        }
    }

    public function getItemTitle($item) 
    {
        return $item['title'];
    }

    public function getItemLink($item) 
    {
        return $item['link'];
    }

    public function getItemDesc($item) 
    {
        return $item['description'];
    }

    public function getItemDate($item) 
    {
        $date = $item['dc']['date'];
        if (!$date) {
            $date = $item['date_timestamp'];
        }
        return $date;
    }

}
