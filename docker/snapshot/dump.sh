#!/bin/sh

now=$(date +'%Y%m%d%H%I%S') &&
  mysqldump -hmysql8 -uroot -ppassword102 origamiez >/tmp/snapshot/backup-"${now}".sql
