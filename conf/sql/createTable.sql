CREATE TABLE rss (rss_url varchar(255) NOT NULL PRIMARY KEY, title varchar(255) NOT NULL, site_link varchar(255) NOT NULL, description text, created datetime, modified datetime); 
CREATE TABLE items (link varchar(255) NOT NULL PRIMARY KEY, title varchar(255) NOT NULL, description text, date datetime, rss_url varchar(255), created datetime, modified datetime); 
