#!/bin/bash
rm -rf ./sf-application-mdk-webapp
git clone git@github.com:RePetFFM/sf-application-mdk-webapp.git
cp /srv/git/backup/apache/certs/*.* /srv/git/sf-application-mdk-webapp/docker/apache/certs/