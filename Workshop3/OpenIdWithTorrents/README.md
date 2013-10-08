# OpenIdWithTorrents

This crude php implementation lets you log in with a Google OpenId to upload files for distritbution trough a torrent tracker. The system generates a torrent for every file that is uploaded.

## Setup instructions
In order to run this on your own webserver, go trough the list.

* Create two directories in the same folder as index.php called "torrents" and "files". These needs to be writeable by the user that runs the webserver (For Ubuntu this means user www-data needs permission 740)
* Insert the tables from mysql.sql into your database server.
* Change the database information in upload.php line 34 and down and announce.php
* Change the annonce url in upload.php (line 43) to match the url of your annonce.php


Do not use this project in production, it is just a proof of concept.