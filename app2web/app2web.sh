#!/bin/sh

mysql -h localhost -u root -ppassword -e "insert ignore into jupiter_web.items(link, title, description, date, image, rss_url) select link, title, description, date, image, rss_url from jupiter.items where DATE_ADD(date, INTERVAL 30 MINUTE) > NOW(); update jupiter_web.items as i, jupiter_web.rsses as r set i.rss_id = r.id where DATE_ADD(i.date, INTERVAL 30 MINUTE) > NOW()  and i.rss_url = r.rss_url;"
