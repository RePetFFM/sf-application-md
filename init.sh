#!/bin/sh

mkdir -p docker/apache/certs
rm ./docker/apache/certs/*.*

FILE=~/.adv-dev/localdev-cert/server.key
if [ -f "$FILE" ]; then
    echo "$FILE exists."
else 
    echo "$FILE does not exist."
    mkdir -p ~/.adv-dev/localdev-cert
    openssl req -x509 -newkey rsa:4096 -sha256 -nodes -keyout ~/.adv-dev/localdev-cert/server.key -out ~/.adv-dev/localdev-cert/server.crt -subj "/CN=localhost" -days 3650
fi

cp ~/.adv-dev/localdev-cert/server.* ./docker/apache/certs
