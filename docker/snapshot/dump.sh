#!/bin/sh

now=$(date +'%Y%m%d%H%I%S') &&
  mysqldump -hmysql8 -uroot -psecret origamiez >/tmp/snapshot/backup-"${now}".sql
