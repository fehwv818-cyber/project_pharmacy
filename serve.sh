#!/bin/bash
DIR="$(cd "$(dirname "$0")" && pwd)"
export LD_LIBRARY_PATH="${DIR}/.php-libs:$LD_LIBRARY_PATH"
export PHP_INI_SCAN_DIR=":${DIR}/.php-ini"
exec /usr/bin/php "$@"
