#!/bin/bash

TARGET='http://static.xvideos.com/xvideos.com-db.csv.zip';

cd /tmp/
mkdir xvideos-downloader
cd xvideos-downloader/

wget -q --tries=20 --retry-connrefused --output-document=xvdb.zip --timestamping --continue $TARGET
unzip -d . -o xvdb.zip

XVCSV=`find . -name '*.csv'`

cd /var/www/html/crawler

php xvideos-csv-parser.php /tmp/xvideos-downloader/$XVCSV
