#!/usr/bin/env bash

IMAGE=composer:1
COMMAND=$@
OPTS=

case $1 in
install)
	OPTS="--ignore-platform-reqs \
	--prefer-dist \
	--no-interaction \
	--no-scripts"
	;;
dumpautoload)
	OPTS=""
	;;
*)
	echo "USAGE: \"$0 install\" or \"$0 dumpautload\""
	exit 1
esac

docker run \
	--rm \
	-t \
	-v $PWD/:/app/ \
	-v ~/.composer:/tmp \
	$IMAGE \
	composer \
	$COMMAND \
	$OPTS
