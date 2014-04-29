<?php

class DBManager {

    private $pdo;

    public function __construct($dbname, $host, $user, $pass) {
        try {
            $this->pdo = new PDO(
                "mysql:dbname=$dbname;host=$host", 
                $user, 
                $pass, 
                array(
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::MYSQL_ATTR_READ_DEFAULT_FILE => '/etc/my.cnf',));
            $this->pdo->query("SET NAMES utf8");
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function registerItems($item, $rssUrl) {
        if($this->itemExists($item['link'])) {
            // 既に存在していれば更新
            $this->updateItems($item, $rssUrl);
        } else {
            $this->insertItems($item, $rssUrl);
        }
    }

    public function itemExists($link) {
        $stmt = $this->pdo->prepare(implode(' ', array(
            'SELECT link',
            'FROM items',
            'WHERE link = ?',
            'LIMIT 1',
        )));
        $stmt->execute(array($link));
        return (bool)$stmt->fetch();
    }

    public function insertItems($item, $rssUrl) {
        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare(implode(' ', array(
                'INSERT',
                'INTO items(link, title, description, date, rss_url, created, modified)',
                'VALUES (?, ?, ?, ?, ?, NOW(), NOW())',
            )));
            $stmt->execute(array(
                $item['link'], 
                $item['title'], 
                $item['description'], 
                $item['date'], 
                $rssUrl));
            $id = $this->pdo->lastInsertId();
            $this->pdo->commit();
            return $id;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    public function updateItems($item, $rssUrl) {
        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare(implode(' ', array(
                'UPDATE',
                'items SET title=?, description=?, date=?, rss_url=?, modified=NOW()',
                'WHERE link = ?'
            )));
            $stmt->execute(array(
                $item['title'], 
                $item['description'], 
                $item['date'], 
                $rssUrl, 
                $item['link']));
            $id = $this->pdo->lastInsertId();
            $this->pdo->commit();
            return $id;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    public function getItem($url) {
        $stmt = $this->pdo->prepare(implode(' ', array(
            'SELECT *',
            'FROM items',
            'WHERE link = ?',
            'LIMIT 1',
        )));
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getItems($limit) {
        $stmt = $this->pdo->prepare(implode(' ', array(
            'SELECT *',
            'FROM items',
            'ORDER BY date DESC',
            'LIMIT ?',
        )));
        $stmt->execute(array($limit));
        return $stmt->fetchAll();
    }

}
