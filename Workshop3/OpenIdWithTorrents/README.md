# OpenIdWithTorrents

This simple php implementation lets you log in with a Google OpenId to upload files. Torrents are generated from these files which can then be used for distribution of these files.

This simple prototype requires a couple of things to work.

* Create two directories in the same folder as index.php called "torrents" and "files" which needs to be writable for the user of the webserver.
* Insert the tables from mysql.sql into a db server.
* Change the database information in upload.php line 34 and down
* Change the annonce url in upload.php to match the url of your annonce.php

This example is also used as an example to track down security issues in PHP projects, can you find catch them all? :)