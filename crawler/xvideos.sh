#!/bin/bash

TARGET='http://static.xvideos.com/xvideos.com-db.csv.zip';

cd /tmp/
mkdir xvideos-downloader
cd xvideos-downloader/

wget --tries=20 --retry-connrefused --timestamping --continue $TARGET

cd /var/www/html/crawler

# parallel unzip - parse
unzip -p /tmp/xvideos-downloader/xvideos.com-db.csv.zip | php xvideos-csv-parser.php php://stdin

